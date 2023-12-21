<template>
    <div class="h-screen flex items-center justify-center bg-gray-100">

        <div class="w-1/3">
            <div class="flex justify-center">
                <ApplicationLogo class="h-20"/>
            </div>
            <transition-group name="component-fade" mode="out-in">
                <!-- Monthly Plans -->
                <plan-list class="mt-6" key="subscribe-monthly-plans"
                           :plans="monthlyPlans"
                           interval="monthly"
                           :seat-name="seatName"
                           :current-plan="plan"
                           @plan-selected="startSubscribingToPlan($event)"
                           v-if="monthlyPlans.length > 0 && showingPlansOfInterval === 'monthly'"/>

                <!-- Yearly Plans -->
                <plan-list class="mt-6" key="subscribe-yearly-plans"
                           :plans="yearlyPlans"
                           interval="yearly"
                           :seat-name="seatName"
                           :current-plan="plan"
                           @plan-selected="startSubscribingToPlan($event)"
                           v-if="yearlyPlans.length > 0 && showingPlansOfInterval === 'yearly'"/>
            </transition-group>
            <div class="mt-5 flex justify-center">
                <img class="h-28" :src="paymentBadgeSrc" alt="Stripe payment badget">
            </div>
        </div>
    </div>
</template>
<script>
import PlanList from "@/Components/Subscription/PlanList.vue";
import logoSrc from '../../../images/checkout/logo.png';
import paymentBadgeSrc from '../../../images/checkout/stripe-badge-white.png';
import ApplicationLogo from "@/Components/ApplicationLogo.vue";

export default {
    components: {ApplicationLogo, PlanList},
    props: [
        'balance',
        'invoices',

        'billableId',
        'billableType',
        'billingAddressRequired',
        'collectionMethod',
        'collectsVat',
        'collectsBillingAddress',
        'monthlyPlans',
        'paymentMethod',
        'paymentMethods',
        'plan',
        'seatName',
        'userName',
        'yearlyPlans',
    ],
    data() {
        return {
            errors: [],
            processing: false,
            logoSrc: logoSrc,
            paymentBadgeSrc: paymentBadgeSrc,

            showingPlansOfInterval: 'monthly',

            subscribing: null,
            addingVatNumber: false,
            subscriptionForm: {
                coupon: null,
                country: '',
                accept: false,
                vat: '',
                postal_code: '',
                address: '',
                address2: '',
                city: '',
                state: '',
                extra: ''
            },

            checkoutTax: 0,
            checkoutAmount: 0,
            rawCheckoutAmount: 0,
            loadingTaxCalculations: true,

            paymentInformationForm: {
                country: '',
                vat: '',
                postal_code: '',
                address: '',
                address2: '',
                city: '',
                state: '',
                extra: ''
            },

            receiptEmailsForm: {
                receipt_emails: '',
            },

            couponForm: {
                coupon: '',
            },

            selectingNewPlan: false,
            updatingPaymentInformation: false,

            billingInformationForm: {
                extra: ''
            },

            confirmAction: null,
            confirmArguments: [],
            confirmText: '',
            showModal: false,

            reloadDataID: null,
        };
    },
    methods: {
        startSubscribingToPlan(plan) {
            if (! this.$page.props.collectsVat && ! this.$page.props.collectsBillingAddress) {
                this.request('POST', '/spark/subscription', {
                    plan: plan.id,
                    direct: true,
                }).then(response => {
                    if (response) {
                        window.location.href = response.data.redirect;
                    } else {
                        this.processing = false;
                    }
                });

                return;
            }


            this.subscribing = plan;
        },
        request(method, url, data = {}) {
            this.errors = [];

            data.billableType = this.billableType;
            data.billableId = this.billableId;

            return axios.request({
                url: url,
                method: method,
                data: data,
            }).then(response => {
                return response;
            }).catch(error => {
                if (error.response.status === 422) {
                    this.errors = _.flatMap(error.response.data.errors)
                } else {
                    this.errors = [this.trans('An unexpected error occurred and we have notified our support team. Please try again later.')]
                }

                document.body.scrollTop = 0;
                document.documentElement.scrollTop = 0;
            });
        },
    }
}
</script>
