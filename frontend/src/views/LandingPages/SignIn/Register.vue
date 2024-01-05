<script setup>
import { onMounted } from "vue";

// example components
import DefaultNavbar from "@/examples/navbars/NavbarDefault.vue";
import Alert from "@/views/LandingPages/Signin/Alert.vue";
import Header from "@/examples/Header.vue";

//Vue Material Kit 2 components
import MaterialInput from "@/components/MaterialInput.vue";
import MaterialSwitch from "@/components/MaterialSwitch.vue";
import MaterialButton from "@/components/MaterialButton.vue";

// material-input
import setMaterialInput from "@/assets/js/material-input";
onMounted(() => {
  setMaterialInput();
});


</script>
<template>
  <DefaultNavbar transparent />
  <Header>
    <div
      class="page-header align-items-start min-vh-100"
      :style="{
        backgroundImage:
          'url(https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80)'
      }"
      loading="lazy"
    >
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container my-auto">
        <div class="row">
          <div class="col-lg-4 col-md-8 col-12 mx-auto">
            <div class="card z-index-0 fadeIn3 fadeInBottom">
              <div
                class="card-header p-0 position-relative mt-n4 mx-3 z-index-2"
              >
                <div
                  class="bg-gradient-success shadow-success border-radius-lg py-3 pe-1"
                >
                  <h4
                    class="text-white font-weight-bolder text-center mt-2 mb-0"
                  >
                    S'inscrire
                  </h4>
                  <div class="row mt-3">
                    <!-- <div class="col-2 text-center ms-auto">
                      <a class="btn btn-link px-3" href="javascript:;">
                        <i class="fa fa-facebook text-white text-lg"></i>
                      </a>
                    </div>
                    <div class="col-2 text-center px-1">
                      <a class="btn btn-link px-3" href="javascript:;">
                        <i class="fa fa-github text-white text-lg"></i>
                      </a>
                    </div>
                    <div class="col-2 text-center me-auto">
                      <a class="btn btn-link px-3" href="javascript:;">
                        <i class="fa fa-google text-white text-lg"></i>
                      </a>
                    </div> -->
                  </div>
                </div>
              </div>
              <div class="card-body">
                <form role="form" class="text-start" method="post" action="/home/sign_up" @submit.prevent="register()">
                  <MaterialInput
                    v-model="email"
                    id="email"
                    class="input-group-outline my-3"
                    :label="{ text: 'Email', class: 'form-label' }"
                    type="email"
                  />
                  <MaterialInput
                    v-model="password"
                    id="password"
                    class="input-group-outline mb-3"
                    :label="{ text: 'Password', class: 'form-label' }"
                    type="password"
                  />
                  <MaterialInput
                    v-model="name"
                    id="name"
                    class="input-group-outline my-3"
                    :label="{ text: 'Nom', class: 'form-label' }"
                    type="text"
                  />
                  <MaterialInput
                    v-model="address"
                    id="address"
                    class="input-group-outline my-3"
                    :label="{ text: 'Address*', class: 'form-label' }"
                    type="text"
                  />
                  <MaterialInput
                    v-model="phone"
                    id="phone"
                    class="input-group-outline my-3"
                    :label="{ text: 'Telephone', class: 'form-label' }"
                    type="text"
                  />
                  <Alert v-if="msg" :msg="msg" :classAlert="classAlert"></Alert>
                  <div class="text-center">
                    <MaterialButton
                      class="my-4 mb-2"
                      variant="gradient"
                      type="submit"
                      color="success"
                      fullWidth
                      >S'inscrire</MaterialButton
                    >
                  </div>
                  <p class="mt-4 text-sm text-center">
                    Vous avez déjà un compte?
                    <RouterLink
                        :to="{ name: 'signin-basic' }"
                        class="text-success text-gradient font-weight-bold"
                      >
                      Se connecter
                      </RouterLink>
                  </p>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer class="footer position-absolute bottom-2 py-2 w-100">
        <div class="container">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-12 col-md-6 my-auto">
              <div
                class="copyright text-center text-sm text-white text-lg-start"
              >
                © {{ new Date().getFullYear() }},
                <a
                  href=""
                  class="font-weight-bold text-white"
                  target="_blank"
                  >Lebonomar</a
                >
                Tout droit reservé
              </div>
            </div>
            <div class="col-12 col-md-6">
              <ul
                class="nav nav-footer justify-content-center justify-content-lg-end"
              >
                <li class="nav-item">
                  <a
                    href=""
                    class="nav-link text-white"
                    target="_blank"
                    >Accueil</a
                  >
                </li>
                <li class="nav-item">
                  <a
                    href=""
                    class="nav-link text-white"
                    target="_blank"
                    >Apropos</a
                  >
                </li>
                <li class="nav-item">
                  <a
                    href=""
                    class="nav-link text-white"
                    target="_blank"
                    >Nous contacter</a
                  >
                </li>
              </ul>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </Header>
</template>
<script>
import axios from 'axios'
export default {
  data() {
    return {
        email: '',
        password:'',
        name:'',
        address:'',
        phone:'',
        msg: null,
        classAlert: null
    };
  },
  methods: {
    register(){
        const form = new FormData()
        form.append('email', this.email)
        form.append('password', this.password)
        form.append('name', this.name)
        form.append('address', this.address)
        form.append('phone', this.phone)

        this.$guest.post('/home/sign_up', form)
        .then(() =>{
            this.msg = "Inscription Reussie"
            this.classAlert ="succes";
        })
        .catch(err =>{
            this.msg = err.response.data.message.console.error();
            // this.msg = "Inscription erreur"
            this.classAlert ="danger";

        })
    }
  },
  mounted() {
    axios
      .put('https://jsonplaceholder.typicode.com/posts/1', {
        id: '1',
        userId: '1',
        title:  'Article title',
        body:   'Article body content'
      })
      .then((response) => console.log(response))
  }
}
</script>
