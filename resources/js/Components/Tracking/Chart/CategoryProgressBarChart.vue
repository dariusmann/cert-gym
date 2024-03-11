<script>
import Card from "primevue/card";
import TrackingService from "@/Services/tracking.service.js";

export default {
    name: "CategoryProgressBarChart",
    components: {Card},
    async created() {
        const stats = await TrackingService.readCategoriesAccuracyRateStats();


        this.series = [{
            name: 'Right',
            data: stats.right_attempts
        }, {
            name: 'Wrong',
            data: stats.wrong_attempts
        }];

        this.options.xaxis.categories = stats.category_labels;
        this.dataLoaded = true;
    },
    data: function () {
        return {
            dataLoaded: false,
            series: [],
            chartOptions: {
                chart: {
                    type: 'bar',
                    height: 350,
                    stacked: true,
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        legend: {
                            position: 'bottom',
                            offsetX: -10,
                            offsetY: 0
                        }
                    }
                }],
                plotOptions: {
                    bar: {
                        horizontal: false,
                        borderRadius: 10,
                        dataLabels: {
                            total: {
                                enabled: true,
                                style: {
                                    fontSize: '13px',
                                    fontWeight: 900
                                }
                            }
                        }
                    },
                },
                xaxis: {
                    categories: [],
                },
                colors: ['#26c281', '#cf000f'],
                legend: {
                    position: 'right',
                    offsetY: 40
                },
                fill: {
                    opacity: 1
                }
            },


        }
    }
}
</script>

<template>
    <Card>
        <template #content>
            <div class="flex justify-center text-center">
                <div class="prose">
                    <h2>Accuracy Rate by Category</h2>
                    <p>Accuracy rate shows the percentage of questions you've answered correctly.</p>
                </div>
            </div>
            <apexchart type="bar" height="350" :options="chartOptions" :series="series"></apexchart>
        </template>
    </Card>
</template>

<style scoped>

</style>
