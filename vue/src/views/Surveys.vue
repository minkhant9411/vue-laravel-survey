<template>
  <PageComponent>
    <template v-slot:header>
      <div class='flex items-center justify-between'>
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">
          Surveys
        </h1>
        <router-link :to="{ name: 'SurveyCreate' }"
          class="py-2 px-3 text-white bg-emerald-500 rounded-md hover:bg-emerald-600">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-4 h-4 inline-block -mt-1">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
          </svg> Add new
          Survey</router-link>
      </div>
    </template>
    <div v-if="surveys.loading" class="flex justify-center">
      <svg class="animate-spin -ml-1 mr-3 h-10 w-10 text-gray-600 font-weight-normal" xmlns="http://www.w3.org/2000/svg"
        fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor"
          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
        </path>
      </svg>
    </div>
    <div v-else class="grid grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-3">
      <SurveyListItem :survey='survey' @delete='deleteSurvey' v-for="(survey, i) in  surveys.data" :key="survey.id"
        class="opacity-0 animate-fade-in-down" :style='{ animationDelay: `${i * 0.1}s` }' />
    </div>
    <div class="flex justify-center" v-if="!surveys.loading">
      <nav class="realative z-0 inline-flex justify-center rounded-md shadow-sm" aria-label="Pagination">
        <a href="#" @click.prevent='getForPage(link)'
          class="relative inline-flex items-center px-4 py-2 mt-3 border text-sm font-medium whitespace-nowrap" :class="[
            link.active
              ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600'
              : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
            i === 0 ? 'rounded-l-md bg-gray-100 text-gray-700' : '',
            i === surveys.links.length - 1 ? 'rounded-r-md' : '',
          ]" v-for='(link, i) of surveys.links' :key='i' :disabled='!link.url' v-html="link.label"></a>
      </nav>
    </div>
  </PageComponent>
</template>
<script setup>
//import
import { computed, watch } from 'vue';
import PageComponent from '../components/PageComponent.vue';
import SurveyListItem from '../components/SurveyListItem.vue';
import store from '../store';
//defind

//props

//emits

//methods
const getForPage = (link) => {
  if (!link.url || link.active) {
    return;
  }
  store.dispatch('getSurveys', { url: link.url })
}
store.dispatch('getSurveys').then(() => { });
const deleteSurvey = (survey) => {
  if (confirm('Are you sure? You can\'t recover')) {
    store.dispatch('deleteSurvey', survey.id).then(() => store.dispatch('getSurveys'))
  }
}
// watch(() => store.state.surveys.data, (new, old)=> {
//   surveys = new
// })
//computed

const surveys = computed(() => {
  return store.state.surveys;
})


</script>
<style scoped></style>