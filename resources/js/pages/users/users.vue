<template>
    <div class="container">
        <div class="row mb-1">
            <div class="col-3">
                <input type="text" v-model="search" class="form-control form-control-sm narrow-search diss" placeholder="Zoeken...">
            </div>
            <div class="col d-flex justify-content-end align-items-center">
                <!-- <button type="button" class="btn btn-primary" @click="openModal()">Patiënt toevoegen</button> -->
            </div>
        </div>

        <table class="table table-striped w-100">
            <thead>
                <tr>
                    <th scope="col">Naam</th>
                    <th scope="col">Email</th>
                    <th scope="col">Rol</th>
                    <th scope="col" class="text-center">Acties</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in users" :key="user.id">
                    <td scope="row">{{ user.name }}</td>
                    <td >{{ user.email }}</td>
                    <td >{{ user.role.name }}</td>
                    <td >
                        <div class="d-flex justify-content-center gap-3">
                            <a :href="'/user/' + user.id" class="float-end">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="orange" width="20">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                            </a>
                            <a @click="removeUser(user.id)" class="float-end">
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
export default {
    data() {
        return {
            search: '',
            users: [],
            visible: false,
        };
    },
    components: {},
    mounted() {
        const self = this;
        self.fetchUser();
    },
    methods: {
        /* Method to open add-user modal */
        openModal() {
            const self = this;
            self.$modal.show("add-user");
        },
        /* Fetching users from API when called */
        fetchUser() {
            const self = this;
            self.$https.get('/api/users').then(response => self.users = response.data);
        },
        /* Confirming deletion of user and then sending delete request to API */
        removeUser(userId) {
            const self = this;
            if (confirm('Weet je zeker dat je de gebruiker wilt verwijderen?')) {
                self.$https.delete(`/api/users/${userId}`)
                    .then(response => {
                        /* Removing deleted user from users array */
                        const index = self.users.findIndex(user => user.id === userId);
                        if (index !== -1) {
                            self.users.splice(index, 1);
                        }

                        /* Showing success message using sweetalert */
                        self.$swal.fire({
                            icon: 'success',
                            title: 'Gelukt!',
                            text: "Gebruiker verwijderd.",
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
        /* Filtering users based on search string */
        filteredUsers() {
            const self = this;
            return self.users.filter(user => {
                return user.firstname.toLowerCase().includes(self.search.toLowerCase()) ||
                    user.email.toLowerCase().includes(self.search.toLowerCase()) ||
                    user.role.name.toLowerCase().includes(self.search.toLowerCase());
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