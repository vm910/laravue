<template>
  <section>
    <div>Index</div>
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
