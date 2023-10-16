<template>
  <PageComponent>
    <template v-slot:header>
      <h1 class="text-3xl font-bold tracking-tight text-gray-900">
        Dashboard
      </h1>

    </template>
    <div v-if="loading" class="flex justify-center">
      <svg class="animate-spin -ml-1 mr-3 h-10 w-10 text-gray-600 font-weight-normal" xmlns="http://www.w3.org/2000/svg"
        fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor"
          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
        </path>
      </svg>
    </div>
    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 text-gray-700">
      <div class='animate-fade-in-down bg-white shadow-md p-3 flex text-center flex-col order-1 lg:order-2'
        style="animation-delay:0.1s;">
        <h3 class='text-2xl font-semibold'>Total Surveys</h3>
        <div class=" text-8xl flex items-center justify-center flex-col">{{ data.totalSurveys }}</div>
      </div>
      <div class='animate-fade-in-down bg-white shadow-md p-3 flex text-center flex-col order-2 lg:order-4'
        style="animation-delay:0.2s;">
        <h3 class='text-2xl font-semibold'>Total Answers</h3>
        <div class=" text-8xl flex items-center justify-center flex-col">{{ data.totalAnswers }}</div>
      </div>
      <div class='animate-fade-in-down row-span-2 p-3 bg-white shadow-md order-3 lg:order-1'>
        <h3 class='text-2xl font-semibold'>Latest Survey</h3>
        <img :src='data.latestSurvey.image_url' class='w-[240px] mx-auto'>
        <h3 class='font-bold text-xl my-3'>{{ data.latestSurvey.title }}</h3>
        <div class='flex justify-between text-sm mb-3'>
          <div>Create Date:</div>
          <div>{{ data.latestSurvey.created_at }}</div>
        </div>
        <div class='flex justify-between text-sm mb-3'>
          <div>Expire Date:</div>
          <div>{{ data.latestSurvey.expire_date }}</div>
        </div>
        <div class='flex justify-between text-sm mb-3'>
          <div>Status:</div>
          <div>{{ data.latestSurvey.status }}</div>
        </div>
        <div class='flex justify-between text-sm mb-3'>
          <div>Question:</div>
          <div>{{ data.latestSurvey.questions }}</div>
        </div>
        <div class='flex justify-between text-sm mb-3'>
          <div>Answer:</div>
          <div>{{ data.latestSurvey.answers }}</div>
        </div>
        <div class='flex justify-between mb-3'>
          <router-link :to="{ name: 'SurveyView', params: { id: data.latestSurvey.id } }"
            class="py-2 px-3 hover:text-white text-indigo-500 border border-transparent hover:bg-indigo-500 rounded-md transition-colors flex text-sm justify-center items-center ">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="w-5 h-5 mr-1">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
            </svg>
            Edit Survey</router-link>
          <button
            class="py-2 px-3 hover:text-white text-indigo-500 border border-transparent hover:bg-indigo-500 rounded-md transition-colors flex text-sm justify-center items-center "><svg
              xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
              class="w-5 h-5 mr-1">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>View
            Answer</button>
        </div>
      </div>
      <div class='animate-fade-in-down row-span-2 p-3 bg-white shadow-md order-4 lg:order-3'
        style="animation-delay:0.3s;">
        <div class='flex justify-between items-center mb-3 px-2'>


          <h3 class='text-2xl font-semibold'>Latest Answers</h3>
          <a href=' javascript:void(0)' class="text-sm text-blue-500 hover:decoration-blue-500">View all</a>
        </div>
        <a href='#' v-for="answer in data.latestAnswers" :key="answer.id" class='block p-2 hover:bg-gray-100/90'>
          <div class="font-semibold">{{ answer.survey.title }}</div>
          <small>
            Answer Made at:
            <i class="font-semibold">{{ answer.end_date }}</i>
          </small>
        </a>
      </div>
    </div>
  </PageComponent>
</template>
<script setup>
//import
import { computed } from 'vue';
import { useStore } from 'vuex';
import axiosClient from '../axios';
import PageComponent from '../components/PageComponent.vue';

//defind
const store = useStore()
//props

//emits

//methods

//computed
let loading = computed(() => store.state.dashboard.loading)
let data = computed(() => store.state.dashboard.data)



store.dispatch('getDashboardData');


</script>
<style scoped></style>