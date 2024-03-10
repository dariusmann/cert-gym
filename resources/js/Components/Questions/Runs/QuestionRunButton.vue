<script>
import QuestionRunService from "@/Services/question.run.service.js";

export default {
    name: "QuestionRunButton",
    methods: {
        async submit() {
            const questionRun = await QuestionRunService.readQuestionRun();
            console.log('questionRun History: ',questionRun)
        }
    }
}
</script>

<template>
    <button @click="submit" class="btn btn-primary">
        QuestionRun History
    </button>
</template>

<style scoped>

</style>
