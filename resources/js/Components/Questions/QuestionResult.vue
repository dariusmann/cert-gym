<script>
import Card from 'primevue/card';
import RadioButton from 'primevue/radiobutton';

export default {
    name: "QuestionResult",
    props: {
        initQuestion: {
            type: Object
        },
        initSelectedAnswer: {
            type: Object,
            default: null
        },
        questionNumber: {
            type: Number,
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
            committedToAnswer: this.initCommittedToAnswer,
            showLesson: false,
        }
    },
    mounted: function () {
        this.setCorrectAnswer()
    },
    methods: {
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
                'bg-green-200': answer.is_correct,
                'bg-red-200': !answer.is_correct
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
            <template #content>
                <div class="text-lg">
                    <span class="text-p-primary text-2xl text-bold">{{ questionNumber + '. '}}</span>{{ question.text }}
                </div>
                <div class="mt-4">
                    <div v-for="answer in question.answers"
                         :key="answer.id"
                         class="flex items-center rounded-md px-2 mt-2 first:mt-0 bg-gray-100"
                         :class="classesAnswers(answer)">
                        <input type="radio" v-model="selectedAnswer"
                               :id="'radio-answer-' + answer.id"
                               :value="answer"
                               name="radio-question-answer"
                               class="radio radio-primary"
                               :disabled="true"/>
                        <label :for="'radio-answer-' + answer.id" class="label">
                            {{ answer.text }}
                        </label>
                    </div>
                </div>
                <div>
                    <div class="h-5"></div>
                    <hr>
                    <div class="h-5"></div>
                    <div class="text-lg text-bold">Explanation</div>
                    <div v-if="selectedAnswer && !hasUserAnsweredCorrectly()">
                        {{ selectedAnswer.long_explanation }}
                    </div>
                    <div v-else>
                        {{ correctAnswer?.long_explanation }}
                    </div>
                    <div class="h-5"></div>
                    <hr>
                    <div class="h-5"></div>
                    <div class="flex items-center">
                        <div class="text-lg text-bold">Lesson</div>
                        <button class="btn btn-active btn-link ml-2" @click="showLesson = !showLesson">
                            {{ showLesson ? 'Hide' : 'Show more' }}
                        </button>
                    </div>
                    <div v-if="showLesson">
                        {{ question.lesson?.text }}
                    </div>
                </div>
            </template>
        </Card>
    </div>

</template>

<style scoped>

</style>
