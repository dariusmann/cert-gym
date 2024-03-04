<script>
import QuestionService from "@/Services/question.service.js";
import QuestionTest from "@/Components/Questions/QuestionTest.vue";

export default {
    name: "Run",
    components: {QuestionTest},
    props: ['questionRun'],
    data: function () {
        return {
            currentQuestion: null
        }
    },
    methods: {
        async loadQuestion(questionId) {
            this.currentQuestion = null;
            const question = await QuestionService.readQuestion(questionId)
            console.log(question)
            this.currentQuestion = question;
        }
    }
}
</script>

<template>

    <QuestionTest v-if="currentQuestion" :init-question="currentQuestion"/>

    <div class="badge badge-primary"
         v-for="(questionRunQuestion, index) in questionRun.questions"
         @click="() => loadQuestion(questionRunQuestion.question_id)"
    >
        {{ index + 1 }}
    </div>

</template>

<style scoped>

</style>
