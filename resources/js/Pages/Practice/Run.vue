<script>
import QuestionTest from "@/Components/Questions/QuestionTest.vue";
import QuestionAttemptService from "@/Services/question.attempt.service.js";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Card from 'primevue/card';

export default {
    name: "Run",
    components: {AuthenticatedLayout, QuestionTest, Card},
    props: ['questionRun'],
    data: function () {
        return {
            currentIndex: 0,
        }
    },
    async created() {
        this.currentIndex = this.resolveNextNotAnsweredQuestionIndex()
    },
    computed: {
        currentSelectedAnswer() {
            return this.questionRun.questions[this.currentIndex].attempt?.responses[0]?.answer ?? null
        },
        committedToAnswer() {
            return this.currentSelectedAnswer !== null
        },
        xCurrentQuestion() {
            return this.questionRun.questions[this.currentIndex].question
        },
        xCurrentRunQuestion() {
            return this.questionRun.questions[this.currentIndex]
        },
        hasNotAnsweredQuestions() {
            const nextIndex = this.resolveNextNotAnsweredQuestionIndex()
            if (nextIndex === -1) {
                return false;
            }
            return true;
        }
    },
    methods: {
        changeQuestion(index) {
            this.currentIndex = index;
        },
        async submitAttempt(data) {
            const runQuestion = await QuestionAttemptService.createRunQuestionAttempt(
                {
                    answer_ids: [data.answer.id],
                    question_run_question_id: this.xCurrentRunQuestion.id
                }
            )

            this.questionRun.questions[this.currentIndex] = runQuestion
        },
        resolveNextNotAnsweredQuestionIndex() {
            return this.questionRun.questions.findIndex(item => item.attempt === null)
        },
        badgedClasses(questionRunQuestion) {
            return {
                'badge badge-primary': !!questionRunQuestion.attempt,
                'badge badge-secondary': !questionRunQuestion.attempt,
                'badge badge-accent': questionRunQuestion.question.id === this.xCurrentQuestion?.id
            }
        },
        submitNextQuestion() {
            const limit = this.questionRun.questions.length - 1;
            if (this.currentIndex === limit) {
                this.currentIndex = this.resolveNextNotAnsweredQuestionIndex();
            } else {
                this.currentIndex = this.currentIndex + 1;
            }
        },
        navigateBack() {
            if (this.currentIndex > 0) {
                this.currentIndex = this.currentIndex - 1;
            }
        },
        navigateNext() {
            if (this.questionRun.questions.length - 1 > this.currentIndex) {
                this.currentIndex = this.currentIndex + 1;
            }
        },
        viewResults() {
            window.location = '/page/run/result/' + this.questionRun.id
        }
    }
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="h-5"></div>
        <div class="grid gap-4 grid-cols-4">
            <div class="col-span-3">
                <QuestionTest v-if="xCurrentQuestion"
                              :init-question="xCurrentQuestion"
                              :key="xCurrentQuestion?.id || 'default'"
                              :init-committed-to-answer="committedToAnswer"
                              :init-selected-answer="currentSelectedAnswer"
                              @commitSelection="submitAttempt"
                              @nextQuestion="submitNextQuestion"/>
            </div>
            <Card class="h-full">
                <template #content>
                    <div class="grid gap-2 grid-cols-7">
                        <div class="cursor-pointer"
                             :class="badgedClasses(questionRunQuestion)"
                             v-for="(questionRunQuestion, index) in questionRun.questions"
                             @click="changeQuestion(index)"
                        >
                            {{ index + 1 }}
                        </div>
                    </div>
                    <div v-if="!hasNotAnsweredQuestions">
                        <div class="h-4"></div>
                        <div class="text-center">
                            <button class="btn btn-accent btn-sm px-16" @click="viewResults">
                                View Results
                            </button>
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
    </AuthenticatedLayout>

</template>

<style scoped>

</style>
