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
            events: []
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
