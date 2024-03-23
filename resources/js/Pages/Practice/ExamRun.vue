<script>
import QuestionResult from "@/Components/Questions/QuestionResult.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Card from 'primevue/card';
import Toast from 'primevue/toast';
import ConfirmDialog from 'primevue/confirmdialog';
import QuestionExam from "@/Components/Questions/QuestionExam.vue";
import QuestionRunService from "@/Services/question.run.service.js";
import ExamCountdown from "@/Pages/Practice/ExamCountdown.vue";
import moment from 'moment';
import QuestionAttemptService from "@/Services/question.attempt.service.js";

export default {
    name: "ExamRun",
    components: {ExamCountdown, QuestionExam, AuthenticatedLayout, QuestionResult, Card, Toast, ConfirmDialog},
    props: ['examRun'],
    data: function () {
        return {
            flaggedQuestionIndex: [],
            currentIndex: 0,
            examEndTime: null
        }
    },
    async mounted() {
        const runExam = await QuestionRunService.readQuestionRunExam(this.examRun.id)
        this.examEndTime = moment.utc(runExam.started_at).add(1, 'hours').add(30, 'minutes')
    },
    computed: {
        currentRunQuestion() {
            return this.examRun.run_questions[this.currentIndex];
        },
        currentSelectedAnswer() {
            return this.examRun.run_questions[this.currentIndex].attempt?.responses[0]?.answer ?? null;
        },
        isCurrentIndexQuestionAttempted() {
            return !!this.examRun.run_questions[this.currentIndex].attempt;
        },
        isCurrentIndexQuestionFlagged() {
            return !!this.examRun.run_questions[this.currentIndex].flag;
        },
    },
    methods: {
        changeQuestion(index) {
            this.currentIndex = index;
        },
        changeAnswer() {
            this.examRun.run_questions[this.currentIndex].attempt = null;
        },
        classesBadge(index) {
            return {
                'badge-accent': this.currentIndex === index,
                'badge-primary': this.isIndexQuestionAttempted(index),
                'border-accent-blue bg-accent-blue text-white': this.isIndexQuestionFlagged(index),
                'badge-secondary': !this.isIndexQuestionAttempted(index) && !this.isIndexQuestionFlagged(index)
            }
        },
        async commitSelection(data) {
            this.flaggedQuestionIndex[this.currentIndex] = 0;

            const runQuestion = await QuestionAttemptService.createRunQuestionExamAttempt(
                {
                    answer_ids: [data.answer.id],
                    question_run_question_id: this.currentRunQuestion.id
                }
            )

            this.examRun.run_questions[this.currentIndex].attempt = runQuestion.attempt
            this.examRun.run_questions[this.currentIndex].flag = null;

            this.navigateNext()
        },
        async flagQuestion() {
            this.examRun.run_questions[this.currentIndex].flag = await QuestionAttemptService.createQuestionExamFlag(this.currentRunQuestion.id)
            this.examRun.run_questions[this.currentIndex].attempt = null;
        },
        isIndexQuestionFlagged(index) {
            return !!this.examRun.run_questions[index].flag;
        },
        isIndexQuestionAttempted(index) {
            return !!this.examRun.run_questions[index].attempt;
        },
        navigateBack() {
            if (this.currentIndex > 0) {
                this.currentIndex = this.currentIndex - 1;
            }
        },
        navigateNext() {
            if (this.examRun.run_questions.length - 1 > this.currentIndex) {
                this.currentIndex = this.currentIndex + 1;
            }
        },
        async finishExam() {
            await QuestionRunService.commitRunExam(this.examRun.id)

            window.location = '/page/run/result/' + this.examRun.id
        },
        async submitExam() {
            this.$confirm.require({
                message: 'Are you sure you want to want to submit the exam?',
                header: 'Submit Exam',
                icon: 'pi pi-exclamation-triangle',
                rejectClass: 'btn btn-error',
                acceptClass: 'btn btn-primary',
                rejectLabel: 'Cancel',
                acceptLabel: 'Submit',
                accept: () => {
                    this.finishExam()
                },
                reject: () => {
                }
            });
        },
    }
}
</script>

<template>
    <Toast/>
    <ConfirmDialog></ConfirmDialog>
    <AuthenticatedLayout>
        <div class="h-5"></div>
        <div class="flex justify-end text-2xl">
            <ExamCountdown v-if="examEndTime" :end-time-moment="examEndTime" :countdown-finished="finishExam"/>
        </div>
        <div class="container">
            <div class="grid grid-cols-4 gap-4">
                <div class="col-span-3">
                    <QuestionExam :init-question="examRun.run_questions[currentIndex].question"
                                  :key="examRun.run_questions[currentIndex].question.id"
                                  :init-selected-answer="currentSelectedAnswer"
                                  :init-committed="isCurrentIndexQuestionAttempted"
                                  :question-number="currentIndex + 1"
                                  :is-flagged="isCurrentIndexQuestionFlagged"
                                  @commitSelection="commitSelection"
                                  @flagQuestion="flagQuestion"
                                  @changeAnswer="changeAnswer"
                    />
                </div>
                <div>
                    <Card class="h-full">
                        <template #content>
                            <div class="grid grid-cols-7 gap-1">
                                <div v-for="(question, index) in examRun.run_questions"
                                     class="badge cursor-pointer"
                                     :class="classesBadge(index)"
                                     @click="changeQuestion(index)"
                                >
                                    {{ index + 1 }}
                                </div>
                            </div>
                            <div class="h-4"></div>
                            <div class="text-center">
                                <button class="btn btn-accent btn-sm px-16" @click="submitExam">Submit Exam</button>
                            </div>
                            <div class="h-4"></div>
                            <div class="flex justify-center items-center">
                                <div class="link link-primary" @click="navigateBack">Back</div>
                                <div class="w-6"></div>
                                <div class="link link-primary" @click="navigateNext">Next</div>
                            </div>
                        </template>
                    </Card>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>
