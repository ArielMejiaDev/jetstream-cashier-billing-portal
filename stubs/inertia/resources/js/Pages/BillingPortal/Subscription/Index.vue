<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Billing
            </h2>

            <div class="mt-3 space-x-2">
                <jet-secondary-button @click.native="$inertia.visit(route('billing-portal.invoice.index'))">
                    Invoices
                </jet-secondary-button>

                <jet-secondary-button @click.native="$inertia.visit(route('billing-portal.payment-method.index'))">
                    Payment methods
                </jet-secondary-button>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-wrap justify-center">
                    <div
                        v-for="plan in plans"
                        :key="`plan-${plan.id}`"
                        class="p-4 md:w-1/3 w-full"
                    >
                        <plan-slide
                            :plan="plan"
                            :active="currentPlan && plan.id === currentPlan.id"
                            :currentPlan="currentPlan"
                            :features="plan.features"
                            :recurring="recurring"
                            :cancelled="cancelled"
                            :onGracePeriod="onGracePeriod"
                            :endingDate="endingDate"
                            :disable="false"
                        />
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout';
import JetSecondaryButton from '@/Jetstream/SecondaryButton';
import PlanSlide from '@/BillingPortal/PlanSlide';

export default {
    components: {
        AppLayout,
        JetSecondaryButton,
        PlanSlide,
    },
    props: [
        'currentPlan',
        'hasDefaultPaymentMethod',
        'paymentMethods',
        'plans',
        'recurring',
        'cancelled',
        'onGracePeriod',
        'endingDate',
    ],
}
</script>
