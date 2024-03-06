<script>
import Card from 'primevue/card';
import RadioButton from 'primevue/radiobutton';

export default {
    name: "QuestionTest",
    props: {
        initQuestion: {
            type: Object
        },
        initCommittedToAnswer: {
            type: Boolean,
            default: false
        },
        initSelectedAnswer: {
            type: Object,
            default: null
        }
    },
    components: {
        Card,
        RadioButton
    },
    data: function () {
        return {
            question: this.initQuestion,
            letters: ['A', 'B', 'C', 'D', 'E', 'F'],
            selectedAnswer: this.initSelectedAnswer,
            correctAnswer: null,
            committedToAnswer: this.initCommittedToAnswer
        }
    },
    mounted: function () {
        this.setCorrectAnswer()
    },
    computed: {
        classes: function () {
            return {
                answerButton: {
                    'btn-disabled': !this.selectedAnswer
                }
            }
        },
        disabledButton() {
            return this.committedToAnswer && this.question !== null;
        }
    },
    methods: {
        submit() {
            this.committedToAnswer = true;
            this.$emit('commitSelection', {
                'answer': this.selectedAnswer
            })
        },
        setCorrectAnswer() {
            let correctAnswer = null;

            this.question.answers.forEach(function (answer) {
                if (answer.is_correct) {
                    correctAnswer = answer
                }
            })

            this.correctAnswer = correctAnswer
        },
        hasUserAnsweredCorrectly() {
            return this.correctAnswer?.id === this.selectedAnswer.id
        },
        classesAnswers(answer) {
            return {
                'bg-green-200': this.committedToAnswer && answer.is_correct,
                'bg-red-200': this.committedToAnswer && !answer.is_correct
                    && this.selectedAnswer?.id === answer.id
                    && !this.hasUserAnsweredCorrectly()
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
                         class="flex items-center rounded-md px-2 mt-2 first:mt-0 bg-gray-100"
                         :class="classesAnswers(answer)">
                        <input type="radio" v-model="selectedAnswer"
                               :id="'radio-answer-' + answer.id"
                               :value="answer"
                               name="radio-question-answer"
                               class="radio radio-primary" :disabled="committedToAnswer"/>
                        <label :for="'radio-answer-' + answer.id" class="label cursor-pointer">
                            {{ answer.text }}
                        </label>
                    </div>
                </div>
                <div class="mt-4">
                    <button class="btn btn-secondary" @click="submit" :disabled="disabledButton">
                        Answer
                    </button>
                </div>
                <div v-if="committedToAnswer">
                    <div class="h-5"></div>
                    <hr>
                    <div class="h-5"></div>
                    <div class="text-lg text-bold">Explanation</div>
                    <div>
                        {{ selectedAnswer?.explanation }}
                    </div>
                </div>
            </template>
        </Card>
    </div>

</template>

<style scoped>

</style>
