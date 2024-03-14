<script>
import Card from "primevue/card";
import TrackingService from "@/Services/tracking.service.js";

export default {
    name: "CategoryProgressBarChart",
    components: {Card},
    async created() {
        const stats = await TrackingService.readCategoriesAccuracyRateStats();


        this.series = [{
            name: 'Accuracy Rate',
            data: stats.accuracy_rate
        }];

        this.options.xaxis.categories = stats.category_labels;
        this.dataLoaded = true;
    },
    data: function () {
        return {
            dataLoaded: false,
            series: [],
            options: {
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
                yaxis: {
                    title: {
                        text: 'Accuracy %',
                    },
                    max: 100,
                },
                colors: ['#eb826b'],
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
                    <h2>Accuracy Rate by Task List</h2>
                    <p>Accuracy rate shows the percentage of questions <br> you've answered correctly by Task List.</p>
                </div>
            </div>
            <div v-if="dataLoaded" class="flex justify-center">
                <apexchart type="bar" width="800" height="400" :options="options" :series="series"></apexchart>
            </div>
        </template>
    </Card>
</template>

<style scoped>

</style>
