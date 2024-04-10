<template>
    <div class="container">
        <view-invoice />
        <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th class="th-sm">#</th>
                    <th class="th-sm">Datum activiteit</th>
                    <th class="th-sm">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(appointment, index) in appointments" :key="appointment.id">
                    <td class="col-1">{{ index + 1 }}</td>
                    <td class="col-3">{{ formatDate(new Date(appointment.start)) }}</td>
                    <td class="col-3">{{ appointment.status.name }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>


<script>
import viewInvoice from '../../modals/viewInvoice.vue';

export default {
    data() {
        return {
            appointments: []
        };
    },
    components: { viewInvoice },
    mounted() {
        // Fetch appointments when the component is mounted
        this.fetchAppointments();
    },
    methods: {
        // Format date to a readable string
        formatDate(date) {
            const options = { day: 'numeric', month: 'long', year: 'numeric' };
            return date.toLocaleDateString(undefined, options);
        },
        // Fetch appointments data from the backend API
        async fetchAppointments() {
            try {
                const response = await this.$https.get('/api/appointmentsUser');
                this.appointments = response.data;

                const currentDate = new Date();
                // Loop through appointments to update status based on date
                this.appointments.forEach(async (appointment) => {
                    const appointmentDate = new Date(appointment.start);
                    if (appointmentDate < currentDate && appointment.status_id !== 2) {
                        // Update appointment status in the array
                        appointment.status_id = 2;
                        // Update status in the backend
                        await this.updateAppointmentStatus(appointment.id, 2);
                    }
                });

                // Sort appointments after processing
                this.sortAppointmentsByDateAndId();
            } catch (error) {
                console.error('Error fetching appointments:', error);
            }
        },

        // Update appointment status by making a PUT request to the API
        async updateAppointmentStatus(appointmentId, statusId) {
            try {
                await this.$https.put(`/api/appointment/${appointmentId}`, {
                    status_id: statusId
                });
            } catch (error) {
                console.error(`Error updating status for appointment ${appointmentId}:`, error);
            }
        },

        // Sort appointments by date and ID
        sortAppointmentsByDateAndId() {
            this.appointments.sort((a, b) => {
                const dateA = new Date(a.start);
                const dateB = new Date(b.start);

                if (dateA.getTime() === dateB.getTime()) {
                    return b.id - a.id;
                }
                return dateB.getTime() - dateA.getTime();
            });
        },
    },
};
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