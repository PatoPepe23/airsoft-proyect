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
            <column header="Opciones">
                <template #body="player">
                    <button @click.prevent.stop="playerCheck(player.data.player_id)"
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
const {playerCheck, getPost, playersData } = usePosts(); // Correctly import playersData

const route = useRoute();

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
