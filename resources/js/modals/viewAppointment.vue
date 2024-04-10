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
                    <span>{{ appointments.teacher.user.name }}</span>
                </div>

                <div class="mb-4 border-bottom" v-if="appointments.lesson == false || appointments.status_id === 3">
                    <label class="fw-bold">Lid:</label>
                    <span>{{ appointments.member.user.name }}</span>
                </div>

                <div class="mb-4 border-bottom" v-if="appointments.court">
                    <label class="fw-bold">Type:</label>
                    <span v-if="appointments.lesson == true">Les</span>
                    <span v-else>Baanhuur</span>
                </div>
            </div>

            <button v-if="appointments.lesson == true && appointments.status_id != 3 && appointments.teacher.user_id != user.id" type="button"
                class="btn btn-primary mb-2" @click="updateAppointmentUser(3)">
                Meedoen
            </button>

            <button v-if="appointments.lesson == true && appointments.member.user_id == user.id && appointments.teacher.user_id != user.id" type="button" class="btn btn-danger mb-2" @click="updateAppointmentUser(1)">Stoppen</button>
            <button v-if="appointments.lesson == false || appointments.teacher.user_id == user.id" type="button" class="btn btn-danger mb-2" @click="deleteAppointment()">Annuleren</button>
            <!-- <button type="button" class="btn btn-warning mb-2" @click="showChangeAppointmentModal">Aanpassen</button> -->
            <!-- <changeAppointment ref="change" /> -->

            <button type="button" class="btn btn-secondary" @click="$modal.hide('view-appointment')">
                Sluiten
            </button>
        </div>
    </modal>
</template>


<script>
import { mapGetters } from 'vuex'
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
            appointments: [],
            event: {},
        };
    },
    mounted() {
        const self = this;
        self.loading = false;
        self.getAppointment(event.id);
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
        /*
            remove / add user depending on status_id (id parameter)
        */
        async updateAppointmentUser(id) { 
            const self = this;

            const response = await this.$https.post(`/api/appointment/${self.appointments.id}/users`, {
                status_id: id
            }).then(() => {
                self.getAppointment(self.appointments.id);
            })


        },
        deleteAppointment() {
            const self = this;

            if (confirm('Weet je zeker dat je de afspraak wilt verwijderen?')) {
                self.$https.delete(`/api/appointment/${self.appointments.id}`)
                    .then(response => {
                        self.$swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Afspraak succesvol verwijderd.',
                            timer: 3000
                        });
                        self.$modal.hide('view-appointment');
                    })
                    .catch(error => {
                        console.error('Fout bij verwijderen afspraak:', error);
                        self.$swal.fire({
                            icon: 'error',
                            title: 'Fout!',
                            text: error.message || 'Afspraak kon niet worden verwijderd.'
                        });
                    });
                setTimeout(function () {
                    window.location.reload();
                }, 3000);
            }
        },
        showChangeAppointmentModal() {
            this.$modal.show('change-appointment');
        }

    },
    computed: mapGetters({
        user: 'auth/user'
    })
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
