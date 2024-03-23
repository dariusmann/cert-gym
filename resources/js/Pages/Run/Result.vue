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
                'bg-green-200': this.isIndexAttemptCorrect(index) && this.currentIndex !== index,
                'bg-red-200': !this.isIndexAttemptCorrect(index) && this.currentIndex !== index,
                'badge-secondary': false,
                'badge-accent': this.currentIndex === index,
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
        correctAnswersCount() {
            return this.run.run_questions.filter(question => question.attempt?.answered_correctly === true).length;
        },
        incorrectAnswersCount() {
            return this.run.run_questions.filter(question => question.attempt?.answered_correctly === false).length;
        },
        examPassed() {
            const percentageCorrect = (this.correctAnswersCount / this.run.run_questions.length) * 100;
            return percentageCorrect >= 0;
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
                            <div class="flex justify-start items-center">
                                <div class="link link-primary" @click="navigateBack">Back</div>
                                <div class="w-6"></div>
                                <div class="link link-primary" @click="navigateNext">Next</div>
                            </div>
                            <div class="results mt-5">
                                <div class="result correct">
                                    Correct answers: {{ correctAnswersCount }}
                                </div>
                                <div class="result incorrect">
                                    Incorrect answers: {{ incorrectAnswersCount }}
                                </div>
                                <div class="result status">
                                    Exam status: <span :class="examPassed ? 'passed' : 'failed'">{{ examPassed ? 'Passed' : 'Failed' }}</span>
                                </div>
                            </div>
                        </template>
                    </Card>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>
.results {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.result {
    font-size: 1.2em;
}

.correct {
    color: green;
}

.incorrect {
    color: red;
}

.status {
    font-weight: bold;
}

.passed {
    color: green;
}

.failed {
    color: red;
}
</style>
