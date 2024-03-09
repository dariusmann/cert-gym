<script>
import Card from "primevue/card";
export default {
    name: "Overview",
    components: {Card}
}
</script>

<template>
    <Card>
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
                        <div class="stat-value text-center">433</div>
                    </div>
                    <div class="stat">
                        <div class="stat-title">Right Answered Questions</div>
                        <div class="stat-value text-center text-green-600">277</div>
                    </div>
                    <div class="stat">
                        <div class="stat-title">Accuracy Rate</div>
                        <div class="stat-value text-center text-primary">76%</div>
                    </div>

                </div>
            </div>

        </template>
    </Card>
</template>

<style scoped>

</style>
