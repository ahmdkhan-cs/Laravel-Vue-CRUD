<template>
  <div class="container p-3">
    <div v-if="errorMsg" class="alert alert-danger" role="alert">
      {{errorMsg}}
    </div>
    <div v-if="successMsg" class="alert alert-success" role="alert">
      {{successMsg}}
    </div>
    <router-link to="/articles/create" class="btn btn-primary float-end">Create Article</router-link>
    <table class="table table-striped">
      <thead>
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Description</th>
        <th>Active</th>
        <th>Actions</th>
      </tr>
      </thead>
      <tbody v-if="articlesLoading">
      <tr>
        <td colspan="5" class="text-center">
          <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </td>
      </tr>
      </tbody>
      <tbody v-else>
      <tr :key="article.id" v-for="article in articles">
        <td>{{article.id}}</td>
        <td>{{article.title}}</td>
        <td>{{article.description}}</td>
        <td>{{article.active === 1 ? 'Yes' : 'No'}}</td>
        <td>
          <div class="d-flex">
            <router-link :to="`/articles/${article.id}`" class="btn btn-primary btn-sm mx-1">Edit</router-link>
            <button @click="deleteArticle(article.id)" class="btn btn-danger btn-sm mx-1">Delete</button>
          </div>

        </td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import store from '../store';
import {computed, ref} from 'vue';

const articles = computed(() => store.state.articles.data);
const articlesLoading = computed(() => store.state.articles.loading);
store.dispatch('getArticles');

let errorMsg = ref('');
let successMsg = ref('');

function deleteArticle(id){
  if(confirm("Are you sure you want to delete this article? Operation cannot be undone.")){
    store.dispatch('deleteArticle', id).then(() => {
      errorMsg.value = '';
      successMsg.value = 'Article deleted';
      store.dispatch('getArticles');
    })
    .catch((err) => {
      errorMsg.value = err.response.data.error;
      successMsg.value = '';
    });
  }
}

</script>