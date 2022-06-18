<template>
  <div>
    <h3 class="text-center">Register</h3>
    <form @submit="register">
      <div class="mb-3">
        <label for="inputName" class="form-label">Name</label>
        <input type="text" class="form-control" id="inputName" name="inputName" v-model="user.name">
      </div>
      <div class="mb-3">
        <label for="inputEmail" class="form-label">Email address</label>
        <input type="email" class="form-control" id="inputEmail" name="inputEmail" v-model="user.email">
      </div>
      <div class="mb-3">
        <label for="inputPassword" class="form-label">Password</label>
        <input type="password" class="form-control" id="inputPassword" name="inputPassword" v-model="user.password">
      </div>
      <div class="mb-3">
        <label for="inputPasswordConfirmation" class="form-label">Password</label>
        <input type="password" class="form-control" id="inputPasswordConfirmation" name="inputPasswordConfirmation" v-model="user.password_confirmation">
      </div>
      <button type="submit" class="btn btn-primary">Register</button>
      <router-link to="/login" class="float-end">Already have an account?</router-link>
    </form>
  </div>
</template>


<script setup>
import store from '../store';
import {useRouter} from 'vue-router';

const router = useRouter();

const user = {
  name: '',
  email: '',
  password: '',
  password_confirmation: ''
};

function register(ev){
  ev.preventDefault();
  store.dispatch('register', user)
      .then(() => {
        router.push({
          name: 'Articles'
        });
      });
}
</script>