<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Card from 'primevue/card';
import QuestionResult from "@/Components/Questions/QuestionResult.vue";

export default {
    name: "Result",
    props: ['run'],
    components: {QuestionResult, AuthenticatedLayout, Card},
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
                'bg-green-200': this.isIndexAttemptCorrect(index),
                'bg-red-200': !this.isIndexAttemptCorrect(index),
                'badge-secondary': false
            }
        },
        navigateBack() {
            if (this.currentIndex > 0) {
                this.currentIndex = this.currentIndex - 1;
            }
        },
        isIndexAttemptCorrect(index){
            return this.run.run_questions[index]?.attempt?.answered_correctly === true;
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

        <div class="container">
            <div class="grid grid-cols-4 gap-4">
                <div class="col-span-3">
                    <QuestionResult
                        :key="run.run_questions[currentIndex].question.id"
                        :init-question="run.run_questions[currentIndex].question"
                        :init-selected-answer="currentSelectedAnswer"
                        :question-number="currentIndex + 1"
                    />
                </div>
                <div>
                    <Card class="h-full">
                        <template #content>
                            <div>
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
