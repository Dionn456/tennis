<template>
    <modal name="change-appointment" height="auto" width="350px">
        <div class="modal-content p-4 modal-dialog-centered">
            <div v-if="appointments">
                <h5 v-if="appointments.lesson == true" class="modal-title mb-4 fw-bold text-decoration-underline">
                    Meedoen aan les</h5>
                <h5 v-else class="modal-title mb-4 fw-bold text-decoration-underline">Gehuurde tijd/baan</h5>

                <div class="mb-3 border-bottom">
                    <label class="fw-bold">Begin:</label>
                    <span>{{ appointments.start }}</span>
                </div>

                <div class="mb-3 border-bottom">
                    <label class="fw-bold">Eind:</label>
                    <span>{{ appointments.end }}</span>
                </div>

                <div class="mb-4 border-bottom" v-if="appointments.court">
                    <label class="fw-bold">Baan:</label>
                    <span>{{ appointments.court.name }}</span>
                </div>
            </div>

            <button v-if="appointments.lesson == true && appointments.status_id != 3" type="button"
                class="btn btn-primary mb-2" @click="joinLesson">
                Meedoen
            </button>

            <button type="button" class="btn btn-warning mb-2" @click="showChangeAppointmentModal">Aanpassen</button>

            <button type="button" class="btn btn-secondary" @click="$modal.hide('view-appointment')">
                Sluiten
            </button>
        </div>
    </modal>
</template>

<script>
import DatePicker from 'vue2-datepicker';

export default {
    name: 'change-appointment',
    components: {
        DatePicker
    },
    data() {
        return {
            loading: true,
            appointments: {},
            event: {},
        };
    },
    mounted() {
        const self = this;
        self.loading = false;
    },
    methods: {
        /**
        * Function to show the modal for adding an appointment.
        * @param {Object} event - The event object containing the date.
        * @param {Array} events - Optional. Array of events.
        */
        show(event) {
            const self = this;
            self.event = event;
            self.getAppointment(event.id);
            self.$modal.show("change-appointment");
        },
        async getAppointment(id) {
            const self = this

            var response = await self.$https.get('/api/appointment/' + id);
            var appointments = response.data;
            if (appointments) {
                self.appointments = appointments;
            }
        },        
    },
    computed: {

    }
}


</script>

<style>
/* fix focus */
.diss:focus {
    transform: none;
    box-shadow: none;
    outline: none;
}

.diss {
    border-radius: 7px;
}
</style>
