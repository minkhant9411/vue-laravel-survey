<template>
    <div class='py-5 px-8'>
        <div class='flex justify-center items-center' v-if="loading">
            <svg class="animate-spin -ml-1 mr-3 h-10 w-10 text-gray-600 font-weight-normal"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
        </div>
        <form v-else @submit.prevent='submitSurvey' class='container mx-auto'>
            <div class='grid grid-cols-6 items-center'>
                <div class='mr-4'>
                    <img :src='survey.image_url' alt='survey_image'>
                </div>
                <div class='col-span-5'>
                    <h1 class='text-3xl mb-3'>{{ survey.title }}</h1>
                    <p class='text-gray-500 text-sm'>{{ survey.description }}</p>
                </div>
            </div>
            <div v-if="surveyFinished" class="py-8 px-6 bg-emerald-400 text-white w-[600px] mx-auto">
                <div class='text-xl mb-3 font-semibold'>
                    Thank you for participate in this survey.
                    <button @click='submitAnotherResponse' type='button'
                        class='bg-indigo-500 px-4 py-2 hover:bg-indigo-600 border border-transparent shadow-sm text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600'>Submit
                        another response</button>
                </div>
            </div>
            <div v-else>
                <hr class="my-3" />
                <div v-for="(question, i) in survey.questions" :key="question.id">
                    <QuestionViewer v-model="answers[question.id]" :question='question' :index='i' />
                </div>
                <button type='submit'
                    class='bg-indigo-500 px-4 py-2 hover:bg-indigo-600 border border-transparent shadow-sm text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 text-white'>Submit</button>
            </div>
        </form>
    </div>
</template>
<script setup>
//import
import { computed, ref } from 'vue';
import { useRoute } from 'vue-router'
import { useStore } from 'vuex';
import QuestionViewer from "./viewer/QuestionViewer.vue"
//defind
const route = useRoute();
const store = useStore();
const loading = computed(() => store.state.currentSurvey.loading);
const survey = computed(() => store.state.currentSurvey.data);
const surveyFinished = ref(false);
const answers = ref({})

//vuex 
store.dispatch('getSurveyBySlug', route.params.slug);

//props

//emits

//methods
const submitSurvey = () => {
    store.dispatch('saveSurveyAnswer', {
        survey_id: survey.value.id,
        answers: answers.value
    }).then((res) => {
        if (res.status == 201) {
            surveyFinished.value = true;
        }
    })
}
const submitAnotherResponse = () => {
    answers.value = {}
    surveyFinished.value = false
}
//computed

</script>
<style scoped></style>