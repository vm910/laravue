<template>
  <form @submit.prevent="submit">
    <div class="w-1/2 mx-auto">
      <div>
        <label for="name" class="label">Name</label>
        <input
          type="text"
          name="name"
          id="name"
          class="input"
          placeholder="Name"
          v-model="form.name"
        />
        <div v-if="form.errors.name" class="input-error">
          {{ form.errors.name }}
        </div>
      </div>
      <div class="mt-4">
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
        <label for="password_confirmation" class="label"
          >Password Confirmation</label
        >
        <input
          type="password"
          name="password_confirmation"
          id="password_confirmation"
          class="input"
          placeholder="Password Confirmation"
          v-model="form.password_confirmation"
        />
        <div v-if="form.errors.password_confirmation" class="input-error">
          {{ form.errors.password_confirmation }}
        </div>
      </div>
      <div class="mt-4">
        <button type="submit" class="base-button w-full">Sign up</button>

        <div class="mt-2 text-center">
          <Link :href="route('login')" class="text-sm text-gray-500"
            >Login</Link
          >
        </div>
      </div>
    </div>
  </form>
</template>

<script setup>
import { useForm, Link } from "@inertiajs/vue3";

const form = useForm({
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
});

const submit = () => {
  form.post(route("user-account.store"));
};
</script>
