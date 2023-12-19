<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

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
                            <p>
                                <span class="text-red-600">ATTENTION:</span> This was a test campaign. Please cancel you subscription in the <a class="text-orange-600" href="/billing">billing portal</a>.
                            </p>
                            <p>
                                If you don't do that, you will be charged. But don't worry, if this happens, I will contact you by email and refund your money.
                            </p>
                            <p>
                                My contact: darius.mann@cert-gym.com
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
