<script setup>
import { RouterView } from "vue-router";
import DefaultNavbar from "/examples/navbars/NavbarDefault.vue";
import DefaultFooter from "/examples/footers/FooterDefault.vue";

</script>

<template>
  <DefaultNavbar :action="{
    route: 'javascript:;',
    label: 'Deposer une annonce',
    color: 'btn-white',
  }" transparent />
  
  <router-view />

  <DefaultFooter />

</template>
