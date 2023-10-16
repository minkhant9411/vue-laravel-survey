
<template>
  <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
      <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
        alt="Your Company" />
      <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">
        Register for free
      </h2>
    </div>
    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <form class="space-y-6" @submit.prevent='register'>
        <div>
          <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
          <div class="mt-2">
            <input id="email" v-model="user.email" name="email" type="email" autocomplete="email" required
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
          </div>
        </div>

        <div>
          <div class="flex items-center justify-between">
            <label for="fullname" class="block text-sm font-medium leading-6 text-gray-900">Full name</label>
            <div class="text-sm">
            </div>
          </div>
          <div class="mt-2">
            <input id="fullname" v-model="user.name" name="name" type="text" autocomplete="name" required
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
          </div>
        </div>

        <div>
          <div class="flex items-center justify-between">
            <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
            <div class="text-sm">
            </div>
          </div>
          <div class="mt-2">
            <input id="password" name="password" v-model="user.password" type="password" autocomplete="current-password"
              required
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
          </div>
        </div>

        <div>
          <div class="flex items-center justify-between">
            <label for="confirm-password" class="block text-sm font-medium leading-6 text-gray-900">Confirm
              password</label>
            <div class="text-sm">
            </div>
          </div>
          <div class="mt-2">
            <input id="confirm-password" name="confirm-password" v-model="user.password_confirmation" type="password"
              autocomplete="confirm-password" required
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
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
            </svg> Sign up
          </button>
        </div>
      </form>

      <p class="mt-10 text-center text-sm text-gray-500">
        Already Account?
        {{ " " }}
        <router-link :to="{ name: 'Login' }" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Login
          Your
          Account</router-link>
      </p>
      <div class=" bg-red-500 p-2 m-2 mt-5 rounded-md text-sm max-w-[360px] text-white lg:absolute bottom-0 right-0
      " v-if="Object.keys(errors).length">
        <div v-for="(field, i) of Object.keys(errors)" :key='i'>
          <div v-for="(error, ind) of errors[field] || []" :key='ind'>
            *{{ error }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import store from '../store'

let router = useRouter();
const user = {
  name: '',
  email: '',
  password: '',
  password_confirmation: ''
}
let loading = ref(false);
let errors = ref({});
const register = () => {
  loading.value = true;
  store.dispatch('register', user)
    .then((e) => {
      loading.value = false;
      router.push({ name: 'Dashboard' })
    }).catch((err) => {
      loading.value = false;
      errors.value = err.response.data.errors;
    });
} 
</script>

<style scoped></style>