<template>
    <div class="modal" v-show="value">
        {{ output }}
        <div class="container">
            <div class="modal__title">Add New Appointment</div>
            <form @submit="formSubmit">
                <input v-model="first_name" placeholder="First Name">
                <input v-model="last_name" placeholder="Last Name">
                <input v-model="car_plate" placeholder="Car Plate">
                <div class="example">
                    <datepicker
                            v-model="appointment_date"
                            ref="programaticOpen"
                            :disabled-dates="disabledDates"
                            format="yyyy-MM-dd"
                    >Appointment Date
                    </datepicker>
                    <button @click="openPicker">Select Date</button>
                </div>
                <div>
                    <vue-timepicker
                            picker
                            v-model="appointment_time"
                            :hour-range="[9,10,11,12,13,14,15,16,17,18]"
                            :minute-range="[0, 30]"
                    ></vue-timepicker>
                </div>
                <button class="btn btn-success">Submit</button>
            </form>
            <button @click.prevent="close"
                    class="mt-3 border-b border-teal font-semibold">Close
            </button>
        </div>
    </div>
</template>

<script>
    import Datepicker from "vuejs-datepicker/dist/vuejs-datepicker.esm.js";
    import VueTimepicker from 'vue2-timepicker/src/vue-timepicker.vue';
    import Toasted from 'vue-toasted';

    Vue.use(Toasted);

    export default {
        components: {
            Datepicker,
            VueTimepicker,

        },
        data() {
            return {
                first_name: '',
                last_name: '',
                car_plate: '',
                appointment_date: '',
                appointment_time: '',
                output: '',
                disabledDates: {
                    ranges: [{
                        to: this.endDate(),// Disable all dates up to specific date
                        from: this.startDate(),
                    }]
                }
            };

        },
        name: 'AppointmentModal',
        props: {
            value: {
                required: true
            }
        },
        methods: {
            endDate() {
                var date = new Date();
                return date.addDays(20);
            },
            startDate() {
                var date = new Date();
                return date.addDays(-720);
            },
            close() {
                this.$emit("input", !this.value);
            },
            openPicker() {
                this.$refs.programaticOpen.showCalendar();
            },
            formSubmit(e) {
                e.preventDefault();
                let currentObj = this;
                this.axios.post('http://booking.test/api/appointment', {
                    first_name: currentObj.first_name,
                    last_name: currentObj.last_name,
                    car_plate: currentObj.car_plate,
                    appointment_date: currentObj.appointment_date,
                    appointment_time: currentObj.appointment_time,
                })
                    .then(function (response) {
                        currentObj.$toasted.show(response.data.message, {type: 'info'}).goAway(1500);
                    })
                    .catch(function (error) {
                        currentObj.$toasted.show(error, {type: 'error'}).goAway(1500);
                    });
            }
        }
    };
</script>


<style lang="css" scoped>
    .modal {
        /*background-color: rgba(0, 0, 0, 0.7);*/
    }
</style>