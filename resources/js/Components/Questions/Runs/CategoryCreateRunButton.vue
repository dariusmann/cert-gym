<script>
import {Link} from "@inertiajs/vue3";
import Card from 'primevue/card';

export default {
    name: "CategoryCreateRunButton",
    components: {Link, Card}
}
</script>

<template>
    <Card class="h-full">
        <template #content>
            <div class="text-center flex flex-col justify-between h-full">
                <div>
                    <i class="text-4xl fa-solid fa-list"></i>
                    <div class="text-2xl mt-2">Task List Run</div>
                    <p class="mt-2">
                        Select the Task List Categories you want to practice on.
                    </p>
                </div>

                <Link class="mt-4 btn btn-primary" :href="route('page.run.category.create')">
                    Create Run
                </Link>
            </div>

        </template>
    </Card>

</template>

<style scoped>

</style>
