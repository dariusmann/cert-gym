<script>
import QuestionRunService from "@/Services/question.run.service.js";

export default {
    name: "RandomRunButton",
    methods: {
        async submit() {
            const randomRun = await QuestionRunService.readRandomRun();

            window.location = '/page/practice/run/' + randomRun.id
        }
    }
}
</script>

<template>
    <button @click="submit" class="btn btn-primary">
        Quick start
    </button>
</template>

<style scoped>

</style>
