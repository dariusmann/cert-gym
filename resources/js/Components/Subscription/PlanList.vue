<template>
    <div class="space-y-6">
        <div class="bg-white sm:rounded-lg shadow-sm overflow-hidden" v-for="plan in plans">
            <plan :plan="plan" :seat-name="seatName" />

            <div class="px-6 py-4 bg-gray-100 bg-opacity-50 border-t border-gray-100 text-center">
                <PrimaryButton class="ms-4" @click="$emit('plan-selected', plan)">
                    Try it out!
                </PrimaryButton>
            </div>
        </div>
    </div>
</template>

<script>

import Plan from "@/Components/Subscription/Plan.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

export default {
    components: {PrimaryButton, Plan},

    props: ['plans', 'seatName'],
}
</script>
