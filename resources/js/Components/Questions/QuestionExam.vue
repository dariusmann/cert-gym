<script>
import Card from 'primevue/card';
import RadioButton from 'primevue/radiobutton';

export default {
    name: "QuestionExam",
    props: {
        initQuestion: {
            type: Object
        },
        initSelectedAnswer: {
            type: Object,
            default: null
        },
        initCommitted: {
            type: Boolean,
            default: false
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
        }
    },
    computed: {
        classes: function () {
            return {
                answerButton: {
                    'btn-disabled': !this.selectedAnswer
                }
            }
        }
    },
    methods: {
        submit() {
            this.$emit('commitSelection', {
                'answer': this.selectedAnswer
            })
        },
        changeAnswer(){
            this.$emit('changeAnswer');
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
                         class="flex items-center rounded-md px-2 mt-2 first:mt-0 bg-gray-100">
                        <input type="radio" v-model="selectedAnswer"
                               :id="'radio-answer-' + answer.id"
                               :value="answer"
                               name="radio-question-answer"
                               class="radio radio-primary"
                               :disabled="initCommitted"
                        />
                        <label :for="'radio-answer-' + answer.id" class="label cursor-pointer">
                            {{ answer.text }}
                        </label>
                    </div>
                </div>
                <div class="mt-4">
                    <button v-if="!initCommitted" class="btn btn-secondary btn-sm" @click="submit" :disabled="!selectedAnswer">
                        Answer
                    </button>
                    <button v-if="initCommitted" class="btn btn-secondary btn-sm" @click="changeAnswer">
                        Change Answer
                    </button>
                    <button  class="btn btn-primary ml-2 btn-sm" @click="$emit('flagQuestion')" :disabled="!!initCommitted">
                        Flag
                    </button>
                </div>
            </template>
        </Card>
    </div>

</template>

<style scoped>

</style>
