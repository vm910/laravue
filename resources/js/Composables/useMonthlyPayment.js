import { computed, isRef } from "vue";

export const useMonthlyPayment = (loanAmount, interestRate, duration) => {
  const monthlyPayment = computed(() => {
    const interest = isRef(interestRate)
      ? interestRate.value / 100 / 12
      : interestRate / 100 / 12;
    const payments = isRef(duration) ? duration.value * 12 : duration * 12;

    const x = Math.pow(1 + interest, payments);
    const monthly = isRef(loanAmount)
      ? (loanAmount.value * x * interest) / (x - 1)
      : (loanAmount * x * interest) / (x - 1);

    return monthly;
  });

  const totalPaid = computed(() => {
    const monthly = isRef(monthlyPayment)
      ? monthlyPayment.value
      : monthlyPayment;
    const payments = isRef(duration) ? duration.value * 12 : duration * 12;

    return monthly * payments;
  });

  const totalInterest = computed(() => {
    const total = isRef(totalPaid) ? totalPaid.value : totalPaid;
    const loan = isRef(loanAmount) ? loanAmount.value : loanAmount;

    return total - loan;
  });

  return { monthlyPayment, totalPaid, totalInterest };
};
