<template>
  <div>
    <div v-if="errorMsg" class="alert alert-danger" role="alert">
      {{errorMsg}}
    </div>

    <h3 class="text-center">Login</h3>
    <form @submit="login">
      <div class="mb-3">
        <label for="inputEmail" class="form-label">Email address</label>
        <input type="email" class="form-control" id="inputEmail" name="inputEmail" v-model="user.email">
      </div>
      <div class="mb-3">
        <label for="inputPassword" class="form-label">Password</label>
        <input type="password" class="form-control" id="inputPassword" name="inputPassword" v-model="user.password">
      </div>
      <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="inputRemember" name="inputRemember" v-model="user.remember">
        <label class="form-check-label" for="inputRemember">Remember me</label>
      </div>
      <button type="submit" class="btn btn-primary">Login</button>
      <router-link to="/register" class="float-end">Don't have an account?</router-link>
    </form>
  </div>


</template>


<script setup>
import store from '../store';
import {useRouter} from 'vue-router';
import {ref} from 'vue';

const router = useRouter();
const user = {
  email: '',
  password: '',
  remember: false
};
let errorMsg = ref('');

function login(ev){
  ev.preventDefault()
  store.dispatch('login', user)
      .then(() => {
        router.push({
          name: 'Articles'
        })
      })
      .catch((err) => {
        errorMsg.value = err.response.data.error
      });
}
</script>