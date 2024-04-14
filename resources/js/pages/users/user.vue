<template>
    <div class="container mt-5">
        <h1 class="text-center mb-5">Verandern gebruiker</h1>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="fw-bold">Naam</label>
                    <input type="text" class="form-control mb-3 diss" v-model="user.name" />
                </div>
                <div class="form-group">
                    <label class="fw-bold">Telefoon</label>
                    <input type="text" class="form-control mb-3 diss" v-model="user.phone" />
                </div>
                <div class="form-group">
                    <label class="fw-bold">Email</label>
                    <input type="text" class="form-control mb-3 diss" v-model="user.email" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="fw-bold">Rol</label>
                    <select id="rol" class="form-control mb-3 diss" v-model="user.role_id">
                        <option v-for="role in roles" :key="role.id" :value="role.id">{{ role.name }}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="fw-bold">Wachtwoord</label>
                    <input type="password" class="form-control mb-3 diss" v-model="user.password" />
                </div>
            </div>
            <div class="text-center mt-3">
                <button type="button" class="btn btn-primary rounded-pill px-3 fw-bold diss" style="width: 200px;"
                    @click="updateUser()">Opslaan</button>
            </div>
        </div>
    </div>
</template>


<script>
import { mapGetters } from 'vuex';

export default {
    data() {
        return {
            user: {},
            roles: [],
        };
    },
    // Fetches user data and roles when the component is mounted
    mounted() {
        const self = this

        // check user has role admin if not navigate to welcome (homepage)
        if (self.user.role_id !== 1) self.navigateTo('welcome');

        self.fetchUser();
        self.getRoles();
    },
    methods: {
        // Fetches specific user data based on route params
        fetchUser() {
            const self = this;
            self.$https.get(`/api/users/${self.$route.params.id}`).then(async (response) => {
                self.user = response.data;
            });
        },
        // Fetches all roles available
        getRoles() {
            const self = this;
            self.$https.get('/api/roles').then(async (response) => {
                self.roles = response.data;
            });
        },
        // Sends updated user data to the API and shows success message
        updateUser() {
            const self = this;
            self.$https.post(`/api/users/${self.user.id}`, self.user);
            self.navigateTo("users");
            self.$swal.fire({
                icon: 'success',
                title: 'Gelukt!',
                text: "Gebruiker aangepast.",
                timer: 3000
            })
        },
        // Navigates to specified route with optional route parameters
        navigateTo(name, id = null) {
            if (id) this.$router.push({ name, params: { id } });
            else this.$router.push({ name });
        },
    },
    computed: {
        // Returns formatted birth date (YYYY-MM-DD)
        formattedBirthDate() {
            return this.user.birth_date.slice(0, 10);
        },
        ...mapGetters({
            user: 'auth/user'
        }),
    }
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