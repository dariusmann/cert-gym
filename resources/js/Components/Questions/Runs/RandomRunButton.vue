<script>
import QuestionRunService from "@/Services/question.run.service.js";
import Card from 'primevue/card';

export default {
    name: "RandomRunButton",
    components: {Card},
    methods: {
        async submit() {
            const randomRun = await QuestionRunService.readRandomRun();

            window.location = '/page/run/' + randomRun.id + '/random/practice'
        }
    }
}
</script>

<template>
    <Card>
        <template #content>
            <div class="text-center flex flex-col justify-between">
                <div>
                    <i class="text-4xl fa-solid fa-star"></i>
                    <div class="text-2xl mt-2">Practice</div>
                    <p class="mt-2">
                        Practice with random questions from our data base. Perfect to train!
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
