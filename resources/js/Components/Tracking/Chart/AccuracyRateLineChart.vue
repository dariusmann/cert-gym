<script>
import Card from "primevue/card";

export default {
    name: "AccuracyRateLineChart",
    components: {Card},
    data: function () {
        return {
            options: {
                chart: {
                    id: 'vuechart-example',
                    zoom: {
                        enabled: false
                    }
                },
                xaxis: {
                    categories: ['1 nov', '2 nov', '3 nov', '4 nov', '5 nov', '6 nov', '7 nov', '8 nov', '9 nov', '10 nov', '11 nov', '12 nov', '13 nov', '14 nov', '15 nov', '16 nov', '17 nov', '18 nov', '19 nov', '20 nov', '21 nov', '22 nov', '23 nov', '24 nov', '25 nov', '26 nov', '27 nov', '28 nov', '29 nov', '30 nov', '1 dec', '2 dec', '3 dec', '4 dec', '5 dec', '6 dec', '7 dec', '8 dec', '9 dec', '10 dec', '11 dec', '12 dec', '13 dec', '14 dec', '15 dec', '16 dec', '17 dec', '18 dec', '19 dec', '20 dec', '21 dec', '22 dec', '23 dec', '24 dec', '25 dec', '26 dec', '27 dec', '28 dec', '29 dec', '30 dec', '31 dec']

                },
                yaxis: {
                    title: {
                        text: 'Accuracy %',
                    },
                },
                colors: ['#eb826b'],
            },
            series: [{
                name: 'series-1',
                data: [25, 25, 26, 25, 26, 26, 28, 29, 31, 32, 34, 35, 37, 37, 39, 39, 41, 41, 41, 42, 45, 47, 48, 49, 51, 51, 50, 49, 51, 52, 54, 55, 57, 59, 59, 60, 61, 62, 63, 64, 67, 67, 68, 67, 68, 69, 71, 72, 71, 71, 72, 73, 75, 76, 76, 78, 78, 80, 81, 84, 85]
            }]
        }
    }
}
</script>

<template>

    <Card>
        <template #content>
            <div class="flex justify-center text-center">
                <div class="prose">
                    <h2>Accuracy Rate Progression</h2>
                    <p>Accuracy rate shows the percentage of questions you've answered correctly.</p>
                </div>
            </div>
            <apexchart width="1200" type="line" :options="options" :series="series"></apexchart>
        </template>
    </Card>

</template>

<style scoped>

</style>
