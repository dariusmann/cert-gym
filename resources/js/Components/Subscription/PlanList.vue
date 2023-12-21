<template>
    <div class="space-y-6">
        <div class="bg-white sm:rounded-lg shadow-sm overflow-hidden" v-for="plan in plans">
            <plan :plan="plan" :seat-name="seatName" />

            <div class="px-6 py-4 bg-gray-100 bg-opacity-50 border-t border-gray-100 text-right">
                <button class="bg-p-primary" @click="$emit('plan-selected', plan)" v-if="! currentPlan || (currentPlan && currentPlan.id !== plan.id)">
                    Subscribe
                </button>

                <div class="flex justify-end items-center" v-if="currentPlan && currentPlan.id === plan.id">
                    <div class="ml-1 text-sm text-gray-400">{{ 'Currently Subscribed' }}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import Plan from "@/Components/Subscription/Plan.vue";

export default {
    components: {Plan},

    props: ['plans', 'interval', 'currentPlan', 'seatName'],
}
</script>
