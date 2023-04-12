<template>
  <form @submit.prevent="filter">
    <div class="flex flex-nowrap items-center gap-4">
      <div v-if="!validPriceRange" class="input-error">Invalid price range</div>
      <div v-if="!validAreaRange" class="input-error">Invalid area range</div>
    </div>
    <div class="mb-8 mt-4 flex flex-wrap gap-2">
      <div class="flex flex-nowrap items-center">
        <input
          v-model.number="filterForm.priceFrom"
          class="filter-text-l w-28"
          type="text"
          placeholder="Price from"
        />
        <input
          v-model.number="filterForm.priceTo"
          class="filter-text-r w-28"
          type="text"
          placeholder="Price to"
        />
      </div>

      <div class="flex flex-nowrap items-center">
        <select v-model="filterForm.beds" class="filter-text-l" name="" id="">
          <option value="">Beds</option>
          <option v-for="bed in 5" :key="bed" :value="bed">{{ bed }}</option>
          <option value="">6+</option>
        </select>
        <select v-model="filterForm.baths" class="filter-text-r" name="" id="">
          <option value="">Baths</option>
          <option v-for="bath in 5" :key="bath" :value="bath">
            {{ bath }}
          </option>
          <option value="">6+</option>
        </select>
      </div>
      <div class="flex flex-nowrap items-center">
        <input
          v-model.number="filterForm.areaFrom"
          class="filter-text-l w-28"
          type="text"
          placeholder="Area from"
        />
        <input
          v-model.number="filterForm.areaTo"
          class="filter-text-r w-28"
          type="text"
          placeholder="Area to"
        />
      </div>

      <button type="submit" class="base-button">Filter</button>
      <button type="reset" class="base-button" @click="clear">Clear</button>
    </div>
  </form>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import { computed } from "vue";

const props = defineProps({
  filters: {
    type: Object,
  },
});

const filterForm = useForm({
  priceFrom: props.filters.priceFrom ?? null,
  priceTo: props.filters.priceTo ?? null,
  beds: props.filters.beds ?? null,
  baths: props.filters.baths ?? null,
  areaFrom: props.filters.areaFrom ?? null,
  areaTo: props.filters.areaTo ?? null,
});

const validPriceRange = computed(() => {
  if (filterForm.priceFrom && filterForm.priceTo) {
    return filterForm.priceFrom <= filterForm.priceTo;
  }
  return true;
});

const validAreaRange = computed(() => {
  if (filterForm.areaFrom && filterForm.areaTo) {
    return filterForm.areaFrom <= filterForm.areaTo;
  }
  return true;
});

const filter = () => {
  if (!validPriceRange.value || !validAreaRange.value) {
    return;
  }
  filterForm.get(route("listing.index"), {
    preserveState: true,
    preserveScroll: true,
  });
};

const clear = () => {
  filterForm.priceFrom = null;
  filterForm.priceTo = null;
  filterForm.beds = null;
  filterForm.baths = null;
  filterForm.areaFrom = null;
  filterForm.areaTo = null;
  filter();
};
</script>
