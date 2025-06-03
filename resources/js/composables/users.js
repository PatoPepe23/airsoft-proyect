import { ref, inject } from 'vue'
import { useRouter } from 'vue-router'
import { useI18n } from 'vue-i18n';
import useAuth from "@/composables/auth";

export default function useUsers() {
    const users = ref([])
    const user = ref({
        name: ''
    })

    const { logout } = useAuth();
    const router = useRouter()
    const validationErrors = ref({})
    const isLoading = ref(false)
    const swal = inject('$swal')
    const { t } = useI18n();


    const getUsers = async (
        page = 1,
        search_id = '',
        search_title = '',
        search_global = '',
        order_column = 'created_at',
        order_direction = 'desc'
    ) => {
        axios.get('/api/users?page=' + page +
            '&search_id=' + search_id +
            '&search_title=' + search_title +
            '&search_global=' + search_global +
            '&order_column=' + order_column +
            '&order_direction=' + order_direction)
            .then(response => {
                users.value = response.data;
            })
    }

    const getUsersWithTasks = async () => {
        axios.get('/api/userswithtasks')
            .then(response => {
                users.value = response.data;
            })
    }

    const getUser = async (id) => {
        axios.get('/api/users/' + id)
            .then(response => {
                user.value = response.data.data;
                console.log(user.value)
            })
    }

    const createUserDB = async (id) => {
        return axios.put('/api/users/db/create/' + id);
    }

    const deleteUserDB = async (id) => {
        return axios.put('/api/users/db/delete/' + id);
    }

    const changeUserPasswordDB = async (id) => {
        return axios.put('/api/users/db/password/' + id);
    }

    const createUserProceduredDB = async (id) => {
        return axios.put('/api/users/db/procedure/' + id);
    }
    const storeUser = async (user) => {
        if (isLoading.value) return;

        isLoading.value = true
        validationErrors.value = {}

        let serializedPost = new FormData()
        for (let item in user) {
            if (user.hasOwnProperty(item)) {
                serializedPost.append(item, user[item])
            }
        }

        axios.post('/api/users', serializedPost)
            .then(response => {
                router.push({name: 'users.index'})
                swal({
                    icon: 'success',
                    title: 'User saved successfully'
                })
            })
            .catch(error => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                }
            })
            .finally(() => isLoading.value = false)
    }

    const updateUser = async (user) => {
        console.log('Update');
        if (isLoading.value) return;

        isLoading.value = true
        validationErrors.value = {}

        console.log(user)

        swal({
            title: t('user_update_warning_title'),
            text: t('user_update_warning_text'),
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: t('user_update_warning_accept'),
            confirmButtonColor: '#41573E',
            cancelButtonText: t('cancel_button_text'),
            cancelButtonColor: '#ef4444',
            timer: 20000,
            timerProgressBar: true,
            reverseButtons: true
        })
            .then(result => {
                if (result.isConfirmed){
                    axios.post('/api/users', user)
                        .then(response => {
                            //router.push({name: 'users.index'})

                            swal({
                                icon: 'success',
                                title: 'User updated successfully'
                            })
                        })
                        .catch(error => {
                            if (error.response?.data) {
                                validationErrors.value = error.response.data.errors
                            }
                        })
                        .finally(() => isLoading.value = false)
                }
                isLoading.value = false
            })
    }

    const deleteUser = async (id) => { // Removed 'index' if not needed here
        swal({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this action!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            confirmButtonColor: '#ef4444',
            cancelButtonText: t('cancel_button_text'), // Use i18n for cancel button text
            timer: 20000,
            timerProgressBar: true,
            reverseButtons: true
        })
            .then(result => {
                if (result.isConfirmed) {
                    axios.delete('/api/user/' + id)
                        .then(response => {
                            swal({
                                icon: 'success',
                                title: 'User deleted successfully'
                            })
                            logout();
                            router.push({name: 'home'});
                        })
                        .catch(error => {
                            swal({
                                icon: 'error',
                                title: 'Something went wrong'
                            })
                            console.error('Error deleting user:', error);
                        })
                }
            })
    }

    return {
        users,
        user,
        getUsers,
        getUsersWithTasks,
        getUser,
        createUserDB,
        deleteUserDB,
        changeUserPasswordDB,
        createUserProceduredDB,
        storeUser,
        updateUser,
        deleteUser,
        validationErrors,
        isLoading
    }
}



