<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import QuestionTest from "@/Components/Practice/QuestionTest.vue";

export default {
    name: "Random",
    components: {QuestionTest, AuthenticatedLayout}
}
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>
        <div>
            <QuestionTest/>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
