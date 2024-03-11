<script>
import Card from "primevue/card";
export default {
    name: "CategoryProgressBarChart",
    components: {Card},
    data: function () {
        return {

            series: [{
                name: 'Wrong',
                data: [73, 27, 10, 93, 77, 56]
            }, {
                name: 'Right',
                data: [27, 73, 90, 7, 23, 44]
            }],
            chartOptions: {
                chart: {
                    type: 'bar',
                    height: 350,
                    stacked: true,
                    toolbar: {
                        show: true
                    },
                    zoom: {
                        enabled: true
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
                    categories: ['Measurement', 'ALignment', 'Research', 'Other category',
                        'Other category', 'Other category'
                    ],
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
