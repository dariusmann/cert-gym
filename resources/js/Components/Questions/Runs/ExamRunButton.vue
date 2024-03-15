<script>
import QuestionRunService from "@/Services/question.run.service.js";
import Card from 'primevue/card';

export default {
    name: "ExamRunButton",
    components: {Card},
    methods: {
        async submit() {
            const examQuestionRun = await QuestionRunService.createExamRun();
            window.location = '/page/run/' + examQuestionRun.id + '/exam/practice'
        }
    }
}
</script>

<template>
    <Card>
        <template #content>
            <div class="text-center">
                <div>
                    <p>Test you skills on our exam simulation</p>
                </div>
                <button @click="submit" class="mt-4 btn btn-primary">
                    Exam Run
                </button>
            </div>
        </template>
    </Card>

</template>

<style scoped>

</style>
