<template>
    <div class="row justify-content-center my-2">
        <div class="col-md-12">
            <div class="card border-0">
                <div class="card-header bg-transparent">
                    <h5 class="float-start">Partidas</h5>
<!--                    <router-link v-if="can('post-create')" :to="{ name: 'posts.create' }" class="btn btn-primary btn-sm float-end">-->
<!--                        Create Post-->
<!--                    </router-link>-->

                </div>
                <div class="card-body shadow-sm">
                    <div class="mb-4">
                        <IconField class="flex">
                            <InputText v-model="filters['global'].value" placeholder="Buscar..." class="form-control w-25" />
                            <div class="flex w-100">
                                <InputText v-model="filters['day'].value" placeholder="Filtrar por Dia" class="form-control w-2" />
                                <InputText v-model="filters['players'].value" placeholder="Filtrar por Jugadores" class="form-control w-2" />
                            </div>
                        </IconField>
                    </div>
                    <div class="show-d"></div>
                    <DataTable v-model:filters="filters" :value="posts.data" paginator :rows="rowsPerPage"
                               dataKey="id" filterDisplay="row" :loading="loading"
                               :totalRecords="totalRecords" @page="onPage" @sort="onSort"
                               :sortField="orderColumn" :sortOrder="orderDirection === 'asc' ? 1 : -1"
                               :globalFilterFields="['day', 'players', 'shift', 'state']"
                    >
                        <template #empty> No se encontraron partidas. </template>
                        <template #loading> Cargando partidas. Por favor, espere. </template>
                        <template #header>
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <span class="text-xl font-bold">Products</span>
                                <Button icon="pi pi-refresh" rounded raised />
                            </div>
                        </template>
                        <Column header="Acciones" style="min-width: 8rem">
                            <template #body="{ data }">
                                <router-link v-if="can('post-edit')"
                                             :to="{ name: 'posts.edit', params: { id: data.id }, query: { date: data.day} }" class="btn btn-primary btn-sm">Detalles
                                </router-link>
                                <button v-if="can('post-delete')" @click.prevent="cancelPost(data.id)"
                                        class="btn btn-danger btn-sm ms-2">Cancelar</button>
                            </template>
                        </Column>
                        <Column field="day" header="Dia" sortable filterField="day" style="min-width: 10rem">
                            <template #body="{ data }">{{ formatDate(data.day) }}</template>
                        </Column>
                        <Column field="players" header="JUGADORES" sortable filterField="players" style="min-width: 12rem">
                            <template #body="{ data }">{{ ((data.players - 220) * -1) }} / 220</template>
                        </Column>
                        <Column field="alquiler" header="ALQUILERES" sortable filterField="players" style="min-width: 12rem">
                            <template #body="{ data }">{{ ((data.alquiler - 25) * -1) }} / 25</template>
                        </Column>
                        <Column field="shift" header="TURNO" sortable filterField="shift" style="min-width: 10rem">
                            <template #body="{ data }">{{ getShift(data.shift) }}</template>
                        </Column>
                        <Column header="ESTADO" filterField="state" :showFilterMenu="false" style="min-width: 14rem">
                            <template #body="{ data }">
                                <div class="flex items-center gap-2">
                                    <span>{{ getState(data.day, data.state) }}</span>
                                </div>
                            </template>
                        </Column>
                    </DataTable>
                </div>
                <div class="card-footer">
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {ref, onMounted, watch} from "vue";
import usePosts from "@/composables/posts";
import useCategories from "@/composables/categories";
import datatables from "@/composables/datatables.js";
import { useAbility } from '@casl/vue';
import _ from 'lodash';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';
import IconField from 'primevue/iconfield';
import { useRouter } from 'vue-router';

const router = useRouter();

const rowsPerPage = ref(10);

const { posts= ref([]), getPosts, cancelPost } = usePosts();
const { categoryList, getCategoryList } = useCategories();
const { can } = useAbility();
const {filters, loading, currentPage, totalRecords, orderColumn, orderDirection, onPage, onSort, fetchPosts } = datatables();

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

onMounted(() => {
    fetchPosts();
    getCategoryList();
});

watch(filters, _.debounce(() => fetchPosts(1), 200), { deep: true });

const getShift = (shift) => {
    let decidedShift = '';
    switch (shift) {
        case 0:
            decidedShift = 'Mañana';
            break;
        case 1:
            decidedShift = 'Tarde';
            break;
    }
    return decidedShift;
};

const getState = (day, state) => {
    let decidedShift = '';

    const gameDate = new Date(day);
    const actualDate = new Date();

    if (gameDate <= actualDate){
        return 'Cerrada';
    }

    switch (state) {
        case 0:
            decidedShift = 'Abierta';
            break;
        case 1:
            decidedShift = 'Cancelada';
            break;
    }
    return decidedShift;
};
</script>

<style scoped>

</style>
