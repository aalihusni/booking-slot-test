<template>
    <div>
        <button class="btn" @click="openModal">Add new appointment</button>
        <appointment-modal v-model="modalOpen"></appointment-modal>
    </div>
</template>

<script>
    import AppointmentModal from "../components/AppointmentModal.vue";
    export default {
        components: {
            AppointmentModal
        },
        data() {
            return {
                modalOpen: false
            }
        },
        methods: {
            openModal() {
                this.modalOpen = !this.modalOpen;
            }
        }
    };
</script>