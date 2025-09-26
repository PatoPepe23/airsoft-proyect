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
        search_team = '',
        search_state = '',
        order_column = 'created_at',
        order_direction = 'desc'
    ) => {
        // console.log('day: '+search_day);
        // console.log('id: '+search_id);
        // console.log('player: '+search_players);
        // console.log('shift: '+search_shift);
        // console.log('state: '+search_state);
        axios.get('/api/posts?page=' + page +
            '&search_day=' + search_day +
            '&search_id=' + search_id +
            '&search_players=' + search_players +
            '&search_shift=' + search_shift +
            '$search_team=' + search_team +
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

    const playerCheck = async (player, id, name, importe, player_id, status) => {

        const swalText = status === 'Dentro' ? `Quieres sacar a ${name} con DNI ${player} del campo?` : `Quieres confirmar que ${name} con DNI ${player} entre al campo?`;
        const swalButton = status === 'Dentro' ? `Si, sacalo.` : 'Si, registrar jugador';
        const swalSuccess = status === 'Dentro' ? 'Expulsado con exito' : 'Registrado con exito'
        const swalIcon = status === 'Dentro' ? 'warning' : 'success';
        const swalTitle = status === 'Dentro' ? 'Ya está dentro ' : `Puede pasar ${importe}€`;
        const swalClass = status === 'Dentro' ? 'denniedSwal' : 'succesSwal';

        swal({
            title: swalTitle,
            text: swalText,
            icon: swalIcon,
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonText: swalButton,
            confirmButtonColor: '#ef4444',
            timer: 20000,
            timerProgressBar: true,
            reverseButtons: true,
            customClass: swalClass
        })
            .then(result => {
                if (result.isConfirmed) {
                    axios.post(`/api/post/${id}/${player_id}`)
                        .then(response => {
                            getPosts()
                            router.push({name: 'posts.edit'})
                            if (response.data === true) {
                                swal({
                                    icon: 'error',
                                    title: 'El jugador ya esta dentro'
                                })
                            } else {
                                swal({
                                    icon: 'success',
                                    title: swalSuccess
                                })
                            }

                        })
                        .catch(error => {
                            swal({
                                icon: 'error',
                                title: 'El jugador no existe en la partida'
                            })
                        })
                }
            })

    }

    const playerChange = async (player, id, name, player_id, status) => {

        const swalText = status ? `Cambiar a ${name} con DNI ${player} a <b>Alquiler</b>?` : `Cambiar a ${name} con DNI ${player} a <b>Normal</b>?`;
        const swalTitle = status ? `Cambiar a Alquiler?` : `Cambiar a Normal?`;

        swal({
            title: swalTitle,
            html: swalText,
            icon: 'question',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, cambialo',
            confirmButtonColor: '#ef4444',
            timer: 20000,
            timerProgressBar: true,
            reverseButtons: true,
        })
            .then(result => {
                if (result.isConfirmed) {
                    axios.post(`/api/postChange/${id}/${player_id}`)
                        .then(response => {
                            getPosts()
                            router.push({name: 'posts.edit'})
                            if (response.data === true) {
                                swal({
                                    icon: 'error',
                                    title: 'El jugador ya esta dentro'
                                })
                                return false;
                            } else {
                                swal({
                                    icon: 'success',
                                    title: 'Cambiado con éxito'
                                })
                                return true;
                            }

                        })
                        .catch(error => {
                            swal({
                                icon: 'error',
                                title: 'El jugador no existe en la partida'
                            })
                            return false;
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
        playerCheck,
        playerChange
    }
}
