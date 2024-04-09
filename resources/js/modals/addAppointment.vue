<template>
    <modal name="add-appointment" height="500">
        <div class="py-5 px-5" v-if="user.role_id != 1">
            <div class="mb-2 row">
                <label class="col-md-12 mb-1">Banen</label>
                <div class="col-md-12">
                    <select id="court" class="form-control mb-3" v-model="appointment.court_id"
                        @change="updateMinEndTime()">
                        <option v-for="court in courts" :key="court.id" :value="court.id">{{ court.name }}</option>
                    </select>
                </div>
            </div>
            <div v-if="appointment.court_id" class="mb-2 row">
                <label class="col-md-12 mb-1">Begin tijd</label>
                <div class="col-md-12">
                    <DatePicker type="time" :time-picker-options="{ start: '00:00', step: '00:60', end: '23:00' }"
                        :disabled-time="disableTime" format="HH:mm" v-model="appointment.start" class="w-100"
                        @change="updateMinEndTime()" />
                </div>
            </div>
            <div v-if="appointment.start" class="mb-2 row">
                <label class="col-md-12 mb-1">Eind tijd</label>
                <div class="col-md-12">
                    <DatePicker type="time" :time-picker-options="{ start: '00:00', step: '00:60', end: '23:00' }"
                        :disabled-time="disableTime" :min-date="appointment.start" format="HH:mm"
                        v-model="appointment.end" class="w-100" />
                </div>
            </div>
            <div class="row mt-3">
                <button v-if="user.role_id === 2" type="button" class="btn btn-primary w-100 mb-3" @click="addAppointment(true)">Les toevoegen</button>
                <button type="button" class="btn btn-primary w-100" @click="addAppointment(false)">Baan Huren</button>
            </div>

        </div>
    </modal>
</template>

<script>
import DatePicker from 'vue2-datepicker';

export default {
    name: 'add-appointment',
    components: {
        DatePicker
    },
    data() {
        return {
            loading: true,
            courts: [],
            events: [],
            date: '',
            user: [],
            appointment: {
                start: '',
                end: '',
                lesson: false,
                court_id: null,
                status_id: 1,
                teacherId: '',
                teacher: ''
            }
        };
    },
    mounted() {
        const self = this;
        self.getCourts();
        self.getAppointments();
        self.getUser();
        self.loading = false;
    },
    methods: {
        /**
        * Function to show the modal for adding an appointment.
        * @param {Object} event - The event object containing the date.
        * @param {Array} events - Optional. Array of events.
        */
        show(event, events = []) {
            const self = this
            self.date = event.date;
            self.events = events;

            self.$modal.show("add-appointment");
        },
        /**
        * Function to retrieve courts data from the database.
        */
        getCourts() {
            const self = this;
            self.$https.get('/api/courts').then(response => self.courts = response.data);
        },
        getUser() {
            const self = this;
            self.$https.get('/api/user').then(response => self.user = response.data);
        },
        /**
        * Function to retrieve appointments data from the database for taken times.
        */
        getAppointments() {
            const self = this;
            self.$https.get('/api/appointments').then(response => self.appointments = response.data);
        },
        disableTime(datm) {
            const self = this;
            const selectedDate = new Date(self.date);
            selectedDate.setHours(datm.getHours());
            selectedDate.setMinutes(datm.getMinutes());
            selectedDate.setSeconds(datm.getSeconds());

            const now = new Date();
            if (selectedDate < now) {
                return true;
            }

            const existingAppointments = this.appointments.filter(appointment => appointment.court_id === this.appointment.court_id);

            if (existingAppointments) {
                for (const appointment of existingAppointments) {
                    const startTime = new Date(appointment.start);
                    const endTime = new Date(appointment.end);

                    if (selectedDate >= startTime && selectedDate < endTime) {
                        return true;
                    }
                }
            }

            return false;
        },
        /** 
        * Function to update the minimum end time of the appointment based on the start time.
        * It sets the end time of the appointment to 60 minutes after the start time if start time is provided.
        */
        updateMinEndTime() {
            const self = this;
            if (self.appointment.start) {
                const startTime = new Date(self.appointment.start);
                startTime.setMinutes(startTime.getMinutes() + 60);
                self.appointment.end = startTime;
            }
        },
        /**
        * Function to add a new appointment.
        */
        addAppointment(isLesson) {
            const self = this;
            self.appointment.court_id = parseInt(self.appointment.court_id);
            self.appointment.lesson = isLesson;

            var date = new Date(self.date);
            self.appointment.start = new Date(date.setHours(self.appointment.start.getHours(), self.appointment.start.getMinutes(), 0));;
            self.appointment.end = new Date(date.setHours(self.appointment.end.getHours(), self.appointment.end.getMinutes(), 0));

            self.$https.post('/api/appointment', self.appointment)
                .then(response => {
                    if (self.appointment.lesson === true) {
                        self.$swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: "Les toegevoegd!",
                            timer: 5000
                        }).then(() => {
                            self.$modal.hide("add-appointment");
                        })
                    } else {
                        self.$swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: "Tennisbaan is gehuurd!",
                            timer: 5000
                        }).then(() => {
                            self.$modal.hide("add-appointment");
                        });
                    }
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Error adding appointment:', error);
                });
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
