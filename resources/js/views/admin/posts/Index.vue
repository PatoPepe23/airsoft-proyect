<template>
    <div class="row justify-content-center my-2">
        <div class="col-md-12">
            <div class="card border-0">
                <div class="card-header bg-transparent">
                    <h5 class="float-start">Partidas</h5>
                    <router-link v-if="can('post-create')" :to="{ name: 'posts.create' }" class="btn btn-primary btn-sm float-end">
                        Create Post
                    </router-link>
                </div>
                <div class="card-body shadow-sm">
                    <div class="mb-4">
                        <IconField>
                            <InputIcon>
                                <i class="pi pi-search" />
                            </InputIcon>
                            <InputText v-model="filters['global'].value" placeholder="Buscar..." class="form-control w-25" />
                        </IconField>
                    </div>
                    <DataTable v-model:filters="filters" :value="posts.data" paginator :rows="rowsPerPage"
                               dataKey="id" filterDisplay="row" :loading="loading"
                               :totalRecords="totalRecords" @page="onPage" @sort="onSort"
                               :sortField="orderColumn" :sortOrder="orderDirection === 'asc' ? 1 : -1"
                               :globalFilterFields="['day', 'players', 'shift', 'state']">
                        <template #empty> No se encontraron partidas. </template>
                        <template #loading> Cargando partidas. Por favor, espere. </template>
                        <Column field="day" header="Dia" sortable filterField="day" style="min-width: 10rem">
                            <template #body="{ data }">{{ data.day }}</template>
                            <template #filter="{ filterModel, filterCallback }">
                                <InputText v-model="filterModel.value" type="text" @input="filterCallback()" placeholder="Filtrar por dia" />
                            </template>
                        </Column>
                        <Column field="players" header="JUGADORES" sortable filterField="players" style="min-width: 12rem">
                            <template #body="{ data }">{{ data.players }}</template>
                            <template #filter="{ filterModel, filterCallback }">
                                <InputText v-model="filterModel.value" type="text" @input="filterCallback()" placeholder="Filtrar por jugadores" />
                            </template>
                        </Column>
                        <Column field="shift" header="TURNO" sortable filterField="shift" style="min-width: 10rem">
                            <template #body="{ data }">{{ getShift(data.shift) }}</template>
                            <template #filter="{ filterModel, filterCallback }">
                                <InputText v-model="filterModel.value" type="text" @input="filterCallback()" placeholder="Filtrar por turno" />
                            </template>
                        </Column>
                        <Column header="ESTADO" filterField="state" :showFilterMenu="false" style="min-width: 14rem">
                            <template #body="{ data }">
                                <div class="flex items-center gap-2">
                                    <span>{{ getState(data.day, data.state) }}</span>
                                </div>
                            </template>
                            <template #filter="{ filterModel, filterCallback }">
                                <MultiSelect v-model="filterModel.value" @change="filterCallback()" :options="stateOptions" optionLabel="state" optionValue="filter" placeholder="Filtrar por estado" style="min-width: 14rem" :maxSelectedLabels="1">
                                    <template #option="stateOptions">
                                        <div class="flex items-center gap-2">
                                            <span>{{ stateOptions.option.state}}</span>
                                        </div>
                                    </template>
                                </MultiSelect>
                            </template>
                        </Column>
                        <Column header="Acciones" style="min-width: 8rem">
                            <template #body="{ data }">
                                <router-link v-if="can('post-edit')"
                                             :to="{ name: 'posts.edit', params: { id: data.id } }" class="btn btn-primary btn-sm">Edit
                                </router-link>
                                <button v-if="can('post-delete')" @click.prevent="deletePost(data.id)"
                                        class="btn btn-danger btn-sm ms-2">Delete</button>
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
import { ref, onMounted, watch } from "vue";
import usePosts from "@/composables/posts";
import useCategories from "@/composables/categories";
import { useAbility } from '@casl/vue';
import _ from 'lodash';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';
import IconField from 'primevue/iconfield';
import InputIcon from 'primevue/inputicon';
import { useRouter } from 'vue-router';

const router = useRouter();
const filters = ref({
    'global': { value: null, matchMode: 'contains' },
    'day': { value: null, matchMode: 'contains' },
    'players': { value: null, matchMode: 'contains' },
    'shift': { value: null, matchMode: 'contains' },
    'state': { value: null, matchMode: 'contains' },
});
const loading = ref(false);
const currentPage = ref(1);
const totalRecords = ref(0);
const rowsPerPage = ref(10);
const orderColumn = ref('created_at');
const orderDirection = ref('desc');
const { posts= ref([]), getPosts, deletePost } = usePosts();
const { categoryList, getCategoryList } = useCategories();
const { can } = useAbility();

const stateOptions = ref([
    { state: 'Abierta', filter: 2},
    { state: 'Cerrada', filter: 0},
    { state: 'Cancelada', filter: 1},
])

onMounted(() => {
    fetchPosts();
    getCategoryList();
});

const fetchPosts = (page = 1, sortField = orderColumn.value, sortOrder = orderDirection.value) => {
    loading.value = true;
    currentPage.value = page;
    getPosts(
        page,
        filters.value.day.value,
        '', // search_id no se usa
        filters.value.players.value,
        filters.value.shift.value,
        filters.value.state.value,
        sortField,
        sortOrder,
        filters.value.global.value
    ).then(() => {
        totalRecords.value = posts.value.meta.total;
        loading.value = false;
    }).catch(() => {
        loading.value = false;
    });
};

const onSort = (event) => {
    orderColumn.value = event.sortField;
    orderDirection.value = event.sortOrder === 1 ? 'asc' : 'desc';
    fetchPosts(currentPage.value, orderColumn.value, orderDirection.value);
};

const onPage = (event) => {
    fetchPosts(event.page + 1);
};

watch(filters, _.debounce(() => fetchPosts(1), 200), { deep: true });

const getShift = (shift) => {
    let decidedShift = '';
    switch (shift) {
        case 0:
            decidedShift = 'Tarde';
            break;
        case 1:
            decidedShift = 'Mañana';
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
