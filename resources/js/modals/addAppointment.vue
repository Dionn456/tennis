<template>
    <modal name="add-appointment" height="400">
        <div class="py-5 px-5">
            <div class="mb-2 row">
                <label class="col-md-12 mb-1">Banen</label>
                <div class="col-md-12">
                    <select id="rol" class="form-control mb-3" v-model="appointment.court_id">
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
                <button type="button" class="btn btn-primary w-100" @click="addAppointment()">Baan huren</button>
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
            appointment: {
                start: '',
                end: '',
                lesson: false,
                court_id: null,
                status_id: 1,
            }
        };
    },
    mounted() {
        const self = this;
        self.getCourts();
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
        disableTime(date) {
            const now = new Date();
            const selectedDate = new Date(date);

            if (this.appointment.end) {
                const endTime = new Date(this.appointment.end);
                return selectedDate < now || selectedDate < endTime;
            }
            return selectedDate < now;
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
        addAppointment() {
            const self = this;
            self.$https.post('/api/appointment', self.appointment).then(response => {
                self.$swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: "Baan gehuurd!.",
                    timer: 5000
                }).then(() => {
                    window.location.href = '/appointments';
                });
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
