<script>
import QuestionService from "@/Services/question.service.js";
import Card from 'primevue/card';
import RadioButton from 'primevue/radiobutton';

export default {
    name: "QuestionTest",
    components: {
        Card,
        RadioButton
    },
    data: function () {
        return {
            question: null,
            letters: ['A', 'B', 'C', 'D', 'E', 'F'],
            selectedAnswerId: '',
            correctAnswer: null,
            committedToAnswer: false
        }
    },
    mounted: async function () {
        this.question = await QuestionService.readQuestion()
        this.setCorrectAnswer()
    },
    computed: {
        classes: function () {
            return {
                answerButton: {
                    'btn-disabled': !this.selectedAnswerId
                }
            }
        }
    },
    methods: {
        submit() {
            this.committedToAnswer = true;
            this.checkAnswer()
        },
        checkAnswer() {

        },
        setCorrectAnswer() {
            let correctAnswer = null;
            this.question.answers.forEach(function (answer) {
                if (answer.isCorrect) {
                    correctAnswer = answer
                }
            })

            this.correctAnswer = correctAnswer
        },
        hasUserAnsweredCorrectly() {
            return this.correctAnswer.id === this.selectedAnswerId
        },
        classesAnswers(answer) {
            return {
                'bg-green-100': this.committedToAnswer && answer.isCorrect,
                'bg-red-100': this.committedToAnswer && !answer.isCorrect && this.selectedAnswerId === answer.id && !this.hasUserAnsweredCorrectly()
            }
        }
    }
}
</script>

<template>

    <div v-if="question">
        <Card>
            <template #title>
                {{ question.text }}
            </template>
            <template #content>
                <div>
                    <div v-for="answer in question.answers"
                         :key="answer.id"
                         class="flex items-center"
                         :class="classesAnswers(answer)">
                        <input type="radio" v-model="selectedAnswerId"
                               :id="'radio-answer-' + answer.id"
                               :value="answer.id"
                               name="radio-question-answer"
                               class="radio radio-primary" :disabled="committedToAnswer"/>
                        <label :for="'radio-answer-' + answer.id" class="label cursor-pointer">
                            {{ answer.text }}
                        </label>
                    </div>
                </div>
                <div>
                    <button class="btn btn-secondary" @click="submit" :disabled="committedToAnswer && !question">
                        Answer
                    </button>
                </div>
            </template>
        </Card>
    </div>

</template>

<style scoped>

</style>
