<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import CategoryTree from "@/Components/Category/CategoryTree.vue";
import Card from 'primevue/card';
import QuestionRunService from "@/Services/question.run.service.js";

export default {
    name: "CreateCategoryRun",
    props: ['categories'],
    components: {CategoryTree, AuthenticatedLayout, Card},
    data() {
        return {
            selectedCategoryIds: []
        }
    },
    methods: {
        updateSelectedCategories({ categoryId, isChecked }) {
            if (isChecked && !this.selectedCategoryIds.includes(categoryId)) {
                this.selectedCategoryIds.push(categoryId);
            } else if (!isChecked && this.selectedCategoryIds.includes(categoryId)) {
                this.selectedCategoryIds = this.selectedCategoryIds.filter(id => id !== categoryId);
            }
        },
        async submit(){
            const questionRun = await QuestionRunService.createCategoryRun(this.selectedCategoryIds);
            window.location = '/page/run/' + questionRun.id + '/practice'
        }
    }
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="h-3"></div>
        <Card>
            <template #title>Category Run</template>
            <template #content>
                <CategoryTree :categories="categories" @update:selected="updateSelectedCategories"/>
                <button class="btn btn-primary" @click="submit">Create Run</button>
            </template>
        </Card>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>
