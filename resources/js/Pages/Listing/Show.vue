<template>
  <div class="flex flex-col-reverse md:grid md:grid-cols-12 gap-4">
    <box
      v-if="listing.images.length"
      class="md:col-span-7 flex items-center w-full"
      ><div class="w-full text-center font-medium text-gray-500">
        <div class="grid grid-cols-2 gap-1">
          <img
            v-for="image in listing.images"
            :key="image.id"
            :src="image.src"
          />
        </div></div
    ></box>
    <empty-state v-else class="md:col-span-7 flex items-center w-full">
      No Images
    </empty-state>
    <div class="md:col-span-5 flex flex-col gap-4">
      <box>
        <template #header>Basic info</template>
        <price :price="listing.price" class="text-2xl font-bold"></price>
        <listing-space :listing="listing" class="text-lg"></listing-space>
        <listing-address
          :listing="listing"
          class="text-gray-500"
        ></listing-address>
      </box>
      <box
        ><template #header>Monthly payment</template>
        <div>
          <label class="label">Interest rate ({{ interestRate }} %) </label>
          <input
            v-model.number="interestRate"
            type="range"
            min="0.1"
            max="30"
            step="0.1"
            class="w-full h-4 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
          />
          <label class="label">Duration ({{ duration }} years) </label>
          <input
            v-model.number="duration"
            type="range"
            min="3"
            max="35"
            step="1"
            class="w-full h-4 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
          />
        </div>
        <div class="text-gray-600 dark:text-gray-300 mt-2">
          <div class="text-gray-400">Your monthly payment</div>
          <price :price="monthlyPayment" class="text-3xl"></price>
        </div>

        <div class="mt-2 text-gray-500">
          <div class="flex justify-between">
            <div>Total paid</div>
            <div>
              <price :price="totalPaid"></price>
            </div>
          </div>

          <div class="flex justify-between">
            <div>Principal</div>
            <div>
              <price :price="listing.price"></price>
            </div>
          </div>

          <div class="flex justify-between">
            <div>Total interest</div>
            <div>
              <price :price="totalInterest"></price>
            </div>
          </div>
        </div>
      </box>

      <make-offer
        v-if="user && !offerMade"
        @offer-updated="offer = $event"
        :listing-id="listing.id"
        :price="listing.price"
      ></make-offer>

      <offer-made v-if="user && offerMade" :offer="offerMade"></offer-made>
    </div>
  </div>
</template>

<script setup>
import ListingAddress from "@/Components/ListingAddress.vue";
import ListingSpace from "@/Components/ListingSpace.vue";
import Price from "@/Components/Price.vue";
import Box from "@/Components/UI/Box.vue";
import MakeOffer from "@/Pages/Listing/Show/Components/MakeOffer.vue";
import { ref, computed } from "vue";
import { useMonthlyPayment } from "@/Composables/useMonthlyPayment";
import { usePage } from "@inertiajs/vue3";
import OfferMade from "./Show/Components/OfferMade.vue";
import EmptyState from "@/Components/UI/EmptyState.vue";

const interestRate = ref(2.5);
const duration = ref(25);

const props = defineProps({
  listing: {
    type: Object,
    required: true,
  },
  offerMade: {
    type: Object,
  },
});

const offer = ref(props.listing.price);

const { monthlyPayment, totalPaid, totalInterest } = useMonthlyPayment(
  offer,
  interestRate,
  duration
);

const user = computed(() => {
  return usePage().props.user;
});
</script>

<style scoped></style>
