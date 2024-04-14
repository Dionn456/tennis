<template>
    <div class="container mt-5">
        <h1 class="text-center mb-5">Verander baan</h1>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="fw-bold">Naam</label>
                    <input type="text" class="form-control mb-3 diss" v-model="court.name" />
                </div>
            </div>
            <div class="text-center mt-3">
                <button type="button" class="btn btn-primary rounded-pill px-3 fw-bold diss" style="width: 200px;"
                    @click="updateCourt()">Opslaan</button>
            </div>
        </div>
    </div>
</template>


<script>
import { mapGetters } from 'vuex';

export default {
    data() {
        return {
            court: {},
        };
    },
    // Fetches court data based on route params when the component is mounted
    mounted() {
        const self = this

        // check user has role admin if not navigate to welcome (homepage)
        if (self.user.role_id !== 1) self.navigateTo('welcome');


        self.fetchCourt();
    },
    methods: {
        // Fetches specific court data based on route params
        fetchCourt() {
            const self = this;
            self.$https.get(`/api/courts/${self.$route.params.id}`).then(async (response) => {
                self.court = response.data;
            });
        },
        // Sends updated court data to the API and shows success message
        updateCourt() {
            const self = this;
            self.$https.post(`/api/courts/${self.court.id}`, self.court);
            self.navigateTo('courts');
            self.$swal.fire({
                icon: 'success',
                title: 'Gelukt!',
                text: "Baan aangepast.",
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
        // This computed property is not used in this component but could be useful for formatting purposes
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