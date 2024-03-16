<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import {computed} from 'vue'
import {usePage, Link} from '@inertiajs/vue3'
import RandomRunButton from "@/Components/Questions/Runs/RandomRunButton.vue";
import ExamRunButton from "@/Components/Questions/Runs/ExamRunButton.vue";
import CategoryCreateRunButton from "@/Components/Questions/Runs/CategoryCreateRunButton.vue";

const page = usePage()

const subscription = computed(() => page.props.subscription)
</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="container">
                <div class="">
                    <div v-if="!subscription.isValid">
                        <p>
                            You must <a class="text-orange-600" href="/billing">select a subscription plan</a> before
                            continuing.
                        </p>
                    </div>
                    <div v-else>
                        <div class="grid grid-cols-3 gap-5">
                            <div>
                                <RandomRunButton/>
                            </div>
                            <div>
                                <CategoryCreateRunButton/>
                            </div>
                            <div>
                                <ExamRunButton/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
