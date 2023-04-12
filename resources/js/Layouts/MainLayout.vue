<template>
  <header
    class="border-b border-gray-200 dark:border-gray-900 bg-white dark:bg-gray-900 w-full"
  >
    <div class="container mx-auto">
      <nav class="p-4 flex items-center justify-between">
        <div class="text-lg font-medium">
          <Link :href="route('listing.index')">Listings</Link>
        </div>
        <div class="text-xl text-indigo-600 dark:text-indigo-300">
          <Link :href="route('listing.index')">LaraVue</Link>
        </div>
        <div v-if="user" class="flex items-center gap-4">
          <Link
            :href="route('notification.index')"
            class="text-gray-500 relative pr-2 py-2"
          >
            <Bell class="w-6 h-6" />
            <div
              class="absolute right-0 top-0 w-5 h-5 bg-red-700 dark:bg-red-400 text-white font-medium border border-white dark:border-gray-900 rounded-full text-xs text-center"
              v-if="notificationCount"
            >
              {{ notificationCount }}
            </div>
          </Link>
          <Link
            :href="route('realtor.listing.index')"
            class="text-sm text-gray-500"
            >{{ user.name }}</Link
          >
          <Link :href="route('realtor.listing.create')" class="base-button"
            >+ New Listing</Link
          >
          <div>
            <Link :href="route('logout')" method="delete" as="button"
              >Logout</Link
            >
          </div>
        </div>
        <div v-else class="flex gap-4">
          <Link :href="route('user-account.create')" class="base-button"
            >Register</Link
          >
          <Link :href="route('login')" class="base-button">Login</Link>
        </div>
      </nav>
    </div>
  </header>

  <main class="container mx-auto p-4 w-full">
    <div
      v-if="flashSuccess"
      class="mb-4 border rounded-md shadow-sm border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900 p-2"
    >
      {{ flashSuccess }}
    </div>
    <slot></slot>
  </main>
</template>

<script setup>
import { computed } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import Bell from "@/Components/Bell.vue";

const flashSuccess = computed(() => {
  return usePage().props.flash.success;
});

const user = computed(() => {
  return usePage().props.user;
});

const notificationCount = computed(() => {
  return usePage().props.user.notificationCount <= 9
    ? usePage().props.user.notificationCount
    : "9+";
});
</script>
