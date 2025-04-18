import { ref, inject } from 'vue'
import { useRouter } from 'vue-router'

export default function usePosts() {
    const posts = ref({})
    const playersData = ref([]);

    const router = useRouter()
    const validationErrors = ref({})
    const isLoading = ref(false)
    const swal = inject('$swal')

    const getPosts = async (
        page = 1,
        search_day = '',
        search_id = '',
        search_players = '',
        search_shift = '',
        search_state = '',
        order_column = 'created_at',
        order_direction = 'desc'
    ) => {
        console.log('day: '+search_day);
        console.log('id: '+search_id);
        console.log('player: '+search_players);
        console.log('shift: '+search_shift);
        console.log('state: '+search_state);
        axios.get('/api/posts?page=' + page +
            '&search_day=' + search_day +
            '&search_id=' + search_id +
            '&search_players=' + search_players +
            '&search_shift=' + search_shift +
            '&search_state=' + search_state +
            '&order_column=' + order_column +
            '&order_direction=' + order_direction)
            .then(response => {
                console.log(response.data);

                posts.value = response.data;
            })
    }

    const getPost = async (id) => {
        try {
            const response = await axios.get(`/api/posts/${id}`);
            if (response.data && response.data.players) {
                playersData.value = response.data.players;
            } else {
                console.error("La respuesta de la API no tiene la estructura esperada para los jugadores.");
            }
        } catch (error) {
            console.error("Error al obtener los jugadores:", error);
        }
    }

    const playerCheck = async (player) => {
        swal({
            title: 'Estas seguro?',
            text: 'Quieres confirmar que esta persona ha entrado al campo?',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, cancelala',
            confirmButtonColor: '#ef4444',
            timer: 20000,
            timerProgressBar: true,
            reverseButtons: true
        })
            .then(result => {
                if (result.isConfirmed) {
                    axios.post(`/api/post/${player}`)
                        .then(response => {
                            getPosts()
                            router.push({name: 'posts.edit'})
                            swal({
                                icon: 'success',
                                title: 'Registrado con exito'
                            })
                        })
                        .catch(error => {
                            swal({
                                icon: 'error',
                                title: 'Something went wrong'
                            })
                        })
                }
            })

    }

    const storePost = async (post) => {
        if (isLoading.value) return;

        isLoading.value = true
        validationErrors.value = {}

        let serializedPost = new FormData()
        for (let item in post) {
            if (post.hasOwnProperty(item)) {
                serializedPost.append(item, post[item])
            }
        }

        axios.post('/api/posts', serializedPost,{
            headers: {
                "content-type": "multipart/form-data"
            }
        })
            .then(response => {
                router.push({name: 'posts.index'})
                swal({
                    icon: 'success',
                    title: 'Post saved successfully'
                })
            })
            .catch(error => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                }
            })
            .finally(() => isLoading.value = false)
    }

    const updatePost = async (post) => {
        if (isLoading.value) return;

        isLoading.value = true
        validationErrors.value = {}
        console.log(post);
        axios.put('/api/posts/' + post.id, post)
            .then(response => {
                router.push({name: 'posts.index'})
                swal({
                    icon: 'success',
                    title: 'Post updated successfully'
                })
            })
            .catch(error => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                }
            })
            .finally(() => isLoading.value = false)
    }

    const cancelPost = async (id) => {
        swal({
            title: 'Estas seguro?',
            text: 'Una vez cancelada no se podra reabrir la partida!',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, cancelala',
            confirmButtonColor: '#ef4444',
            timer: 20000,
            timerProgressBar: true,
            reverseButtons: true
        })
            .then(result => {
                if (result.isConfirmed) {
                    axios.post('/api/posts/' + id)
                        .then(response => {
                            getPosts()
                            router.push({name: 'posts.index'})
                            swal({
                                icon: 'success',
                                title: 'Post deleted successfully'
                            })
                        })
                        .catch(error => {
                            swal({
                                icon: 'error',
                                title: 'Something went wrong'
                            })
                        })
                }
            })

    }

    return {
        posts,
        getPosts,
        getPost,
        storePost,
        updatePost,
        cancelPost,
        validationErrors,
        isLoading,
        playersData,
        playerCheck
    }
}
