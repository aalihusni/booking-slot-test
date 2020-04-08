<template>
    <div>
        <!--{{ events }}-->
        <vue-cal style="height: 500px; width: 800px"
                 hide-view-selector
                 click-to-navigate
                 disable-views
                 :time="true"
                 default-view="week"
                 :min-date="minDate"
                 :time-from="8 * 60"
                 :time-to="18.5 * 60"
                 :time-step="30"
                 :events="events"
        />
    </div>
</template>

<script>
    import VueCal from 'vue-cal'
    import 'vue-cal/dist/vuecal.css';

    export default {
        components: {VueCal},
        data: () => ({
            showModal: false,
            events: [
                //slot 1 first 30mins
                //slot 2 30minutes after first 30mins
                {
                    start: '2020-04-07 10:30',
                    end: '2020-04-07 11:30',
                    // You can also define event dates with Javascript Date objects:
                    // start: new Date(2018, 11 - 1, 16, 10, 30),
                    // end: new Date(2018, 11 - 1, 16, 11, 30),
                    title: 'Doctor appointment',
                    content: '',
                    class: 'health'
                }, {
                    start: '2020-04-07 11:30',
                    end: '2020-04-07 12:30',
                    // You can also define event dates with Javascript Date objects:
                    // start: new Date(2018, 11 - 1, 16, 10, 30),
                    // end: new Date(2018, 11 - 1, 16, 11, 30),
                    title: 'Doctor appointment2',
                    content: '',
                    class: 'health'
                },]
        }),
        computed: {
            minDate() {
                return new Date().addDays(21)
            },
        },
        mounted: function () {
            this.getData()
        },
        methods: {
            getData() {
                let currentObj = this;
                axios.get('http://booking.test/api/appointment')
                    .then(function (response) {
                        currentObj.events = response.data.data;
                    })
                    .catch(function (error) {
                        currentObj.output = error;
                    });
            }
        }
    }
</script>
