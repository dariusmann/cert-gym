<script>
import QuestionService from "@/Services/question.service.js";
import QuestionTest from "@/Components/Questions/QuestionTest.vue";
import QuestionAttemptService from "@/Services/question.attempt.service.js";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

export default {
    name: "Run",
    components: {AuthenticatedLayout, QuestionTest},
    props: ['questionRun'],
    data: function () {
        return {
            currentQuestion: null,
            currentRunQuestion: null,
            currentIndex: null
        }
    },
    mounted() {
        this.loadQuestion(this.questionRun.questions[0], 0)
    },
    methods: {
        async loadQuestion(questionRunQuestion, index) {
            this.currentQuestion = null;
            this.currentRunQuestion = questionRunQuestion;
            this.currentIndex = index
            this.currentQuestion = await QuestionService.readQuestion(questionRunQuestion.question_id);
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
        badgedClasses(questionRunQuestion) {
            return {
                'badge badge-primary': !!questionRunQuestion.attempt_id,
                'badge badge-secondary': !questionRunQuestion.attempt_id
            }
        }
    }
}
</script>

<template>

    <AuthenticatedLayout>
        <QuestionTest v-if="currentQuestion" :init-question="currentQuestion" @commitSelection="submitAttempt"/>

        <div :class="badgedClasses(questionRunQuestion)"
             v-for="(questionRunQuestion, index) in questionRun.questions"
             @click="() => loadQuestion(questionRunQuestion, index)"
        >
            {{ index + 1 }}
        </div>
    </AuthenticatedLayout>

</template>

<style scoped>

</style>
