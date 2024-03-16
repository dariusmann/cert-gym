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
        updateSelectedCategories({categoryId, isChecked}) {
            if (isChecked && !this.selectedCategoryIds.includes(categoryId)) {
                this.selectedCategoryIds.push(categoryId);
            } else if (!isChecked && this.selectedCategoryIds.includes(categoryId)) {
                this.selectedCategoryIds = this.selectedCategoryIds.filter(id => id !== categoryId);
            }
        },
        async submit() {
            const questionRun = await QuestionRunService.createCategoryRun(this.selectedCategoryIds);
            window.location = '/page/run/' + questionRun.id + '/practice'
        }
    },
    computed: {
        disabledButton: function () {
            return this.selectedCategoryIds.length === 0;
        },
        buttonText: function () {
            return this.disabledButton ? "Select Categories" : "Start Run";
        }
    }
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="h-5"></div>
        <Card>
            <template #content>
                <div class="prose">
                    <div class="flex">
                        <h1>Create a Task List run</h1>
                        <button class="btn btn-primary ml-4"
                                :disabled="disabledButton"
                                @click="submit">
                            {{ buttonText}}
                        </button>
                    </div>

                    <p>Select the Task List you want to practice on.You can check the official task list
                        <a class="link link-primary"
                           href="https://www.bacb.com/wp-content/uploads/2020/05/RBT-2nd-Edition-Task-List_230130-a.pdf"
                           target="_blank">here</a>.
                    </p>

                </div>
                <div class="h-4"></div>
                <CategoryTree :categories="categories" @update:selected="updateSelectedCategories" :level="1"/>
            </template>
        </Card>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>
