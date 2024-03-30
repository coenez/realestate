import {computed, isRef} from "vue";

export const useMonthlyPayment = (total, interestRate, duration) => {
    const durationValue = computed(() => isRef(duration) ? duration.value : duration);
    const totalValue = computed(() => isRef(total) ? total.value : total);

    const monthlyPayment = computed(() => {
        const principle = totalValue.value;
        const monthlyInterest = (isRef(interestRate) ? interestRate.value : interestRate) / 100 / 12;
        const numberOfPaymentMonths = durationValue.value * 12;

        return principle * monthlyInterest * (Math.pow(1 + monthlyInterest, numberOfPaymentMonths)) / (Math.pow(1 + monthlyInterest, numberOfPaymentMonths) - 1);
    });

    const totalPaid = computed(() => {
        return durationValue.value * 12 * monthlyPayment.value;
    });

    const totalInterest = computed(() => totalPaid.value - totalValue.value);

    return { monthlyPayment, totalPaid, totalInterest };
}
