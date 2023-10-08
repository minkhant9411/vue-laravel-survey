<template>
    <header class="bg-white shadow">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
          
            <slot name="header"/>
        </div>
      </header>
      <main>
        <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
            <slot/>
        </div>
      </main>
</template>
<script setup>
//import
 
//defind
 
//props
const props = defineProps(['title']);
//emits
 
//methods
 
//computed
 
</script>
<style scoped></style>