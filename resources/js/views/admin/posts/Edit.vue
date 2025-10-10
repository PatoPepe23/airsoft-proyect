<template>
    <div class="card">
        <DataTable :value="playersData"  ref="dt"
                   v-model:filters="filters"
                   :globalFilterFields="['nombrecompleto' , 'name','DNI','mail']"
                   tableStyle="min-width: 50rem">
            <template #header>
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <span class="text-xl font-bold">Jugadores</span>
                    <span class="text-xl">{{ formatDate(route.query.date) }}</span>
                    <Button icon="pi pi-refresh" rounded raised @click="handleRefresh" />
                    <Button icon="pi pi-plus" rounded raised @click="openAddPlayerDialog" />
                    <Button icon="pi pi-external-link" label="Export" @click="exportCSV($event)" />
                    <span class="text-xl">{{playersData.filter(player => player.status === 'Dentro').length + ' / ' + playersData.length + ' Jugadores dentro'}}</span>
                    <InputText v-model="filters['global'].value" placeholder="Buscar ..." />
                </div>
            </template>

            <column header="Opciones">
                <template #body="player">
                    <button @click.prevent.stop="playerCheck(player.data.DNI, route.params.id, player.data.name, player.data.income, player.data.player_id, player.data.status)"
                            class="btn btn-success btn-sm ms-2">{{ player.data.status === 'Dentro' ? 'Sacar' : 'Verificar' }}
                    </button>
                    <button @click.prevent.stop="deletePost(false, player.data.DNI, route.query.date, 'dunkerque.airsoftcamp@gmail.com')"
                            class="btn btn-danger btn-sm ms-2">Eliminar
                    </button>
                </template>
            </column>

            <Column field="name" sortable header="Jugador"></Column>
            <Column field="DNI" sortable header="DNI"></Column>

            <Column field="income" sortable header="Importe">
                <template #body="player">
                    <button @click.prevent.stop="playerChange(player.data.DNI, route.params.id, player.data.name, player.data.player_id, player.data.income === 15)"
                            class="btn btn-success btn-sm ms-2">{{ player.data.income === 15 ? 'Normal' : 'Alquiler' }}
                    </button>
                </template>
            </Column>

            <Column field="mail" header="Correo"></Column>
            <Column field="phone" header="Telefono"></Column>
            <Column field="team" header="Equipo"></Column>

            <Column field="status" sortable header="Status">
                <template #body="player">
                    {{ player.data.status === 'Dentro' ? 'Dentro' : 'Fuera' }}
                </template>
            </Column>

            <router-link :to="'/admin/posts/'" style="width:100px;margin-right:20px;padding:18px 20px;background-color: lightgreen;border-radius: 50%;color: #333;"><i class="pi pi-arrow-left"></i></router-link>
            <button @click="openCamera" class="btn btn-primary">Abrir Cámara</button><button @click="closeCamera" class="btn btn-danger">Cerrar Cámara</button>

            <div v-if="isCameraOpen" class="camera-container">
                <qrcode-stream @detect="onDetect"></qrcode-stream>
            </div>
        </DataTable>

        <Dialog v-model:visible="displayAddPlayerDialog" header="Agregar Nuevo Jugador" modal class="p-fluid">
            <div class="field">
                <label for="dni">DNI</label>
                <InputText id="dni" v-model="newPlayer.DNI" required autofocus />
            </div>
            <div class="field">
                <label for="nombrecompleto">Nombre Completo</label>
                <InputText id="nombrecompleto" v-model="newPlayer.nombrecompleto" required />
            </div>

            <div class="field-checkbox">
                <label for="alquiler">Alquiler</label>
                <Checkbox id="alquiler" v-model="newPlayer.alquiler" :binary="true" />
            </div>

            <template #footer>
                <Button label="Cancelar" icon="pi pi-times" class="p-button-text" @click="displayAddPlayerDialog = false" />
                <Button label="Agregar" icon="pi pi-check" @click="addPlayer" />
            </template>
        </Dialog>
    </div>
</template>

<script setup>
import {ref, onMounted, inject} from 'vue';
import { useRoute } from 'vue-router';
import usePosts from '@/composables/posts';
import { QrcodeStream, QrcodeDropZone, QrcodeCapture } from 'vue-qrcode-reader';
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import Checkbox from 'primevue/checkbox';
import { FilterMatchMode, FilterOperator } from '@primevue/core/api';

const swal = inject('$swal');
const dt = ref();

const {playerChange, playerCheck, getPost, playersData, deletePost } = usePosts();
const route = useRoute();

const isCameraOpen = ref(false);
const scannedCode = ref(null);
const displayAddPlayerDialog = ref(false);

const newPlayer = ref({
    DNI: '',
    nombrecompleto: '',
    telefono: '',
    email: '',
    team: '',
    alquiler: false,
    dentro: false,
    shift: false
});

const filters = ref({
        global: { value: null, matchMode: FilterMatchMode.CONTAINS },
        nombrecompleto: { operator: FilterOperator.OR, constraints: [{ value: null, matchMode: FilterMatchMode.EQUALS }] },
        DNI: { operator: FilterOperator.OR, constraints: [{ value: null, matchMode: FilterMatchMode.EQUALS }] }
    });

const exportCSV = () => {
    // 1. Clonar los datos para no modificar el original
    playersData.value.forEach(item => {
        item.income = item.income === 15 ? 'Normal' : 'Alquiler';
        item.status = item.status === 'Dentro' ? 'Dentro' : 'Fuera';
    });

    // 2. Llamar al método de exportación sin parámetros.
    // Esto exportará los datos que ya están modificados en la tabla.
    dt.value.exportCSV();

    loadPlayerData();
};

const openCamera = () => {
    isCameraOpen.value = true;
};

const closeCamera = () => {
    isCameraOpen.value = false;
};

const onDetect = (decodedString) => {
    const dni = decodedString[0].rawValue; // El valor del QR escaneado
    console.log('Código QR escaneado:', dni);

    // Buscar al jugador en la lista usando el DNI
    const jugador = playersData.value.find(p => p.DNI === dni);

    if (jugador) {
        playerCheck(jugador.DNI, route.params.id, jugador.name, jugador.income, jugador.player_id, jugador.status);
    } else {
        console.error("No se encontró jugador con el DNI escaneado:", dni);
        swal({
            icon: 'error',
            title: 'Jugador no encontrado',
            text: `El DNI ${dni} no corresponde a ningún jugador en la lista.`,
            showConfirmButton: true
        });
    }

    isCameraOpen.value = false;
    loadPlayerData();

};

const onInit = (initStatus) => {
    console.log('Estado de inicialización del escáner:', initStatus);
};

const formatDate = (dateString) => {
    if (!dateString) return '';
    const date = new Date(dateString);
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();
    return `${day}-${month}-${year}`;
};

const onError = (error) => {
    console.error('Error al abrir la cámara:', error);
};

const loadPlayerData = async () => {
    try {
        await getPost(route.params.id);
    } catch (error) {
        console.error("Error loading player data:", error);
    }
    console.log(playersData.value);
};

const handleRefresh = () => {
    loadPlayerData();
};

const openAddPlayerDialog = () => {
    newPlayer.value = {
        DNI: '',
        nombrecompleto: '',
        alquiler: false,
        dentro: true,
        shift: false
    };
    displayAddPlayerDialog.value = true;
};

const addPlayer = async () => {
    try {

        const response = await axios.post('/api/reservar', {
            skip:true,
            DNI: newPlayer.value.DNI,
            nombrecompleto: newPlayer.value.nombrecompleto,
            alquiler: newPlayer.value.alquiler,
            dentro: newPlayer.value.dentro,
            shift: newPlayer.value.shift,
            partida_id: route.query.date,
            precio: newPlayer.value.alquiler ? '40' : '15',
        });

        displayAddPlayerDialog.value = false;

        await swal({
            icon: 'success',
            title: 'Jugador agregado con éxito',
            text: 'El jugador ha sido registrado en la partida.',
            confirmButtonText: 'Aceptar'
        });

        loadPlayerData();

    } catch (error) {
        console.error("Error al enviar el formulario:", error.response?.data || error);
        displayAddPlayerDialog.value = false;
        swal({
            icon: 'error',
            title: 'Error al agregar el jugador',
            text: error.response?.data?.message || 'Hubo un problema al procesar la solicitud.',
            showConfirmButton: false,
            timer: 2500
        });
    }
};

onMounted(() => {
    loadPlayerData();
});
</script>

<style>
.succesSwal{
    background-color: green;
    color: white;
}

.denniedSwal{
    background-color: #8c0000;
    color: black;
}
</style>
