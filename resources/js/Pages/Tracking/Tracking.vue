<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Card from "primevue/card";
import ReadinessScore from "@/Components/Tracking/ReadinessScore.vue";
import Overview from "@/Components/Tracking/Overview.vue";
import AccuracyRateLineChart from "@/Components/Tracking/Chart/AccuracyRateLineChart.vue";
import CategoryProgressBarChart from "@/Components/Tracking/Chart/CategoryProgressBarChart.vue";

export default {
    name: "Tracking",
    components: {CategoryProgressBarChart, AccuracyRateLineChart, Overview, ReadinessScore, AuthenticatedLayout, Card},
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="h-5"></div>

        <div class="grid grid-cols-1 md:grid-cols-3 md:gap-4 gap-y-4">
            <div class="col-span-2">
                <Overview/>
            </div>
            <div>
                <ReadinessScore/>
            </div>
        </div>

        <div class="h-5"></div>

        <AccuracyRateLineChart/>

        <div class="h-5"></div>

        <CategoryProgressBarChart/>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
