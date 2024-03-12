<script>
import QuestionRunService from "@/Services/question.run.service.js";

export default {
    name: "ExamRunButton",
    methods: {
        async submit() {
            const examQuestionRun = await QuestionRunService.createExamRun();
            console.log('ExamQuestionRun: ',examQuestionRun)
        }
    }
}
</script>

<template>
    <button @click="submit" class="btn btn-primary">
        Examsimulation Run
    </button>
</template>

<style scoped>

</style>
