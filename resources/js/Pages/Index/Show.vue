<template>
  <section>
    <div>Show</div>
    <div>{{ message }}</div>
  </section>
</template>

<script setup>
const props = defineProps({
  message: {
    type: String,
    required: true,
  },
});
</script>
