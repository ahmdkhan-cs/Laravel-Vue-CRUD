<template>
  <div class="vh-100">
    <nav class="navbar navbar-expand-lg bg-light">
      <div class="container">
        <router-link to="/" class="navbar-brand">Task Work</router-link>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <router-link to="/articles" class="nav-link active">Articles</router-link>
            </li>
          </ul>
          <button @click="logout" class="btn btn-primary">Logout</button>
        </div>
      </div>
    </nav>
    <router-view></router-view>
  </div>


</template>

<script>
import { useStore } from 'vuex'
import { computed } from 'vue'
import { useRouter } from 'vue-router'

export default {
  setup(){
    const store = useStore();
    const router = useRouter();

    function logout() {
      store.dispatch('logout')
        .then(() => {
          router.push({
            name: 'Login'
          });
        });
    }
    return {
      user: computed(() => store.state.user.data),
      logout
    };
  }
}
</script>