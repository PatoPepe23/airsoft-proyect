import {ref} from "vue";
import usePosts from "@/composables/posts.js";

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

const gameID = ref(null);
export default function usePlayers () {

    const addPlayer = async () => {
        console.log(Number.isInteger(gameID.value));
        const intID = parseInt(gameID.value);
        try {
            const response = await axios.post('/api/reservar', {
                skip: true,
                DNI: newPlayer.value.DNI,
                nombrecompleto: newPlayer.value.nombrecompleto,
                alquiler: newPlayer.value.alquiler,
                dentro: newPlayer.value.dentro,
                shift: newPlayer.value.shift,
                partida_id: intID,
                precio: newPlayer.value.alquiler ? '40' : '15',
            });

            console.log('Bien')

            //displayAddPlayerDialog.value = false;

            // await swal({
            //     icon: 'success',
            //     title: 'Jugador agregado con éxito',
            //     text: 'El jugador ha sido registrado en la partida.',
            //     confirmButtonText: 'Aceptar'
            // });

            await loadPlayerData();

        } catch (error) {
            console.log(error)
            // console.error("Error al enviar el formulario:", error.response?.data || error);
            // displayAddPlayerDialog.value = false;
            // swal({
            //     icon: 'error',
            //     title: 'Error al agregar el jugador',
            //     text: error.response?.data?.message || 'Hubo un problema al procesar la solicitud.',
            //     showConfirmButton: false,
            //     timer: 2500
            // });
        }
    };


    return {
        gameID,
        newPlayer,
        addPlayer
    }
}
