<template>
    <div class="card">
        <DataTable :value="playersData" tableStyle="min-width: 50rem" ref="dt">
            <template #header>
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <span class="text-xl font-bold">Jugadores</span>
                    <span class="text-xl">{{ formatDate(route.query.date) }}</span>
                    <Button icon="pi pi-refresh" rounded raised @click="handleRefresh" />
                    <Button icon="pi pi-plus" rounded raised @click="openAddPlayerDialog" />
                    <Button icon="pi pi-external-link" label="Export" @click="exportCSV($event)" />
                </div>
            </template>

            <column header="Opciones">
                <template #body="player">
                    <button @click.prevent.stop="playerCheck(player.data.DNI, route.params.id, player.data.name, player.data.income, player.data.player_id)"
                            class="btn btn-success btn-sm ms-2">{{ player.data.status === 'Dentro' ? 'Sacar' : 'Verificar' }}
                    </button>
                </template>
            </column>
            <Column field="name" sortable header="Jugador"></Column>
            <Column field="DNI" sortable header="DNI"></Column>
            <Column field="income" sortable header="Importe"></Column>
            <Column field="mail" header="Correo"></Column>
            <Column field="phone" header="Telefono"></Column>
            <Column field="team" header="Equipo"></Column>
            <Column field="status" sortable header="Status"></Column>
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
            <div class="field">
                <label for="telefono">Teléfono</label>
                <InputText id="telefono" v-model="newPlayer.telefono" />
            </div>
            <div class="field">
                <label for="email">Correo</label>
                <InputText id="email" v-model="newPlayer.email" required />
            </div>
            <div class="field">
                <label for="team">Equipo</label>
                <InputText id="team" v-model="newPlayer.team" />
            </div>

            <div class="field-checkbox">
                <label for="alquiler">Alquiler</label>
                <Checkbox id="alquiler" v-model="newPlayer.alquiler" :binary="true" />
            </div>
            <div class="field-checkbox">
                <label for="dentro">Dentro</label>
                <Checkbox id="dentro" v-model="newPlayer.dentro" :binary="true" />
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
const swal = inject('$swal');
const dt = ref();

const { playerCheck, getPost, playersData } = usePosts();
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

const exportCSV = () => {
    // 2. Llama al método exportCSV del componente referenciado
    dt.value.exportCSV();
};

const openCamera = () => {
    isCameraOpen.value = true;
};

const closeCamera = () => {
    isCameraOpen.value = false;
};

const onDetect = (decodedString) => {
    console.log('Código QR escaneado:', decodedString[0].rawValue);
    playerCheck(decodedString[0].rawValue, route.params.id, playersData.value[0].name, playersData.value[0].income);
    isCameraOpen.value = false;
};

const onInit = (initStatus) => {
    console.log('Estado de inicialización del escáner:', initStatus);
};

const formatDate = (dateString) => {
    // Si la fecha es null o no está definida, devuelve un string vacío
    if (!dateString) return '';

    // Crea un objeto Date. Asume que la fecha está en formato YYYY-MM-DD
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
        telefono: '',
        email: '',
        team: '',
        alquiler: false,
        dentro: false,
        shift: false
    };
    displayAddPlayerDialog.value = true;
};

const addPlayer = async () => {
    try {
        // Adaptado para enviar los datos del nuevo jugador
        const response = await axios.post('/api/reservar', {
            DNI: newPlayer.value.DNI,
            nombrecompleto: newPlayer.value.nombrecompleto,
            telefono: newPlayer.value.telefono,
            email: newPlayer.value.email,
            team: newPlayer.value.team,
            alquiler: newPlayer.value.alquiler,
            dentro: newPlayer.value.dentro,
            shift: newPlayer.value.shift,
            partida_id: route.query.date, // Pasas el ID de la partida
            precio: '15',
        });

        // Mostrar notificación de éxito usando swal
        await swal({
            icon: 'success',
            title: 'Jugador agregado con éxito',
            text: 'El jugador ha sido registrado en la partida.',
            confirmButtonText: 'Aceptar'
        });

        // Cierra el pop-up
        displayAddPlayerDialog.value = false;

        // Recarga los datos para mostrar el nuevo jugador en la tabla
        loadPlayerData();

    } catch (error) {
        console.error("Error al enviar el formulario:", error.response?.data || error);

        // Mostrar notificación de error usando swal
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
