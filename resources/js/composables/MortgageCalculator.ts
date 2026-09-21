import { ref, computed, toValue } from 'vue';
import { MaybeRefOrGetter } from "vue";

export function useMonthlyPayment(
    price: MaybeRefOrGetter<number>,
    interestRate: MaybeRefOrGetter<number>,
    duration: MaybeRefOrGetter<number>,
) {
    const monthlyPayment = computed(() => {
        const principal = toValue(price);
        const monthlyInterest = toValue(interestRate) / 100 / 12;
        const months = toValue(duration) * 12;

        if (monthlyInterest === 0) {
            return principal / months;
        }

        if (months === 0) {
            return 0;
        }

        return (
            (principal * monthlyInterest) /
            (1 - Math.pow(1 + monthlyInterest, -months))
        ); 
        })

    const totalPaid = computed(() => toValue(duration) * 12 * monthlyPayment.value)

    return { monthlyPayment, totalPaid };
}