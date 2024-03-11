<script>
import QuestionService from "@/Services/question.service.js";
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
            currentQuestion: null,
            currentRunQuestion: null,
            questionAnswer: null,
            currentIndex: null,
            allLoaded: false
        }
    },
    async created() {
        const nextUnansweredQuestionIndex = this.resolveNextNotAnsweredQuestionIndex()
        await this.loadQuestion(this.questionRun.questions[nextUnansweredQuestionIndex], nextUnansweredQuestionIndex)
    },
    computed: {
        selectedAnswer() {
            if (this.questionAnswer === null) {
                return null;
            }

            if (Array.isArray(this.questionAnswer)) {
                return this.questionAnswer[0];
            }

            throw new Error('Question answer has the wrong data type')
        },
        committedToAnswer() {
            if (Array.isArray(this.questionAnswer)) {
                return this.questionAnswer.length > 0;
            }

            return false;
        }
    },
    methods: {
        async loadQuestion(questionRunQuestion, index) {
            this.allLoaded = false;
            this.currentQuestion = null;
            this.questionAnswer = null;

            this.currentRunQuestion = questionRunQuestion;
            this.currentIndex = index
            this.currentQuestion = await QuestionService.readQuestion(questionRunQuestion.question_id);

            if (questionRunQuestion.attempt_id) {
                this.questionAnswer = await QuestionAttemptService.readQuestionAttempt(questionRunQuestion.attempt_id)
            }

            this.allLoaded = true;
        },
        async submitAttempt(data) {
            const runQuestion = await QuestionAttemptService.createRunQuestionAttempt(
                {
                    answer_ids: [data.answer.id],
                    question_run_question_id: this.currentRunQuestion.id
                }
            )

            this.questionRun.questions[this.currentIndex] = runQuestion
        },
        resolveNextNotAnsweredQuestionIndex() {
            return this.questionRun.questions.findIndex(item => item.attempt_id === null)
        },
        badgedClasses(questionRunQuestion) {
            return {
                'badge badge-primary': !!questionRunQuestion.attempt_id,
                'badge badge-secondary': !questionRunQuestion.attempt_id,
                'badge badge-accent': questionRunQuestion.id == this.currentRunQuestion?.id
            }
        },
        submitNextQuestion() {
            const limit = this.questionRun.questions.length - 1;
            if (this.currentIndex === limit) {
                const nextUnansweredQuestionIndex = this.resolveNextNotAnsweredQuestionIndex()
                this.loadQuestion(this.questionRun.questions[nextUnansweredQuestionIndex], nextUnansweredQuestionIndex)
            } else {
                this.currentIndex = this.currentIndex + 1;
                this.loadQuestion(this.questionRun.questions[this.currentIndex], this.currentIndex)
            }
        }
    }
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="h-5"></div>
        <div class="grid gap-4 grid-cols-4">
            <Card>
                <template #content>
                    <div class="mt-4 flex gap-1 flex-wrap">
                        <div class="cursor-pointer"
                             :class="badgedClasses(questionRunQuestion)"
                             v-for="(questionRunQuestion, index) in questionRun.questions"
                             @click="() => loadQuestion(questionRunQuestion, index)"
                        >
                            {{ index + 1 }}
                        </div>
                    </div>
                </template>
            </Card>
            <div class="col-span-3">
                <QuestionTest v-if="currentQuestion && allLoaded"
                              :init-question="currentQuestion"
                              :init-committed-to-answer="committedToAnswer"
                              :init-selected-answer="selectedAnswer"
                              @commitSelection="submitAttempt"
                              @nextQuestion="submitNextQuestion"/>
            </div>
        </div>
    </AuthenticatedLayout>

</template>

<style scoped>

</style>
