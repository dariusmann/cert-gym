<script>
import Card from "primevue/card";
import TrackingService from "@/Services/tracking.service.js";

export default {
    name: "ReadinessScore",
    components: {Card},
    data: function () {
        return {
            ReadinessScore:''
        }
    },
    async mounted() {
        const data = await TrackingService.readReadinessScore();
        this.ReadinessScore = data.ReadinessScore;
    }
}
</script>

<template>
    <Card class="h-full">
        <template #content>
            <div class="flex justify-center text-center">
                <div class="prose">
                    <h2>Readiness Score</h2>
                </div>
            </div>
            <div class="flex justify-center">
                <div class="stats">
                    <div class="stat text-center">
                        <div class="stat-title">Calculated by your recent performance <br> across the whole Task List </div>
                        <div class="stat-value">{{ ReadinessScore }}%</div>
                        <div class="stat-desc">Base on the BACB exam criteria.</div>
                        <div class="stat-desc">
                            <a href="" class="link">
                                Learn more
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </Card>
</template>

<style scoped>

</style>
