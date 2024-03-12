<script>
import QuestionResult from "@/Components/Questions/QuestionResult.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Card from 'primevue/card';
import QuestionExam from "@/Components/Questions/QuestionExam.vue";
import QuestionRunService from "@/Services/question.run.service.js";
import ExamCountdown from "@/Pages/Practice/ExamCountdown.vue";
import moment from 'moment';

export default {
    name: "ExamRun",
    components: {ExamCountdown, QuestionExam, AuthenticatedLayout, QuestionResult, Card},
    props: ['examRun'],
    data: function () {
        return {
            attempts: [],
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
        currentQuestion() {
            return this.examRun.questions[this.currentIndex];
        },
        currentSelectedAnswer() {
            return this.attempts[this.currentIndex];
        },
        isCurrentQuestionFlagged() {
            return this.flaggedQuestionIndex[this.currentIndex] === 1;
        },
        isCurrentIndexQuestionAttempted() {
            return !!this.attempts[this.currentIndex];
        },
    },
    methods: {
        changeQuestion(index) {
            this.currentIndex = index;
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
            this.attempts[this.currentIndex] = data.answer
            this.currentIndex = this.currentIndex + 1;
        },
        flagQuestion() {
            this.flaggedQuestionIndex[this.currentIndex] = 1;
            this.currentIndex = this.currentIndex + 1;
        },
        isIndexQuestionFlagged(index) {
            return this.flaggedQuestionIndex[index] === 1;
        },
        isIndexQuestionAttempted(index) {
            return !!this.attempts[index];
        },
        navigateBack() {
            if (this.currentIndex > 0) {
                this.currentIndex = this.currentIndex - 1;
            }
        },
        navigateNext() {
            if (this.examRun.questions.length - 1 > this.currentIndex) {
                this.currentIndex = this.currentIndex + 1;
            }
        },
        finishExam() {

        }
    }
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="h-5"></div>
        <div class="flex justify-end text-2xl">
            <ExamCountdown v-if="examEndTime" :end-time-moment="examEndTime" :countdown-finished="finishExam"/>
        </div>
        <div class="container">
            <div class="grid grid-cols-4 gap-4">
                <div class="col-span-3">
                    <QuestionExam :init-question="currentQuestion"
                                  :key="currentQuestion?.id || 'default'"
                                  :init-selected-answer="currentSelectedAnswer"
                                  :init-committed="isCurrentIndexQuestionAttempted"
                                  @commitSelection="commitSelection"
                                  @flagQuestion="flagQuestion"/>
                </div>
                <div>
                    <Card class="h-full">
                        <template #content>
                            <div class="grid grid-cols-8 gap-1">
                                <div v-for="(question, index) in examRun.questions"
                                     class="badge cursor-pointer"
                                     :class="classesBadge(index)"
                                     @click="changeQuestion(index)"
                                >
                                    {{ index + 1 }}
                                </div>
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
