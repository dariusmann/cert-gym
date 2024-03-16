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
    <Card class="h-full">
        <template #content>
            <div class="text-center flex flex-col justify-between h-full">
                <div>
                    <i class="text-4xl fa-solid fa-vial"></i>
                    <div class="text-2xl mt-2">Exam Run</div>
                    <p class="mt-2">Test you skills on our exam simulation: <br> 75 questions in 1h 30m.</p>
                </div>
                <button @click="submit" class="mt-4 btn btn-primary">
                    Start Exam
                </button>
            </div>
        </template>
    </Card>

</template>

<style scoped>
.p-card-content {
    height: 100%;
}
</style>
