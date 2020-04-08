<template>
    <div class="modal" v-show="value">
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
    import VueTimepicker from 'vue2-timepicker/src/vue-timepicker.vue'

    export default {
        components: {
            Datepicker,
            VueTimepicker
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
                    first_name: this.first_name,
                    last_name: this.last_name,
                    car_plate: this.car_plate,
                    appointment_date: this.appointment_date,
                    appointment_time: this.appointment_time,
                })
                    .then(function (response) {
                        currentObj.output = response.data;
                    })
                    .catch(function (error) {
                        currentObj.output = error;
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