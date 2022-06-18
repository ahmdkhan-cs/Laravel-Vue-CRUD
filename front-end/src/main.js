import "bootstrap/dist/css/bootstrap.min.css";
import { createApp } from 'vue';
import store from './store';
import router from './router';
import App from './App.vue';

createApp(App)
    .use(router)
    .use(store)
    .mount('#app');

import "bootstrap/dist/js/bootstrap.js";