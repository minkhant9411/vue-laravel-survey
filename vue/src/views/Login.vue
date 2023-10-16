
<template>
  <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
      <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
        alt="Your Company" />
      <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">
        Sign in to your account
      </h2>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <form class="space-y-6" @submit.prevent='login'>
        <div class=" bg-red-500 p-2 m-2 mt-5 rounded-md text-sm max-w-[360px] text-white lg:absolute bottom-0 right-0
          " v-if="errors">
          * The provited credentials are not correct
        </div>
        <div>
          <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
          <div class="mt-2">
            <input id="email" name="email" v-model="user.email" type="email" autocomplete="email" required
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
          </div>
        </div>

        <div>
          <div class="flex items-center justify-between">
            <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
          </div>
          <div class="mt-2">
            <input id="password" v-model="user.password" name="password" type="password" autocomplete="current-password"
              required
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
          </div>
        </div>

        <div class="relative flex gap-x-3">
          <div class="flex h-6 items-center">
            <input id="remember" v-model="user.remember" name="remember" type="checkbox"
              class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600" />
          </div>
          <div class="text-sm leading-6">
            <label for="remember" class="font-medium text-gray-900">Remember me</label>
          </div>
        </div>
        <div>
          <button type="submit"
            class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
            :class="loading ? 'bg-indigo-300 cursor-not-allowed hover:bg-indigo-300' : ''" :disabled='loading'>
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" v-if="loading" xmlns="http://www.w3.org/2000/svg"
              fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
              </path>
            </svg> Sign in
          </button>
        </div>
      </form>

      <p class="mt-10 text-center text-sm text-gray-500">
        Not a member?
        {{ " " }}
        <router-link :to="{ name: 'Register' }"
          class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Register Here</router-link>
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router'
import store from '../store'
const user = ref({
  password: '',
  email: '',
  remember: false
})
const router = useRouter();
let errors = ref(false);
let loading = ref(false);
const login = () => {
  loading.value = true;
  store.dispatch('login', user.value)
    .then((res) => {
      loading.value = false;
      router.push({ name: 'Dashboard' });
    }).catch((err) => {
      loading.value = false;
      errors.value = err.response.data;
    })
}

</script>

<style scoped></style>