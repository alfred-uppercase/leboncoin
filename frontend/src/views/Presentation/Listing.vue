<template>
  <div style="padding-top: 90px;">
    <h1>Search Results</h1>
    <ul>
      <li v-for="result in results" :key="result.id">
        {{ result.name }}
        <!-- Display other result details as needed -->
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const results = ref([]);
</script>
