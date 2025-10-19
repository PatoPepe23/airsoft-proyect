import axios from "axios";
import Cookies from "js-cookie";
import {computed, ref} from "vue";

const partida_id = ref(null);
const DNI = ref("");
const nombrecompleto = ref("");
const telefono = ref("");
const email = ref("");
const alquiler = ref(false);
const team = ref("");
const food = ref(false);
const bocadillo = ref(1)
const shift = ref(false);
const discountinput = ref("");
const descuentoPorcentaje = ref(null);

const base = computed(() => {
    let b = 15;

    if (alquiler.value) {
        b = 40;
    }

    if (food.value) {
        b += 6;
    }

    return b;
});

const precio = computed(() => {
    if (descuentoPorcentaje.value) {
        return base.value - (base.value * descuentoPorcentaje.value / 100);
    }
    return base.value;
});

export default function useReservas (swal) {


    const discount = async () => {
        try {
            const response = await axios.post('/api/discount', {
                discountinput: discountinput.value
            });

            descuentoPorcentaje.value = response.data.porcentaje;

            swal({
                icon: 'success',
                title: 'Descuento aplicado correctamente',
                showConfirmButton: false,
                timer: 2500
            });
        } catch (error) {
            console.error("Error al conseguir el descuento:", error.response?.data || error);
            descuentoPorcentaje.value = 0;
            swal({
                icon: 'error',
                title: "Error al conseguir el descuento/No existe el descuento",
                showConfirmButton: false,
                timer: 2500
            });
        }
    };

    const reservar = async () => {
        try {
            const response = await axios.post('/api/reservar', {
                DNI: DNI.value,
                nombrecompleto: nombrecompleto.value,
                telefono: telefono.value,
                email: email.value,
                alquiler: alquiler.value,
                food: food.value,
                food_id: bocadillo.value,
                partida_id: partida_id.value,
                shift: shift.value,
                team: team.value,
                precio: precio.value,
                dentro: false
            });

            axios.post('/api/send-mail', {
                DNI: DNI.value,
                nombrecompleto: nombrecompleto.value,
                telefono: telefono.value,
                email: email.value,
                alquiler: alquiler.value,
                food: food.value,
                food_id:bocadillo.value,
                shift: shift.value,
                subject: 'Confirmación de reserva',
                body: `Gracias por tu reserva, ${nombrecompleto.value}. Nos vemos pronto.`,
                precio: precio.value,
                partida_id: partida_id
            })

            await swal({
                icon: 'success',
                title: 'Reserva realizada con éxito',
                text: 'Se le enviará un correo con la reserva.',
                confirmButtonText: 'Aceptar'
            });

            router.push({ name: 'home' }).then(() => {
                window.scrollTo(0, 0);
            });


            // Clear all pre-population cookies after a successful reservation
            const fieldsToClear = [
                'DNI', 'nombrecompleto', 'email', 'telefono', 'team', 'alquiler', 'shift', 'food', 'bocadillo'
            ];
            fieldsToClear.forEach(fieldName => {
                Cookies.remove(COOKIE_PREFIX + fieldName);
            });

            // Reset local reactive variables to their initial state
            DNI.value = "";
            nombrecompleto.value = "";
            telefono.value = "";
            email.value = "";
            food.value = false;
            bocadillo.value = 1;
            shift.value = false;
            alquiler.value = false;
            team.value = "";

        } catch (error) {
            // console.error("Error al enviar el formulario:", error.response?.data || error);
            swal({
                icon: 'error',
                title: error.response?.data.error,
                showConfirmButton: false,
                //timer: 2500
            });
        }
    };

    return {
        discount,
        reservar,
        DNI,
        nombrecompleto,
        telefono,
        email,
        alquiler,
        team,
        food,
        bocadillo,
        shift,
        partida_id,
        precio,
        discountinput,
        descuentoPorcentaje
    }
}
