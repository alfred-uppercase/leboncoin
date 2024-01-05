<script setup>
// example component
import { ref, onMounted } from "vue";
import axios from 'axios';


import HorizontalTeamCard from "@/examples/cards/teamCards/HorizontalTeamCard.vue";

// images
import emma from "@/assets/img/team-5.jpg";
import william from "@/assets/img/bruce-mars.jpg";
import ivana from "@/assets/img/ivana-squares.jpg";
import marquez from "@/assets/img/ivana-square.jpg";
const categories  = ref([]);

onMounted(async () => {
  try {
    const response = await axios.get('http://localhost/api/get_categories');
    console.log('Response from get_categories:', response.data);
    categories.value = response.data;
  } catch (error) {
    console.error('Error fetching categories:', error);
  }

});


</script>

<template>
  <section class="pb-5 position-relative mx-n3">
    <div class="container">
      <div class="related-articles-text"><div class="user-content" dir="auto"><h2 class="display-5">Nos principales catégories</h2>
<p class="lead">Trouvez ce qu'il vous faut chez nous</p>
</div></div>
      <div class="related-articles-content">
        <div v-for="category in categories" :key="category.id" :value="category.id" class="article">
          <div class="article-container"><img
            :src="`/uploads/category_thumbnails/${category.thumbnail}`"
              loading="lazy" class="article-img">
              <div class="article-text">
                <h3 class="heading" dir="auto">{{ category.name }}</h3><a class="link stretched-link"
                :href="`/search?search_string=&selected_city_id=&selected_category_id=${category.id}`"></a>
            </div>
          </div>
      </div>
    </div>

  </div>
</section></template>
<style>
.related-articles-content {
  flex-direction: row;
    flex-wrap: wrap;
    display: flex;
}
.related-articles-content .article{
  width: 25%;
  padding: 0 20px;
}
.article-container{
  max-height: 100%;
  height: 100%;
}
.article-container img{
  width: 100%;
  border-radius: 20px;
}
</style>