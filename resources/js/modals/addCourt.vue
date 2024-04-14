<template>
    <modal name="add-court">
        <div>
            <div>
                <header class="modal-header" id="modalTitle">
                    <slot name="header">Baan toevoegen</slot>
                    <button type="button" class="close-btn" @click="close()">x</button>
                </header>

                <main class="modal-body" id="modalDescription">
                    <div class="mb-3">
                        <label for="firstname" class="form-label">Naam</label>
                        <input v-model="court.name" type="text" class="form-control diss" id="firstname">
                    </div>
                </main>

                <footer class="modal-footer">
                    <button type="button" class="btn btn-primary px-4" @click="addCourt()">Aanmaken</button>
                </footer>
            </div>
        </div>
    </modal>
</template>

<script>
export default {
    name: 'add-court',
    data() {
        return {
            court: {
                name: '',
            },
        };
    },
    mounted() {
    },
    methods: {
        close() {
            const self = this;
            self.$modal.hide("add-court");
        },
        addCourt() {
            const self = this;
            self.$https.post('/api/courts', self.court).then(response => {
                self.$swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: "Baan toegevoegd.",
                    timer: 3000
                }).then(() => {
                    self.$parent.fetchCourt();

                    self.close();
                });
            });
        },
        // Navigates to specified route with optional route parameters
        navigateTo(name, id = null) {
            if (id) this.$router.push({ name, params: { id } });
            else this.$router.push({ name });
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

.close-btn {
    position: absolute;
    top: 0;
    right: 0;
    border: none;
    font-size: 20px;
    padding: 10px;
    cursor: pointer;
    font-weight: bold;
    color: red;
    background: transparent;
    margin-right: 10px;
}
</style>