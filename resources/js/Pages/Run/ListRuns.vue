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
            if (run.type === 'exam') {
                window.location = '/page/run/' + run.id + '/exam/practice'
                return;
            }
            window.location = '/page/run/' + run.id + '/practice'
        },
        notStarted(run) {
            return run.status === 'not_started'
        },
        isInProgress(run) {
            return run.status === 'in_progress'
        },
        isFinished(run) {
            return run.status === 'completed'
        },
        async loadUserQuestionRuns() {
            this.runs = await QuestionRunService.readQuestionRun();
        },
        resolveName(run) {
            if (run.type === 'categories') {
                return "Category run"
            }

            if (run.type === 'exam') {
                return "Exam"
            }

            return "Run"
        },
        analyseRun(run) {
            window.location = '/page/run/result/' + run.id
        }
    }
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="h-5"></div>
        <div class="prose">
            <h1>All your Runs</h1>
        </div>
        <div class="mt-6">
            <div v-if="runs.length === 0">
                <div role="alert" class="alert alert-info text-white">
                    <i class="fa-solid fa-circle-info"></i>
                    <span>You did not start any runs yet. Go back to
                        <a :href="route('dashboard')" class="link">Dashboard</a> and start a <b>Task List Run</b>
                        or <b>Exam Run</b> and there will al be listed here.</span>
                </div>
            </div>
            <div v-else class="grid grid-cols-1 gap-4">
                <div v-for="run in runs" class="card w-full bg-base-100 shadow-xl">
                    <div class="grid grid-cols-5 px-2 lg:px-10">
                        <div class="flex items-center">
                            <div class="text-lg text-bold">
                                {{ resolveName(run) }}
                            </div>
                        </div>
                        <div class="flex items-center justify-center">
                            <div class="stat place-items-center">
                                <div class="stat-title">Total</div>
                                <div class="stat-value">{{ run.stats.count }}</div>
                            </div>
                        </div>
                        <div class="flex items-center justify-center">
                            <div class="stat place-items-center">
                                <div class="stat-title">Answered</div>
                                <div class="stat-value text-secondary">{{ run.stats.answered }}</div>
                            </div>
                        </div>
                        <div class="flex items-center justify-center">
                            <div class="ml-2">
                                <div class="badge badge-accent" v-if="notStarted(run)">
                                    Not started
                                </div>
                                <div class="badge badge-primary text-white" v-if="isInProgress(run)">
                                    In progress
                                </div>
                                <div class="badge badge-success text-white" v-if="isFinished(run)">
                                    Completed
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end items-center">
                            <button class="btn btn-primary btn-sm"
                                    v-if="isInProgress(run) || notStarted(run)"
                                    @click="continueRun(run)"
                            >
                                Continue
                            </button>
                            <button class="btn btn-secondary btn-sm"
                                    v-if="isFinished(run)"
                                    @click="analyseRun(run)"
                            >
                                Analyze
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>
