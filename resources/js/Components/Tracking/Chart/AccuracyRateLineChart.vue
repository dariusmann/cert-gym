<script>
import Card from "primevue/card";
import TrackingService from "@/Services/tracking.service.js";

export default {
    name: "AccuracyRateLineChart",
    components: {Card},
    data: function () {
        return {
            dataLoaded: false,
            options: {
                chart: {
                    zoom: {
                        enabled: false
                    }
                },
                xaxis: {
                    categories: []
                },
                yaxis: {
                    title: {
                        text: 'Accuracy %',
                    },
                    max: 100,
                    min: 0
                },
                colors: ['#eb826b'],
                stroke: {
                    curve: 'smooth'
                },
            },
            series: [{
                name: 'series-1',
                data: []
            }]
        }
    },
    async mounted() {
        const stats = await TrackingService.readAccuracyRateStats();
        this.series = [{
            name: 'series-1',
            data: stats.accuracyRates
        }];

        this.options.xaxis.categories = stats.dates;
        this.dataLoaded = true;
    }
}
</script>

<template>

    <Card>
        <template #content>
            <div class="flex justify-center text-center">
                <div class="prose">
                    <h2>Accuracy Rate Progression</h2>
                    <p>Shows your overall progress in right answered question in form of the accuracy rate.</p>
                    <p>The accuracy rate is the percentage of question you answer right.</p>
                </div>
            </div>
            <div class="flex justify-center">
                <apexchart v-if="dataLoaded"
                           width="800"
                           height="400"
                           type="line"
                           :options="options"
                           :series="series"></apexchart>
            </div>

        </template>
    </Card>

</template>

<style scoped>

</style>
