<template>
    <div>
        <addAppointment ref="add" />
        <viewAppointment ref="view" />
        <card title="Kalender">
            <FullCalendar :options="calendarOptions" />
        </card>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'

import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'

import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';

import addAppointment from '../../modals/addAppointment.vue';
import viewAppointment from '../../modals/viewAppointment.vue';

import 'vue-select/dist/vue-select.css';

export default {
    middleware: 'auth',
    components: {
        FullCalendar, DatePicker, addAppointment, viewAppointment
    },
    data() {
        return {
            calendarOptions: {
                plugins: [dayGridPlugin, interactionPlugin],
                initialView: 'dayGridMonth',
                dateClick: this.handleDateclick,
                eventClick: this.handleEventClick,
                events: [],
                locale: 'nl'
            },
        }
    },
    mounted() {
        const self = this;
        this.fetchData();
    },
    metaInfo() {
        return { title: "Kalender" }
    },
    methods: {
        async fetchData() {
            try {
                const appointmentsResponse = await this.$https.get('/api/appointmentsUser');
                const lessonsResponse = await this.$https.get('/api/lessons');

                const currentDate = new Date();

                // Filter appointments that are not in the past
                const modifiedAppointments = appointmentsResponse.data.filter(event => {
                    const eventDate = new Date(event.start);
                    return eventDate >= currentDate;
                }).map(event => ({
                    ...event,
                    title: 'Gehuurd'
                }));

                // Filter lessons that are not in the past
                const modifiedLessons = lessonsResponse.data.filter(event => {
                    const eventDate = new Date(event.start);
                    return eventDate >= currentDate;
                }).map(event => ({
                    ...event,
                    title: 'Les'
                }));

                this.calendarOptions.events = [
                    ...modifiedAppointments,
                    ...modifiedLessons
                ];
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        },
        /**
        * Function to handle click events on dates.
        * @param {Event} event - The click event object.
        */
        handleDateclick(event) {
            const self = this;

            if (new Date(event.date) < new Date().setHours(0, 0, 0, 0)) {
                return self.$swal.fire({
                    icon: 'error',
                    title: 'Fout!',
                    text: "Je kunt geen baan huren in het verleden!",
                    timer: 10000
                });
            }

            var events = self.filterEventsDay(event.date);
            try {
                if (self.user.role_id != 1) {
                    self.$refs.add.show(event, events);
                }
            } catch (error) {
                console.error('Error:', error);
            }

        },
        filterEventsDay(date) {
            const self = this;
            return self.calendarOptions.events.filter((event) => (new Date(event.start).setHours(0, 0, 0, 0) == new Date(date).setHours(0, 0, 0, 0)))  // && event.dentist.user_id == self.appointment.dentist.id
        },
        /**
        * Function to handle click events on events.
        * @param {Event} event - The click event object.
        */
        handleEventClick(event) {
            const self = this;
            console.warn('event click', event);
            self.$refs.view.show(event.event);
        },
    },
    computed: mapGetters({
        user: 'auth/user'
    }),
}
</script>


<style>
.fc-prev-button,
.fc-next-button {
    background-color: #23679e !important;
    color: #aee2ff !important;
    border: none !important;
}

.fc-prev-button {
    border-radius: 20px 0px 0px 20px !important;
}

.fc-next-button {
    border-radius: 0px 20px 20px 0px !important;
}

.fc-prev-button:hover,
.fc-next-button:hover {
    background-color: #4a84be !important;
    color: #aee2ff !important;
    border: none !important;
}

.fc-today-button {
    border-radius: 50px !important;
    padding: 6px 25px !important;
    background-color: #23679e !important;
    opacity: 0.8 !important;
    border: none !important;
}

.fc-today-button:hover {
    background-color: #4a84be !important;
    border: none !important;
}
</style>
