<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Card from 'primevue/card';
import QuestionResult from "@/Components/Questions/QuestionResult.vue";

export default {
    name: "Result",
    props: ['runQuestions'],
    components: {QuestionResult, AuthenticatedLayout, Card},
    data: function () {
        return {
            currentRunQuestion: null,
        }
    },
    created() {
        this.currentRunQuestion = this.runQuestions[0];
    },
    methods: {
        changeQuestion(index) {
            this.currentRunQuestion = null;
            this.currentRunQuestion = this.runQuestions[index]
        },
        classesBadge(attempt) {
            return {
                'bg-green-200': attempt !== null && attempt?.answered_correctly,
                'bg-red-200': attempt !== null && !attempt?.answered_correctly,
                'badge-secondary' : attempt === null
            }
        }
    },
    computed: {
        selectedAnswer() {
            if (this.currentRunQuestion === null) {
                return null;
            }

            if (Array.isArray(this.currentRunQuestion.answers)) {
                return this.currentRunQuestion.answers[0];
            }

            throw new Error('Question answer has the wrong data type')
        },
    }
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="h-5"></div>

        <div class="container">
            <div class="grid grid-cols-4 gap-4">
                <div>
                    <Card class="h-full">
                        <template #content>
                            <div>
                                <div v-for="(runQuestion, index) in runQuestions"
                                     class="badge cursor-pointer"
                                     :class="classesBadge(runQuestion.attempt)"
                                     @click="changeQuestion(index)"
                                >
                                    {{ index + 1 }}
                                </div>
                            </div>
                        </template>
                    </Card>
                </div>
                <div class="col-span-3">
                    <QuestionResult v-if="currentRunQuestion"
                                    :key="currentRunQuestion?.id || 'default'"
                                    :init-question="currentRunQuestion.question"
                                    :init-selected-answer="selectedAnswer"/>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>
