<script>
import {Link} from "@inertiajs/vue3";
import Card from 'primevue/card';

export default {
    name: "CategoryCreateRunButton",
    components: {Link, Card}
}
</script>

<template>
    <Card>
        <template #content>
            <div class="text-center">
                <div>
                    <p>
                        Practice on concrete categories
                    </p>
                </div>

                <Link class="mt-4 btn btn-primary" :href="route('page.run.category.create')">Category Run</Link>
            </div>

        </template>
    </Card>

</template>

<style scoped>

</style>
