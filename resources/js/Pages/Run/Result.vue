<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Card from 'primevue/card';
import QuestionResult from "@/Components/Questions/QuestionResult.vue";
import ResultOverview from "@/Components/Run/ResultOverview.vue";

export default {
    name: "Result",
    props: ['run'],
    components: {ResultOverview, QuestionResult, AuthenticatedLayout, Card},
    data: function () {
        return {
            currentIndex: 0,
        }
    },
    methods: {
        changeQuestion(index) {
            this.currentIndex = index
        },
        classesBadge(index) {
            return {
                'x': this.isIndexNotAttempted(index) && this.currentIndex !== index,
                'bg-green-200': this.isIndexAttemptCorrect(index) && this.currentIndex !== index,
                'bg-red-200': !this.isIndexNotAttempted(index) && !this.isIndexAttemptCorrect(index) && this.currentIndex !== index,
                'badge-accent': this.currentIndex === index,
            }
        },
        navigateBack() {
            if (this.currentIndex > 0) {
                this.currentIndex = this.currentIndex - 1;
            }
        },
        isIndexAttemptCorrect(index) {
            return this.run.run_questions[index]?.attempt?.answered_correctly === true;
        },
        isIndexNotAttempted(index) {
            return this.run.run_questions[index]?.attempt === null;
        },
        navigateNext() {
            if (this.run.run_questions.length - 1 > this.currentIndex) {
                this.currentIndex = this.currentIndex + 1;
            }
        },
    },

    computed: {
        currentSelectedAnswer() {
            return this.run.run_questions[this.currentIndex].attempt?.responses[0]?.answer ?? null;
        },
    }
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="h-5"></div>

        <ResultOverview :run="run"/>

        <div class="container mt-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="col-span-1 sm:col-span-2 lg:col-span-3">
                    <QuestionResult
                        :key="run.run_questions[currentIndex].question.id"
                        :init-question="run.run_questions[currentIndex].question"
                        :init-selected-answer="currentSelectedAnswer"
                        :question-number="currentIndex + 1"
                    />
                </div>
                <div class="col-span-1">
                    <Card class="h-full">
                        <template #content>
                            <div class="grid grid-cols-7 gap-1">
                                <div v-for="(runQuestion, index) in run.run_questions"
                                     class="badge cursor-pointer"
                                     :class="classesBadge(index)"
                                     @click="changeQuestion(index)"
                                >
                                    {{ index + 1 }}
                                </div>
                            </div>
                            <div class="h-4"></div>
                            <div class="flex justify-center items-center">
                                <div class="link link-primary" @click="navigateBack">Back</div>
                                <div class="w-6"></div>
                                <div class="link link-primary" @click="navigateNext">Next</div>
                            </div>
                        </template>
                    </Card>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>
</style>
