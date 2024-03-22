<script>
import QuestionRunService from "@/Services/question.run.service.js";
import Card from 'primevue/card';
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';

export default {
    name: "ExamRunButton",
    components: {Card, Dialog, Button},
    data() {
        return {
            showDialog: false,
            examQuestionRun: null,
            visible: false,
            noExamToContinue: false
        }
    },
    methods: {
        async submit() {
            const examStatus = await QuestionRunService.getExamStatus();
            if (examStatus && Object.keys(examStatus).length) {
                this.examQuestionRun = examStatus;
                this.showDialog = true;
                this.visible = true;
            } else {
                this.noExamToContinue = true;
                this.showDialog = true;
                this.visible = true;
            }
        },
        continueExam() {
            window.location = '/page/run/' + this.examQuestionRun.id + '/exam/practice'
        },
        async startNewExam() {
            if (this.examQuestionRun) {
                await QuestionRunService.commitRunExam(this.examQuestionRun.id);
            }
            const examQuestionRun = await QuestionRunService.createExamRun();
            window.location = '/page/run/' + examQuestionRun.id + '/exam/practice';
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
                    <p class="mt-2">Test your skills on our exam simulation: <br> 85 questions in 1h 30m.</p>
                </div>
                <Button label="Start Exam" @click="submit" class="mt-4 btn btn-primary" />
            </div>
        </template>
    </Card>

    <Dialog v-model:visible="visible" modal :style="{ width: '25rem' }">
        <template #header>
            <h2 v-if="noExamToContinue" >New Exam</h2>
            <h2 v-else>Continue Exam</h2>
        </template>
        <p v-if="noExamToContinue">This is a 75-question exam, and you have 1.5 hours to complete it. Start a new exam to test your skills.</p>
        <p v-else>Would you like to continue with your existing exam or start a new one?</p>
        <template #footer>
            <div class="p-d-flex">
                <Button v-if="!noExamToContinue" :disabled="!examQuestionRun" label="Continue Exam" @click="continueExam" class="btn btn-primary mr-2" />
                <Button label="Start New Exam" @click="startNewExam" class="btn btn-secondary" />
            </div>
        </template>
    </Dialog>
</template>

<style scoped>
</style>
