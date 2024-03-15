<script>
import QuestionRunService from "@/Services/question.run.service.js";
import Card from 'primevue/card';

export default {
    name: "RandomRunButton",
    components: {Card},
    methods: {
        async submit() {
            const randomRun = await QuestionRunService.readRandomRun();

            window.location = '/page/run/' + randomRun.id + '/practice'
        }
    }
}
</script>

<template>
    <Card>
        <template #content>
            <div class="text-center">
                <div>
                    <p>
                        Practice with random questions
                    </p>
                </div>

                <button @click="submit" class="mt-4 btn btn-primary">
                    Quick start
                </button>
            </div>
        </template>
    </Card>
</template>

<style scoped>

</style>
