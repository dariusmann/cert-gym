<script>
import QuestionTest from "@/Components/Questions/QuestionTest.vue";
import QuestionAttemptService from "@/Services/question.attempt.service.js";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Card from 'primevue/card';
import QuestionRunService from "@/Services/question.run.service.js";

export default {
    name: "RandomRun",
    components: {AuthenticatedLayout, QuestionTest, Card},
    props: ['run'],
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
            return this.run.run_questions[this.currentIndex].attempt?.responses[0]?.answer ?? null
        },
        committedToAnswer() {
            return this.currentSelectedAnswer !== null
        },
        xCurrentQuestion() {
            return this.run.run_questions[this.currentIndex].question
        },
        xCurrentRunQuestion() {
            return this.run.run_questions[this.currentIndex]
        },
        hasNotAnsweredQuestions() {
            const nextIndex = this.resolveNextNotAnsweredQuestionIndex()
            return nextIndex !== -1;
        }
    },
    methods: {
        async submitAttempt(data) {
            const runQuestion = await QuestionAttemptService.createRunQuestionAttempt(
                {
                    answer_ids: [data.answer.id],
                    question_run_question_id: this.xCurrentRunQuestion.id
                }
            )

            this.run.run_questions[this.currentIndex] = runQuestion
        },
        resolveNextNotAnsweredQuestionIndex() {
            return this.run.run_questions.findIndex(item => item.attempt === null)
        },
        async submitNextQuestion() {
            if (!this.hasNotAnsweredQuestions) {
                const newRandomRun = await QuestionRunService.readRandomRun();
                window.location = '/page/run/' + newRandomRun.id + '/random/practice';
            }

            this.currentIndex = this.currentIndex + 1;
        },
    }
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="h-5"></div>
        <div class="flex justify-center">
            <div class="sm:w-full md:w-1/2">
                <QuestionTest v-if="xCurrentQuestion"
                              :init-question="xCurrentQuestion"
                              :key="xCurrentQuestion?.id || 'default'"
                              :init-committed-to-answer="committedToAnswer"
                              :init-selected-answer="currentSelectedAnswer"
                              @commitSelection="submitAttempt"
                              @nextQuestion="submitNextQuestion"/>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<style scoped>

</style>
