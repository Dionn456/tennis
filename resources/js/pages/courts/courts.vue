<template>
    <div class="container">
        <div class="row mb-1">
            <div class="col-3">
                <input type="text" v-model="search" class="form-control form-control-sm narrow-search diss" placeholder="Zoeken...">
            </div>
            <div class="col d-flex justify-content-end align-items-center">
                <button type="button" class="btn btn-primary" @click="openModal()">Baan toevoegen</button>
                <addCourt />

            </div>
        </div>

        <table class="table table-striped w-100">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Naam</th>
                    <th scope="col" class="text-center">Acties</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="court in filteredCourts" :key="court.id">
                    <td scope="row">{{ court.id }}</td>
                    <td >{{ court.name }}</td>
                    <td >
                        <div class="d-flex justify-content-center gap-3">
                            <a @click="navigateTo('court', court.id)" class="float-end">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="orange" width="20">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                            </a>
                            <a @click="removeCourt(court.id)" class="float-end">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="red" width="20">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import addCourt from '../../modals/addCourt.vue';

export default {
    data() {
        return {
            search: '',
            courts: [],
            visible: false,
        };
    },
    components: { addCourt },
    mounted() {
        const self = this;
        self.fetchCourt();
    },
    methods: {
        /* Method to open add-court modal */
        openModal() {
            const self = this;
            self.$modal.show("add-court");
        },
        /* Fetching courts from API when called */
        fetchCourt() {
            const self = this;
            self.$https.get('/api/courts').then(response => self.courts = response.data);
        },
        navigateTo(name, id = null) {
            if (id) this.$router.push({ name, params: { id } });
            else this.$router.push({ name });
        },
        /* Confirming deletion of court and then sending delete request to API */
        removeCourt(courtId) {
            const self = this;
            if (confirm('Weet je zeker dat je de baan wilt verwijderen?')) {
                self.$https.delete(`/api/courts/${courtId}`)
                    .then(response => {
                        /* Removing deleted court from courts array */
                        const index = self.courts.findIndex(court => court.id === courtId);
                        if (index !== -1) {
                            self.courts.splice(index, 1);
                        }

                        /* Showing success message using sweetalert */
                        self.$swal.fire({
                            icon: 'success',
                            title: 'Gelukt!',
                            text: "Baan verwijderd.",
                            timer: 3000
                        });
                    })
                    .catch(error => {
                        console.error('Gebruiker niet kunnen verwijderen:', error);
                    });
            }
        },
    },
    computed: {
        /* Filtering courts based on search string */
        filteredCourts() {
            const self = this;
            return self.courts.filter(court => {
                return court.id == self.search.toLowerCase() ||
                    court.name.toLowerCase().includes(self.search.toLowerCase())
            });
        }
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