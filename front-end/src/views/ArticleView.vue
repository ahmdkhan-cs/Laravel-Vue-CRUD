<template>
  <div class="container p-3">
    <div v-if="errorMsg" class="alert alert-danger" role="alert">
      {{errorMsg}}
    </div>
    <div v-if="successMsg" class="alert alert-success" role="alert">
      {{successMsg}}
    </div>
    <div v-if="articleLoading" class="text-center">
      <div  class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>

    <form v-else @submit.prevent="saveArticle">
      <div class="mb-3">
        <label for="inputTitle" class="form-label">Title</label>
        <input type="text" class="form-control" id="inputTitle" name="inputTitle" v-model="model.title">
      </div>
      <div class="mb-3">
        <label for="inputDescription" class="form-label">Description</label>
        <textarea class="form-control" id="inputDescription" name="inputDescription" v-model="model.description">

        </textarea>
      </div>
      <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="inputActive" name="inputActive" v-model="model.active">
        <label class="form-check-label" for="inputActive">Active</label>
      </div>
      <button type="submit" class="btn btn-primary">Save</button>
    </form>
  </div>
</template>

<script setup>
import store from '../store';
import { ref, watch, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const router = useRouter();
const route = useRoute();
const articleLoading = computed(() => store.state.currentArticle.loading);

let model = ref({
  title: "",
  description: null,
  active: false
});

let errorMsg = ref('');
let successMsg = ref('');

watch(
    () => store.state.currentArticle.data,
    (newVal) => {
      model.value = {
        ...JSON.parse(JSON.stringify(newVal)),
        active: newVal.active === 1
      }
    }
);

if(route.params.id){
  store.dispatch('getArticle', route.params.id);
}

function saveArticle(){
  store.dispatch('saveArticle', model.value).then(({data}) => {
    successMsg.value = 'Article saved';
    errorMsg.value = '';
    router.push({
      name: 'ArticleView',
      params: {
        id: data.data.id
      }
    })
    .catch((err) => {
      errorMsg.value = err.response.data.error;
      successMsg.value = '';
    });
  });
}

</script>