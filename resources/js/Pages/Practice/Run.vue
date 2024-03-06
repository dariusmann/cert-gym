<script>
import QuestionService from "@/Services/question.service.js";
import QuestionTest from "@/Components/Questions/QuestionTest.vue";
import QuestionAttemptService from "@/Services/question.attempt.service.js";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

export default {
    name: "Run",
    components: {AuthenticatedLayout, QuestionTest},
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
    mounted() {
        this.loadQuestion(this.questionRun.questions[0], 0)
    },
    computed: {
        selectedAnswer(){
            if(this.questionAnswer === null) {
                return null;
            }

            if(Array.isArray(this.questionAnswer)) {
                return this.questionAnswer[0];
            }

            throw new Error('Question answer has the wrong data type')
        },
        committedToAnswer(){
            if(Array.isArray(this.questionAnswer)) {
                return this.questionAnswer.length > 0;
            }

            return false;
        }
    },
    methods: {
        async loadQuestion(questionRunQuestion, index) {
            this.allLoaded = false;
            this.currentQuestion = null;
            this.questionAnswer = null;

            this.currentRunQuestion = questionRunQuestion;
            this.currentIndex = index
            this.currentQuestion = await QuestionService.readQuestion(questionRunQuestion.question_id);

            if(questionRunQuestion.attempt_id) {
                this.questionAnswer = await QuestionAttemptService.readQuestionAttempt(questionRunQuestion.attempt_id)
            }

            this.allLoaded = true;
        },
        async submitAttempt(data) {
            const runQuestion = await QuestionAttemptService.createRunQuestionAttempt(
                {
                    answer_ids: [data.answer.id],
                    question_run_question_id: this.currentRunQuestion.id
                }
            )

            this.questionRun.questions[this.currentIndex] = runQuestion
        },
        badgedClasses(questionRunQuestion) {
            return {
                'badge badge-primary': !!questionRunQuestion.attempt_id,
                'badge badge-secondary': !questionRunQuestion.attempt_id
            }
        }
    }
}
</script>

<template>

    <AuthenticatedLayout>
        <QuestionTest v-if="currentQuestion && allLoaded"
                      :init-question="currentQuestion"
                      :init-committed-to-answer="committedToAnswer"
                      :init-selected-answer="selectedAnswer"
                      @commitSelection="submitAttempt"/>

        <div :class="badgedClasses(questionRunQuestion)"
             v-for="(questionRunQuestion, index) in questionRun.questions"
             @click="() => loadQuestion(questionRunQuestion, index)"
        >
            {{ questionRunQuestion.question_id }}
        </div>
    </AuthenticatedLayout>

</template>

<style scoped>

</style>
