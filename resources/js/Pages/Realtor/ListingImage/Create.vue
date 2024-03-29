<template>
  <Box>
    <template #header>Upload new images</template>
    <div v-if="imageErrors.length" class="input-error">
      <div v-for="(error, index) in imageErrors" :key="index">
        {{ error }}
      </div>
    </div>
    <form
      method="POST"
      :action="route('realtor.listing.image.store', { listing: listing.id })"
      @submit.prevent="submit"
    >
      <section class="flex items-center gap-2 my-4">
        <input
          class="border rounded-md file:px-4 file:py-2 border-gray-200 dark:border-gray-700 file:text-gray-700 file:dark:text-gray-400 file:border-0 file:bg-gray-100 file:dark:bg-gray-800 file:font-medium file:hover:bg-gray-200 file:dark:hover:bg-gray-700 file:hover:cursor-pointer file:mr-4"
          type="file"
          multiple
          @input="addFiles"
        />
        <button
          :disabled="!canSubmit"
          type="submit"
          class="btn-outline disabled:opacity-25 disabled:cursor-not-allowed"
        >
          Upload
        </button>
        <button type="reset" class="btn-outline" @click="reset">Reset</button>
      </section>
    </form>
  </Box>
  <Box v-if="listing.images.length" class="mt-4">
    <template #header>Images</template>
    <section class="mt-4 grid grid-cols-3 gap-4">
      <div
        v-for="image in listing.images"
        :key="image.id"
        class="flex flex-col justify-between"
      >
        <img :src="image.src" class="rounded-md" />
        <Link
          :href="
            route('realtor.listing.image.destroy', {
              listing: listing.id,
              image: image.id,
            })
          "
          method="DELETE"
          as="button"
          class="mt-2 btn-outline text-xs"
          >Delete</Link
        >
      </div>
    </section>
  </Box>
</template>

<script setup>
import { computed } from "vue";
import Box from "@/Components/UI/Box.vue";
import { useForm, router, Link } from "@inertiajs/vue3";
import NProgress from "nprogress";

const props = defineProps({
  listing: {
    type: Object,
    required: true,
  },
});

router.on("progress", (e) => {
  if (e.detail.progress.percentage) {
    NProgress.set((e.detail.progress.percentage / 100) * 0.9);
  }
});

const form = useForm({
  images: [],
});

const imageErrors = computed(() => {
  return Object.values(form.errors);
});

const canSubmit = computed(() => {
  return form.images.length > 0;
});

const submit = () => {
  form.post(
    route("realtor.listing.image.store", { listing: props.listing.id }),
    {
      onSuccess: () => {
        form.reset("images");
      },
    }
  );
};

const addFiles = (e) => {
  for (const image of e.target.files) {
    form.images.push(image);
  }
};

const reset = () => {
  form.reset("images");
};
</script>
