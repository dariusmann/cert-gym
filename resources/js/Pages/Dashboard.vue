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
                        <div class="prose text-center mx-auto mt-12">
                            <h2>
                                Join Our Discord Community!
                            </h2>
                            <a href="https://discord.gg/8YhnE9Yp" target="_blank" class="btn btn-accent">
                                Click here
                                <i class="fa-brands fa-discord"></i>
                            </a>
                            <p>
                                Dive into our Discord server for instant support, engaging discussions, and the chance
                                to connect with fellow users. Whether it's for asking questions, seeking support,
                                reporting bugs, or just sharing your enthusiasm about our app's topic, our Discord is
                                the place for you.
                            </p>
                            <div>
                                <h3>What you'll find:</h3>
                                <p>
                                    <strong>Quick Support:</strong> Get help when you need it.
                                </p>
                                <p>
                                    <strong>Discussions & Insights:</strong> Share and gain knowledge.
                                </p>
                                <p>
                                    <strong>Meet Others:</strong> Connect with like-minded users.
                                </p>
                                <p>
                                    <strong>Report Bugs:</strong> Help us improve with your feedback.
                                </p>
                                <p>
                                    <strong>Feature Requests:</strong> Suggest new features you'd love to see.
                                </p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
