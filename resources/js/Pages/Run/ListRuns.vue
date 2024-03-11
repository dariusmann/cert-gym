<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Card from 'primevue/card';
import QuestionRunService from "@/Services/question.run.service.js";

export default {
    name: "ListRuns",
    components: {AuthenticatedLayout, Card},
    data: function () {
        return {
            runs: []
        }
    },
    async created() {
        await this.loadUserQuestionRuns();
    },
    methods: {
        continueRun(run) {
            window.location = '/page/run/' + run.id + '/practice'
        },
        notStarted(run) {
            return run.status === 'created'
        },
        isInProgress(run) {
            return run.status === 'doing'
        },
        isFinished(run) {
            return run.status === 'finished'
        },

        async loadUserQuestionRuns() {
            this.runs = await QuestionRunService.readQuestionRun();
        },

        resolveName(run) {
            if (run.type === 'categories') {
                return "Category run"
            }

            return "Run"
        }
    }
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="h-5"></div>
        <div class="flex flex-wrap gap-4">
            <Card v-for="run in runs" class="w-1/4">
                <template #content>
                    <div class="flex justify-between">
                        <div class="text-lg text-bold">
                            {{ resolveName(run) }}
                        </div>
                        <hr>
                        <div>
                            <div class="badge badge-accent" v-if="notStarted(run)">
                                Not started
                            </div>
                            <div class="badge badge-primary text-white" v-if="isInProgress(run)">
                                In progress
                            </div>
                            <div class="badge badge-success text-white" v-if="isFinished(run)">
                                Finished
                            </div>
                        </div>

                    </div>
                    <div class="flex">
                        <div class="stat place-items-center">
                            <div class="stat-title">Total</div>
                            <div class="stat-value">{{ run.stats.count }}</div>
                        </div>
                        <div class="stat place-items-center">
                            <div class="stat-title">Answered</div>
                            <div class="stat-value text-secondary">{{ run.stats.answered }}</div>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button class="btn btn-primary btn-sm"
                                v-if="isInProgress(run) || notStarted(run)"
                                @click="continueRun(run)"
                        >
                            Continue
                        </button>
                        <button class="btn btn-secondary btn-sm"
                                v-if="isFinished(run)">
                            Analyze
                        </button>
                    </div>
                </template>
            </Card>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
