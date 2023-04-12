<template>
  <form @submit.prevent="submit">
    <div class="w-1/2 mx-auto">
      <div>
        <label for="email" class="label">Email</label>
        <input
          type="text"
          name="email"
          id="email"
          class="input"
          placeholder="Email"
          v-model="form.email"
        />
        <div v-if="form.errors.email" class="input-error">
          {{ form.errors.email }}
        </div>
      </div>
      <div class="mt-4">
        <label for="password" class="label">Password</label>
        <input
          type="password"
          name="password"
          id="password"
          class="input"
          placeholder="Password"
          v-model="form.password"
        />
        <div v-if="form.errors.password" class="input-error">
          {{ form.errors.password }}
        </div>
      </div>
      <div class="mt-4">
        <button type="submit" class="base-button w-full">Login</button>

        <div class="mt-2 text-center">
          <Link
            :href="route('user-account.create')"
            class="text-sm text-gray-500"
            >Register</Link
          >
        </div>
      </div>
    </div>
  </form>
</template>

<script setup>
import { useForm, Link } from "@inertiajs/vue3";

const form = useForm({
  email: "",
  password: "",
});

const submit = () => {
  form.post(route("login.store"));
};
</script>
