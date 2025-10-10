import {ref} from "vue";
import usePosts from "@/composables/posts.js";

const { getPosts } = usePosts();
export default function datatables () {
    const loading = ref(false);
    const currentPage = ref(1);
    const totalRecords = ref(0);
    const orderColumn = ref('created_at');
    const orderDirection = ref('desc');
    const filters = ref({
        'global': { value: null, matchMode: 'contains' },
        'day': { value: null, matchMode: 'contains' },
        'players': { value: null, matchMode: 'contains' },
        'shift': { value: null, matchMode: 'contains' },
        'state': { value: null, matchMode: 'contains' },
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

    return {
        fetchPosts,
        loading,
        currentPage,
        totalRecords,
        orderColumn,
        orderDirection,
        filters
    }
}
