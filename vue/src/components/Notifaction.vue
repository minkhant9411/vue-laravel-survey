<template>
    <div v-if="notifaction.show"
        class="rounded-md shadow-md fixed w-[300px] left-4 bottom-4 py-2 px-4 text-white animate-fade-in-down"
        :class="[notifaction.type == 'success' ? 'bg-emerald-500' : 'bg-red-500']">
        {{ notifaction.message }}</div>
</template>
<script setup>
//import

import { computed } from 'vue';
import { useStore } from 'vuex';



//defind
const store = useStore();
//props

//emits

//methods

//computed

const notifaction = computed(() => store.state.notifaction)

</script>
<style scoped></style>