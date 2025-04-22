<template>
    <div class="card">
        <DataTable :value="playersData" tableStyle="min-width: 50rem">
            <template #header>
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <span class="text-xl font-bold">Jugadores</span>
                    <Button icon="pi pi-refresh" rounded raised />

                </div>
            </template>
            <Column field="DNI" sortable header="DNI"></Column>
            <Column field="name" sortable header="Jugador"></Column>
            <Column field="income" sortable header="Importe"></Column>
            <Column field="mail" header="Correo"></Column>
            <Column field="phone" header="Telefono"></Column>
            <Column field="status" header="Status"></Column>
            <button @click="openCamera" class="btn btn-primary">Abrir Cámara</button><button @click="closeCamera" class="btn btn-danger">Cerrar Cámara</button>
            <div v-if="isCameraOpen" class="camera-container">
                <QrcodeStream
                    v-if="isCameraOpen"
                    @decode="onDecode" @init="onInit" @error="onError" :constraints="{ video: { facingMode: 'environment' } }"
                />

            </div>

            <column header="Opciones">
                <template #body="player">
                    <button @click.prevent.stop="playerCheck(player.data.DNI, route.params.id)"
                            class="btn btn-danger btn-sm ms-2">Verificar
                    </button>
                </template>
            </column>
        </DataTable>
    </div>
</template>
<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import usePosts from '@/composables/posts';
import { QrcodeStream, QrcodeDropZone, QrcodeCapture } from 'vue-qrcode-reader'; // Importa el lector QR
const {playerCheck, getPost, playersData } = usePosts(); // Correctly import playersData

const route = useRoute();
const isCameraOpen = ref(false); // Estado para manejar la cámara
const scannedCode = ref(null); // Almacena el código escaneado

const openCamera = () => {
    isCameraOpen.value = true; // Activa el escáner de QR
};

const closeCamera = () => {
    isCameraOpen.value = false; // Cierra el escáner de QR
};

const onDecode = (decodedString) => {
    console.log('Código QR escaneado:', decodedString);

    // Llamar directamente a playerCheck pasando el DNI escaneado
    playerCheck(decodedString, route.params.id);

    isCameraOpen.value = false; // Cerrar el escáner después del escaneo
};

const onInit = (initStatus) => {
    console.log('Estado de inicialización del escáner:', initStatus);
};

const onError = (error) => {
    console.error('Error al abrir la cámara:', error);
};

const loadPlayerData = async () => {
    try {
        await getPost(route.params.id);
        // playersData.value is already the array of players from the composable
    } catch (error) {
        console.error("Error loading player data:", error);
    }
    console.log(playersData.value);
};

onMounted(() => {
    loadPlayerData();
});

</script>
