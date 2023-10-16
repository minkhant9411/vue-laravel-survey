<template>
    <fieldset class="mb-4">
        <div>
            <legend class="text-base font-medium text-gray-900">
                {{ index + 1 }}. {{ question.question }}
            </legend>
            <p class='text-sm text-gray-500'>{{ question.description }}</p>
        </div>
        <div class='mt-3'>
            <div v-if="question.type == 'select'">
                <select :value='modelValue' @change="emits('update:modelValue', $event.target.value)"
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value=''>Select one</option>
                    <option v-for="option in question.data.options" :value='option.text' :key="option.uuid">{{ option.text
                    }}
                    </option>
                </select>
            </div>
            <div v-else-if="question.type == 'radio'">
                <div v-for="(option) in question.data.options" :key="option.uuid" class="flex item-center">
                    <input type='radio' :name="'question' + question.id" :id='option.uuid' :value="option.text"
                        @change="emits('update:modelValue', $event.target.value)"
                        class="h-4 w-4 focus:ring-indigo-500 border-gray-300 text-indigo-600">
                    <label :for='option.uuid' class="ml-3 text-sm block font-medium text-gray-700">
                        {{ option.text }}
                    </label>
                </div>
            </div>
            <div v-else-if="question.type == 'checkbox'">
                <div v-for="(option) in question.data.options" :key="option.uuid" class="flex item-center">
                    <input type='checkbox' :id='option.uuid' @change="onCheckboxChage" v-model="model[option.text]"
                        class="h-4 w-4 focus:ring-indigo-500 border-gray-300 text-indigo-600 rounded-sm">
                    <label :for='option.uuid' class="ml-3 text-sm block font-medium text-gray-700">
                        {{ option.text }}
                    </label>
                </div>
            </div>
            <div v-else-if="question.type == 'text'">
                <input type='text' :value='modelValue' @change="emits('update:modelValue', $event.target.value)"
                    class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div v-else-if="question.type == 'textarea'">
                <textarea rows='5' :value='modelValue' @change="emits('update:modelValue', $event.target.value)"
                    class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
            </div>
        </div>
    </fieldset>
    <hr class='mb-4' />
</template>
<script setup>
//import

import { ref } from 'vue';

//defind
let model;
//props
const { question, index, modelValue } = defineProps({
    question: Object,
    index: Number,
    modelValue: [String, Array]
})
//emits
const emits = defineEmits(['update:modelValue'])
//methods
if (question.type == 'checkbox') {
    model = ref({});
}

const onCheckboxChage = () => {
    const selectedOptions = [];
    for (let text in model.value) {
        if (model.value[text]) {
            selectedOptions.push(text);
        }
        emits('update:modelValue', selectedOptions);
    }
}
//computed

</script>
<style scoped></style>