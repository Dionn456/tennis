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
export default {
    data() {
        return {
            user: {},
            roles: [],
        };
    },
    mounted() {
        const self = this
        self.fetchUser();
        self.getRoles();
    },
    methods: {
        fetchUser() {
            const self = this;
            self.$https.get(`/api/users/${self.$route.params.id}`).then(async (response) => {
                self.user = response.data;
            });
        },
        getRoles() {
            const self = this;
            self.$https.get('/api/roles').then(async (response) => {
                self.roles = response.data;
            });
        },
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
        navigateTo(name, id = null) {
            if (id) this.$router.push({ name, params: { id } });
            else this.$router.push({ name });
        },
    },
    computed: {
        formattedBirthDate() {
            return this.user.birth_date.slice(0, 10);
        }
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