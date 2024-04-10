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
export default {
    data() {
        return {
            court: {},
        };
    },
    mounted() {
        const self = this
        self.fetchCourt();
    },
    methods: {
        fetchCourt() {
            const self = this;
            self.$https.get(`/api/courts/${self.$route.params.id}`).then(async (response) => {
                self.court = response.data;
            });
        },
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