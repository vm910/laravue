<template>
  <box>
    <div>
      <Link
        :href="route('listing.show', { listing: listing.id })"
        :listing="listing"
      >
        <div class="flex items-center gap-1">
          <price :price="listing.price" class="text-2xl font-bold"></price>
          <div class="text-xs text-gray-500">
            <price :price="monthlyPayment"></price>
          </div>
        </div>

        <listing-space :listing="listing" class="text-lg"></listing-space>
        <listing-address
          :listing="listing"
          class="text-gray-500"
        ></listing-address>
      </Link>
    </div>
  </box>
</template>

<script setup>
import ListingAddress from "@/Components/ListingAddress.vue";
import ListingSpace from "@/Components/ListingSpace.vue";
import Price from "@/Components/Price.vue";
import { Link } from "@inertiajs/vue3";
import Box from "@/Components/UI/Box.vue";
import { useMonthlyPayment } from "@/Composables/useMonthlyPayment";

const props = defineProps({
  listing: {
    type: Object,
    required: true,
  },
});

const { monthlyPayment } = useMonthlyPayment(props.listing.price, 2.5, 25);
</script>
