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
import Dialog from "primevue/dialog";

export default {
    name: "ExamRun",
    components: {ExamCountdown, QuestionExam, AuthenticatedLayout, QuestionResult, Card, Toast, ConfirmDialog, Dialog},
    props: ['examRun'],
    data: function () {
        return {
            flaggedQuestionIndex: [],
            currentIndex: 0,
            examEndTime: null,
            modalSubmitExamShow: false,
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
        flaggedCount() {
            return this.examRun.run_questions.filter(question => question.flag).length;
        },
        unansweredCount() {
            return this.examRun.run_questions.filter(question => !question.attempt).length;
        }
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
            this.modalSubmitExamShow = true;
        },
    }
}
</script>

<template>
    <Toast/>
    <AuthenticatedLayout>
        <div class="h-5"></div>
        <div class="flex justify-end text-2xl">
            <ExamCountdown v-if="examEndTime" :end-time-moment="examEndTime" :countdown-finished="finishExam"/>
        </div>
        <div class="container">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
                <div class="col-span-1 md:col-span-2 lg:col-span-3">
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
                    <Dialog v-model:visible="modalSubmitExamShow" modal :style="{ width: '40rem' }">
                        <template #header>
                            <div class="text-4xl"><b>Ready to submit exam?</b></div>
                        </template>
                        <hr class="mb-5">
                        <p>Are you ready to submit your exam?</p>
                        <p class="my-5">You have <b>{{ flaggedCount }}</b> flagged questions.</p>
                        <p>You have <b>{{ unansweredCount }}</b> unanswered questions.</p>
                        <template #footer>
                            <div class="p-d-flex">
                                <Button @click="modalSubmitExamShow = false"
                                        class="btn btn-secondary ml-2">Continue exam</Button>
                            </div>
                                <Button @click="finishExam"
                                        class="btn btn-primary ml-2">Submit exam</Button>
                        </template>
                    </Dialog>
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
