<script>
import QuestionService from "@/Services/question.service.js";
import QuestionTest from "@/Components/Questions/QuestionTest.vue";
import QuestionAttemptService from "@/Services/question.attempt.service.js";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Card from 'primevue/card';

export default {
    name: "Run",
    components: {AuthenticatedLayout, QuestionTest, Card},
    props: ['questionRun'],
    data: function () {
        return {
            currentQuestion: null,
            currentRunQuestion: null,
            questionAnswer: null,
            currentIndex: null,
            allLoaded: false
        }
    },
    async created() {
        this.currentIndex = this.resolveNextNotAnsweredQuestionIndex()
    },
    computed: {
        selectedAnswer() {
            if (this.questionAnswer === null) {
                return null;
            }

            if (Array.isArray(this.questionAnswer)) {
                return this.questionAnswer[0];
            }

            throw new Error('Question answer has the wrong data type')
        },
        committedToAnswer() {
            if (Array.isArray(this.questionAnswer)) {
                return this.questionAnswer.length > 0;
            }

            return false;
        },
        xCurrentQuestion() {
            return this.questionRun.questions[this.currentIndex].question
        },
        xCurrentRunQuestion(){
            return this.questionRun.questions[this.currentIndex]
        }

    },
    methods: {
        changeQuestion(index) {
            this.currentIndex = index;
        },
        async submitAttempt(data) {
            const runQuestion = await QuestionAttemptService.createRunQuestionAttempt(
                {
                    answer_ids: [data.answer.id],
                    question_run_question_id: this.xCurrentRunQuestion.id
                }
            )

            console.log(runQuestion)

            this.questionRun.questions[this.currentIndex] = runQuestion
        },
        resolveNextNotAnsweredQuestionIndex() {
            return this.questionRun.questions.findIndex(item => item.attempt === null)
        },
        badgedClasses(questionRunQuestion) {
            return {
                'badge badge-primary': !!questionRunQuestion.attempt,
                'badge badge-secondary': !questionRunQuestion.attempt,
                'badge badge-accent': questionRunQuestion.question.id === this.xCurrentQuestion?.id
            }
        },
        submitNextQuestion() {
            const limit = this.questionRun.questions.length - 1;
            if (this.currentIndex === limit) {
                this.currentIndex = this.resolveNextNotAnsweredQuestionIndex();
            } else {
                this.currentIndex = this.currentIndex + 1;
            }
        }
    }
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="h-5"></div>
        <div class="grid gap-4 grid-cols-4">
            <div class="col-span-3">
                <QuestionTest v-if="xCurrentQuestion"
                              :init-question="xCurrentQuestion"
                              :key="xCurrentQuestion?.id || 'default'"
                              :init-committed-to-answer="committedToAnswer"
                              :init-selected-answer="selectedAnswer"
                              @commitSelection="submitAttempt"
                              @nextQuestion="submitNextQuestion"/>
            </div>
            <Card class="h-full">
                <template #content>
                    <div class="grid gap-2 grid-cols-8">
                        <div class="cursor-pointer"
                             :class="badgedClasses(questionRunQuestion)"
                             v-for="(questionRunQuestion, index) in questionRun.questions"
                             @click="changeQuestion(index)"
                        >
                            {{ index + 1 }}
                        </div>
                    </div>
                </template>
            </Card>
        </div>
    </AuthenticatedLayout>

</template>

<style scoped>

</style>
