<template>
  <Box>
    <template #header> Make an Offer </template>
    <div>
      <form @submit.prevent="makeOffer">
        <input v-model.number="form.amount" type="text" class="input" />
        <input
          v-model="form.amount"
          type="range"
          :min="min"
          :max="max"
          step="10000"
          class="w-full h-4 mt-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
        />

        <button type="submit" class="btn-outline w-full mt-2 text-sm">
          Make an offer
        </button>
      </form>
    </div>
    <div class="flex justify-between text-gray-500 mt-2">
      <div>Difference</div>
      <div>
        <Price :price="difference"></Price>
      </div>
    </div>
  </Box>
</template>

<script setup>
import Price from "@/Components/Price.vue";
import Box from "@/Components/UI/Box.vue";
import { useForm } from "@inertiajs/vue3";
import { computed, watch } from "vue";
import { debounce } from "lodash";

const props = defineProps({
  listingId: {
    type: Number,
    required: true,
  },

  price: {
    type: Number,
    required: true,
  },
});

const form = useForm({
  amount: props.price,
});

const makeOffer = () => {
  form.post(route("listing.offer.store", { listing: props.listingId }), {
    preserveScroll: true,
    preserveState: true,
  });
};

const difference = computed(() => {
  return form.amount - props.price;
});

const min = computed(() => {
  return Math.round(props.price / 2);
});

const max = computed(() => {
  return Math.round(props.price * 2);
});

const emit = defineEmits(["offerUpdated"]);

watch(
  () => form.amount,
  debounce((value) => {
    emit("offerUpdated", value);
  }, 200)
);
</script>
