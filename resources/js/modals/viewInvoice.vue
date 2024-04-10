<template>
    <modal name="view-invoice">
        <div>
            <div>
                <header class="modal-header" id="modalTitle">
                    <slot name="header">Alle gehuurde tijden</slot>
                    <button type="button" class="close-btn" @click="close()">x</button>
                </header>

                <main class="modal-body" id="modalDescription">
                    <div class="mb-3" v-for="appointment in appointments" :key="appointment.id">
                        <td class="col-1">{{ appointment.id }}</td>
                        <td class="col-3"></td>
                        <td class="col-3">{{ appointment.status.name }}</td>
                    </div>
                </main>

                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="$modal.hide('view-appointment')">
                        Sluiten
                    </button>
                </footer>
            </div>
        </div>
    </modal>
</template>

<script>
export default {
    name: 'view-invoice',
    data() {
        return {
        };
    },
    mounted() {
    },
    methods: {
        close() {
            const self = this;
            self.$modal.hide("view-invoice");
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