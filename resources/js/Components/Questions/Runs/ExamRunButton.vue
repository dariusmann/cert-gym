<script>
import QuestionRunService from "@/Services/question.run.service.js";

export default {
    name: "ExamRunButton",
    methods: {
        async submit() {
            const examQuestionRun = await QuestionRunService.createExamRun();
            window.location = '/page/run/' + examQuestionRun.id + '/exam/practice'
        }
    }
}
</script>

<template>
    <button @click="submit" class="btn btn-primary">
        Exam Run
    </button>
</template>

<style scoped>

</style>
