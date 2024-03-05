<script>
import QuestionService from "@/Services/question.service.js";
import QuestionTest from "@/Components/Questions/QuestionTest.vue";
import QuestionAttemptService from "@/Services/question.attempt.service.js";

export default {
    name: "Run",
    components: {QuestionTest},
    props: ['questionRun'],
    data: function () {
        return {
            currentQuestion: null,
            currentRunQuestion: null
        }
    },
    methods: {
        async loadQuestion(questionRunQuestion) {
            this.currentQuestion = null;
            this.currentRunQuestion = questionRunQuestion;
            this.currentQuestion = await QuestionService.readQuestion(questionRunQuestion.question_id);
        },
        async submitAttempt(data) {
            await QuestionAttemptService.createRunQuestionAttempt(
                {
                    answer_ids: [data.answer.id],
                    question_run_question_id: this.currentRunQuestion.id
                }
            )
        }
    }
}
</script>

<template>

    <QuestionTest v-if="currentQuestion" :init-question="currentQuestion" @commitSelection="submitAttempt"/>

    <div class="badge badge-primary"
         v-for="(questionRunQuestion, index) in questionRun.questions"
         @click="() => loadQuestion(questionRunQuestion)"
    >
        {{ index + 1 }}
    </div>

</template>

<style scoped>

</style>
