<template>
    <modal name="view-appointment" height="auto" width="350px">
        <div class="modal-content p-4 modal-dialog-centered">
            <div v-if="appointment">
                <h5 v-if="appointment.lesson == true" class="modal-title mb-4 fw-bold text-decoration-underline">Meedoen
                    aan les</h5>
                <h5 v-else class="modal-title mb-4 fw-bold text-decoration-underline">Gehuurde tijd/baan</h5>

                <div class="mb-3 border-bottom">
                    <label class="fw-bold">Begin:</label>
                    <span>{{ appointment.start }}</span>
                </div>

                <div class="mb-3 border-bottom">
                    <label class="fw-bold">Eind:</label>
                    <span>{{ appointment.end }}</span>
                </div>

                <div class="mb-4 border-bottom" v-if="appointment.court">
                    <label class="fw-bold">Baan:</label>
                    <span>{{ appointment.court.name }}</span>
                </div>

                <div class="mb-4 border-bottom">
                    <label class="fw-bold">Docent:</label>
                    <span>docent</span>
                </div>


                <div class="mb-4 border-bottom" v-if="appointment.court">
                    <label class="fw-bold">Type:</label>
                    <span v-if="appointment.lesson == true">Les</span>
                    <span v-else>Baanhuur</span>
                </div>
            </div>

            <button v-if="appointment.lesson == true && appointment.status_id != 3" type="button"
                class="btn btn-primary mb-2" @click="joinLesson">
                Meedoen
            </button>


            <button type="button" class="btn btn-secondary" @click="$modal.hide('view-appointment')">
                Sluiten
            </button>
        </div>
    </modal>
</template>


<script>
import DatePicker from 'vue2-datepicker';

export default {
    name: 'view-appointment',
    components: {
        DatePicker
    },
    data() {
        return {
            loading: true,
            appointment: {},
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

            self.$modal.show("view-appointment");
        },
        async getAppointment(id) {
            const self = this

            var response = await self.$https.get('/api/appointment/' + id);
            var appointment = response.data;
            if (appointment) {
                self.appointment = appointment;
            }
        },
        async joinLesson() {
            try {
                if (this.appointment) {
                    this.appointment.status_id = 3; // Update status locally
                    await this.updateAppointmentStatus(this.appointment.id, this.appointment.status_id); // Send update to server
                }
            } catch (error) {
                console.error('Error updating appointment status:', error);
            }
        },

        async updateAppointmentStatus(appointmentId, newStatusId) {
            const response = await this.$https.put(`/api/appointment/${appointmentId}`, {
                status_id: newStatusId
            });
        }
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
