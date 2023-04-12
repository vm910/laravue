<template>
  <div>{{ listing.city }} {{ listing.street }} {{ listing.street_nr }}</div>
</template>

<script setup>
defineProps({
  listing: {
    type: Object,
    required: true,
  },
});
</script>

<style scoped></style>
