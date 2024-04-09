<template>
    <modal name="view-appointment" height="auto" width="350px">
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

                <div class="mb-4 border-bottom" v-if="appointments.lesson == true">
                    <label class="fw-bold">Docent:</label>
                    <span>docentnaam</span>
                </div>

                <div class="mb-4 border-bottom" v-if="appointments.lesson == false">
                    <label class="fw-bold">Lid:</label>
                    <span>lidnaam</span>
                </div>

                <div class="mb-4 border-bottom" v-if="appointments.court">
                    <label class="fw-bold">Type:</label>
                    <span v-if="appointments.lesson == true">Les</span>
                    <span v-else>Baanhuur</span>
                </div>
            </div>

            <button v-if="appointments.lesson == true && appointments.status_id != 3" type="button"
                class="btn btn-primary mb-2" @click="joinLesson">
                Meedoen
            </button>

            <button type="button" class="btn btn-danger mb-2" @click="quit">Annuleren</button>
            <button type="button" class="btn btn-warning mb-2" @click="showChangeAppointmentModal">Aanpassen</button>
            <changeAppointment ref="change" />

            <button type="button" class="btn btn-secondary" @click="$modal.hide('view-appointment')">
                Sluiten
            </button>
        </div>
    </modal>
</template>


<script>
import DatePicker from 'vue2-datepicker';

import changeAppointment from './changeAppointment.vue';

export default {
    name: 'view-appointment',
    components: {
        DatePicker, changeAppointment
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
            self.$modal.show("view-appointment");
        },
        async getAppointment(id) {
            const self = this

            var response = await self.$https.get('/api/appointment/' + id);
            var appointments = response.data;
            if (appointments) {
                self.appointments = appointments;
            }
        },
        async joinLesson() {
            const self = this;
            try {
                if (self.appointments) {
                    self.appointments.status_id = 3;
                    await self.updateAppointmentStatus(self.appointments.id, self.appointments.status_id);
                }
            } catch (error) {
                console.error('Error updating appointment status:', error);
            }
        },
        async quit() {
            const self = this;
            try {
                if (self.appointments) {
                    if (self.appointments.lesson) {
                        self.appointments.status_id = 1;
                        await self.updateAppointmentStatus(self.appointments.id, self.appointments.status_id);
                    } else {
                        await self.deleteAppointment(self.appointments.id);
                    }
                }
            } catch (error) {
                console.error('Error updating or deleting appointment:', error);
            }
        },
        deleteAppointment(appointmentId) {
            const self = this;

            if (confirm('Weet je zeker dat je de afspraak wilt verwijderen?')) {
                self.$https.delete(`/api/appointment/${appointmentId}`)
                    .then(response => {
                        const index = self.appointments.findIndex(appointment => appointment.id === appointmentId);
                        if (index !== -1) {
                            self.appointments.splice(index, 1);
                        }

                        self.$swal.fire({
                            icon: 'success',
                            title: 'Succesvol!',
                            text: 'Afspraak verwijderd.',
                            timer: 3000
                        });
                    })
                    .catch(error => {
                        console.error('Fout bij het verwijderen van de afspraak:', error);
                        self.$swal.fire({
                            icon: 'error',
                            title: 'Fout!',
                            text: 'Afspraak kon niet worden verwijderd.',
                            timer: 3000
                        });
                    });
            }
        },
        async updateAppointmentStatus(appointmentId, newStatusId) {
            const response = await this.$https.put(`/api/appointment/${appointmentId}`, {
                status_id: newStatusId
            });
        },
        showChangeAppointmentModal() {
            this.$modal.show('change-appointment');
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
