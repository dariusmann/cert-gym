<script>
import Card from 'primevue/card';

export default {
    name: "ResultOverview",
    props: ['run'],
    components: {Card},
    computed: {
        correctAnswersCount() {
            return this.run.run_questions.filter(question => question.attempt?.answered_correctly === true).length;
        },
        incorrectAnswersCount() {
            return this.run.run_questions.filter(question => question.attempt?.answered_correctly === false).length;
        },
        notAnsweredCount() {
            return this.run.run_questions.filter(question => question.attempt === null).length;
        },
        examPassed() {
            const percentageCorrect = (this.correctAnswersCount / this.run.run_questions.length) * 100;
            return percentageCorrect >= 70;
        },
        accuracyRate() {
            return Math.round((this.correctAnswersCount / this.run.run_questions.length) * 100);
        }
    }
}
</script>

<template>
    <div class="stats stats-vertical lg:stats-horizontal shadow">

        <div class="stat text-center">
            <div class="stat-title">Correct Answers</div>
            <div class="stat-value text-green-400">{{ correctAnswersCount }}</div>
        </div>

        <div class="stat text-center">
            <div class="stat-title">Incorrect Answers</div>
            <div class="stat-value text-red-400">{{ incorrectAnswersCount }}</div>
        </div>

        <div class="stat text-center">
            <div class="stat-title">Not Answered</div>
            <div class="stat-value">{{ notAnsweredCount }}</div>
        </div>

        <div class="stat text-center">
            <div class="stat-title">Accuracy Rate</div>
            <div class="stat-value">{{ accuracyRate }}%</div>
        </div>

        <div class="stat text-center" v-if="run.type === 'exam'">
            <div class="stat-title">Result</div>
            <div class="stat-value" :class="examPassed ? 'text-green-600' : 'text-red-600'">
                {{ examPassed ? 'Passed' : 'Failed' }}
            </div>
            <div class="stat-desc" v-if="!examPassed">
                you need at least 70% to pass
            </div>
        </div>

    </div>
</template>

<style scoped>

</style>
