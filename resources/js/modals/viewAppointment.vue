<template>
    <modal name="view-appointment" height="400">

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
        show(event, events = []) {
            const self = this
            self.date = event.date;
            self.events = events;

            self.$modal.show("view-appointment");
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
