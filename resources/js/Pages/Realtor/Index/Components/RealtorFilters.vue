<template>
  <form>
    <div class="mb-4 mt-4 flex flex-wrap gap-4">
      <div class="flex flex-nowrap items-center gap-2">
        <input
          v-model="filterForm.deleted"
          id="deleted"
          type="checkbox"
          class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus focused:ring-indigo-500"
        />
        <label for="deleted" class="text-gray-700 dark:text-gray-300"
          >Deleted</label
        >
      </div>

      <div>
        <select
          v-model="filterForm.by"
          class="filter-text-l w-24"
          name=""
          id=""
        >
          <option value="created_at">Added</option>
          <option value="price">Price</option>
        </select>
        <select
          v-model="filterForm.order"
          class="filter-text-r w-34"
          name=""
          id=""
        >
          <option
            v-for="option in sortOptions"
            :value="option.value"
            :key="option.label"
          >
            {{ option.label }}
          </option>
        </select>
      </div>
    </div>
  </form>
</template>

<script setup>
import { reactive, watch, computed } from "vue";
import { router } from "@inertiajs/vue3";
import { debounce } from "lodash";

const props = defineProps({
  filters: {
    type: Object,
  },
});

const sortLabels = {
  created_at: [
    {
      label: "Latest",
      value: "desc",
    },
    {
      label: "Oldest",
      value: "asc",
    },
  ],

  price: [
    {
      label: "Most expensive",
      value: "desc",
    },
    {
      label: "Cheapest",
      value: "asc",
    },
  ],
};

const sortOptions = computed(() => {
  return sortLabels[filterForm.by];
});

const filterForm = reactive({
  deleted: props.filters.deleted || false,
  by: props.filters.by || "created_at",
  order: props.filters.orde || "desc",
});

watch(
  filterForm,
  debounce(() => {
    router.get(route("realtor.listing.index"), filterForm, {
      preserveState: true,
      preserveScroll: true,
    });
  }, 1000)
);
</script>
