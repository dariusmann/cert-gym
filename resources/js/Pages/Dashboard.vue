<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue'
import { usePage, Link } from '@inertiajs/vue3'
import RandomRunButton from "@/Components/Questions/Runs/RandomRunButton.vue";

const page = usePage()

const subscription = computed(() => page.props.subscription)
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div v-if="!subscription.isValid">
                            <p>
                                You must <a class="text-orange-600" href="/billing">select a subscription plan</a> before continuing.
                            </p>
                        </div>
                        <div v-else>
                            <RandomRunButton/>
                            <Link class="btn btn-primary" :href="route('page.run.category.create')">Category Run</Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
