<script>
import QuestionRunService from "@/Services/question.run.service.js";
import Card from 'primevue/card';
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';

export default {
    name: "ExamRunButton",
    components: {Card, Dialog, Button},
    props: ['runningExamRun'],
    data() {
        return {
            examQuestionRun: null,
            modalStartExamShow: false,
            modalContinueExamShow: false
        }
    },
    methods: {
        async showStartExamModal() {
            this.modalStartExamShow = true;
        },
        async showContinueExamModal() {
            this.modalContinueExamShow = true;
        },
        continueExam() {
            window.location = '/page/run/' + this.runningExamRun.id + '/exam/practice'
        },
        async startNewExam() {
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
                <Button v-if="!runningExamRun" label="Start Exam" @click="showStartExamModal" class="mt-4 btn btn-primary"/>
                <Button v-if="runningExamRun" label="Continue Exam" @click="showContinueExamModal" class="mt-4 btn btn-primary"/>
            </div>
        </template>
    </Card>

    <Dialog v-model:visible="modalContinueExamShow" modal :style="{ width: '25rem' }">
        <template #header>
            <div class="text-2xl">You're back?</div>
        </template>
        <p>You still have an exam running. Continue it now!</p>
        <template #footer>
            <div class="p-d-flex">
                <Button label="Continue Exam"
                        @click="continueExam"
                        class="btn btn-primary ml-2"/>
            </div>
        </template>
    </Dialog>

    <Dialog v-model:visible="modalStartExamShow" modal :style="{ width: '25rem' }">
        <template #header>
            <div class="text-2xl">Listen up!</div>
        </template>
        <p>This is a <b>85-question exam</b>, and you <br>have <b>1h 30m</b> to complete it. Are you Ready?</p>
        <template #footer>
            <div class="p-d-flex">
                <Button label="Yes, I'm ready!" @click="startNewExam" class="btn btn-secondary"/>
            </div>
        </template>
    </Dialog>
</template>

<style scoped>
</style>
