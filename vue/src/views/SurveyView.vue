<template>
   <PageComponent>
      <template v-slot:header>
         <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold font-gray-900">
               {{ route.params.id ? model.title : "Create a Survey" }}
            </h1>
            <button v-if="route.params.id" type="button" @click='deleteSurvey'
               class="py-2 px-4 bg-red-500 hover:bg-red-600 text-white rounded-md">Delete
               Survey</button>
         </div>
      </template>
      <div v-if="surveyLoading" class="flex justify-center">
         loading.....
      </div>
      <form v-else @submit.prevent="saveSurvey" class="opacity-0 animate-fade-in-down">
         <div class="shadow sm:rounded-md sm:overflow-hidden">
            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
               <!-- Image -->
               <div>
                  <label class="block text-sm font-medium text-gray-700">
                     Image
                  </label>
                  <div class="mt-1 flex items-center">
                     <img :src="model.image_url" v-if="model.image_url" :alt="model.title"
                        class="w-64 h-48 object-cover" />
                     <span v-else
                        class="flex items-center justify-center h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                           stroke="currentColor" class="w-[80%] h-[80%] text-gray-300">
                           <path stroke-linecap="round" stroke-linejoin="round"
                              d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                     </span>
                     <button type="button"
                        class="relative overflow-hidden ml-5 bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <input type="file" @change="onImageChoose"
                           class="absolute left-0 top-0 right-0 bottom-0 opacity-0 cursor-pointer" />
                        Change
                     </button>
                  </div>
               </div>
               <!-- Image -->
               <!-- Title -->
               <div>
                  <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                  <input type="text" name="title" id="title" v-model="model.title" autocomplete="survey_title"
                     class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
               </div>
               <!--/ Title -->


               <!-- Description -->
               <div>
                  <label for="about" class="block text-sm font-medium text-gray-700">
                     Description
                  </label>
                  <div class="mt-1">
                     <textarea id="description" name="description" rows="3" v-model="model.description"
                        autocomplete="survey_description"
                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md"
                        placeholder="Describe your survey" />
                  </div>
               </div>
               <!-- Description -->
               <!-- Expire Date -->
               <div>
                  <label for="expire_date" class="block text-sm font-medium text-gray-700">Expire Date</label>
                  <input type="date" name="expire_date" id="expire_date" v-model="model.expire_date"
                     class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
               </div>
               <!--/ Expire Date -->

               <!-- Status -->
               <div class="flex items-start">
                  <div class="flex items-center h-5">
                     <input id="status" name="status" type="checkbox" v-model="model.status"
                        class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" />
                  </div>
                  <div class="ml-3 text-sm">
                     <label for="status" class="font-medium text-gray-700">Active</label>
                  </div>
               </div>
               <!--/ Status -->
            </div>
            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
               <h3 class="text-2xl font-semibold flex items-center justify-between">
                  Questions

                  <!-- Add new question -->
                  <button type="button" @click="addQuestion"
                     class="flex items-center text-sm py-1 px-4 rounded-sm text-white bg-gray-600 hover:bg-gray-700">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                           d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                           clip-rule="evenodd" />
                     </svg>
                     Add Question
                  </button>
                  <!--/ Add new question -->
               </h3>
               <div v-if="!model.questions.length" class="text-center text-gray-600">
                  You don't have any questions created
               </div>
               <div v-for="(question, index) in model.questions" :key="question.id">
                  <QuestionEditor :question="question" :index="index" @change="questionChange" @addQuestion="addQuestion"
                     @deleteQuestion="deleteQuestion" />
               </div>
            </div>
            <div class='px-4 py-3 bg-gray-50 text-right sm:px-6'>
               <button type="submit"
                  class=" bg-indigo-500 hover:bg-indigo-600 px-4 text-white font-bold rounded-md py-2">Save</button>
            </div>
         </div>

      </form>
   </PageComponent>
</template>
<script setup>
//import
import { v4 as uuidv4 } from "uuid";
import { computed, ref, watch } from "vue";
import PageComponent from "../components/PageComponent.vue";
import QuestionEditor from "../components/editor/QuestionEditor.vue";


import { useRoute, useRouter } from "vue-router";
import store from "../store";

//defind
const route = useRoute();
const router = useRouter();
let model = ref({
   title: "",
   status: false,
   description: null,
   image: null,
   image_url: null,
   expire_date: null,
   questions: [],
});

watch(() => store.state.currentSurvey.data,
   (newVal, oldVal) => {
      model.value = {
         ...JSON.parse(JSON.stringify(newVal)),
         status: newVal.status !== 'draft'
      };
   }
)
if (route.params.id) {
   store.dispatch('getSurvey', route.params.id).then((res) => {
      model.value = res.data
   })
}
//props

//emits

//methods
const addQuestion = (index) => {
   const newQuestion = {
      id: uuidv4(),
      type: 'text',
      question: "",
      data: {}
   }
   model.value.questions.splice(index, 0, newQuestion);
}

const deleteQuestion = (question) => {
   model.value.questions = model.value.questions.filter((q) => {
      return q !== question
   })
}
const questionChange = (question) => {

   if (question.data.options) {
      question.data.options = [...question.data.options];
   }
   model.value.questions = model.value.questions.map((q) => {
      if (q.id === question.id) {
         return JSON.parse(JSON.stringify(question))
      }
      return q;
   })

}
const saveSurvey = () => {
   store.dispatch("saveSurvey", model.value).then(({ data }) => {
      store.commit('notify', { type: 'success', message: 'Successful!' });
      router.push({
         name: "SurveyView",
         params: { id: data.id },
      })
   });
}

const onImageChoose = (e) => {
   const file = e.target.files[0];
   const reader = new FileReader();
   reader.onload = () => {
      model.value.image = reader.result
      model.value.image_url = reader.result
   }
   reader.readAsDataURL(file);

}


const deleteSurvey = () => {
   if (confirm('Are you sure to delete this survey?')) {
      store.dispatch('deleteSurvey', route.params.id).then(() => {
         router.push({ name: 'Surveys' })
      })
   }
}
//computed

const surveyLoading = computed(() => store.state.currentSurvey.loading)
</script>
<style scoped></style>
