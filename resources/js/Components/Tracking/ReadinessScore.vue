<script>
import Card from "primevue/card";

export default {
    name: "ReadinessScore",
    components: {Card}
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
                    <div class="stat">
                        <div class="stat-title">Acurancy rate of last 100 questions</div>
                        <div class="stat-value text-center">73%</div>
                    </div>
                </div>
            </div>
        </template>
    </Card>
</template>

<style scoped>

</style>
