<script>
import Card from "primevue/card";
import TrackingService from "@/Services/tracking.service.js";
export default {
    name: "Overview",
    components: {Card},
    data: function () {
        return {
            overviewData:''
        }
    },
    async mounted() {
        const data = await TrackingService.readOverviewStats();
        this.overviewData = data;
    }
}
</script>

<template>
    <Card class="h-full">
        <template #content>
            <div class="flex justify-center text-center">
                <div class="prose">
                    <h2>Overview</h2>
                </div>
            </div>

            <div class="flex justify-center">
                <div class="stats">
                    <div class="stat">
                        <div class="stat-title">Total Answered Questions</div>
                        <div class="stat-value text-center">{{ overviewData.total }}</div>
                    </div>
                    <div class="stat">
                        <div class="stat-title">Total Right Answered Questions</div>
                        <div class="stat-value text-center text-green-600">{{ overviewData.correct_answered }}</div>
                    </div>
                    <div class="stat">
                        <div class="stat-title">Accuracy Rate</div>
                        <div class="stat-value text-center text-primary">{{ overviewData.accuracy_rate }}%</div>
                        <div class="stat-desc">(of last 100 questions)</div>
                    </div>
                </div>
            </div>

        </template>
    </Card>
</template>

<style scoped>

</style>
