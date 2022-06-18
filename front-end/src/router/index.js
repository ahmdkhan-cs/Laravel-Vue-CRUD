import {createRouter, createWebHashHistory} from 'vue-router';
import Login from "../views/Login.vue";
import Register from "../views/Register.vue";
import Articles from "../views/Articles.vue";
import ArticleView from "../views/ArticleView.vue";
import AuthLayout from "../components/AuthLayout.vue";
import DefaultLayout from "../components/DefaultLayout.vue";
import store from '../store';


const routes = [
    {
        path: '/',
        redirect: '/articles',
        component: DefaultLayout,
        meta: {requiresAuth: true},
        children: [
            {
                path: '/articles',
                name: 'Articles',
                component: Articles
            },
            {
                path: '/articles/create',
                name: 'ArticleCreate',
                component: ArticleView
            },
            {
                path: '/articles/:id',
                name: 'ArticleView',
                component: ArticleView
            }
        ]
    },
    {
        path: '/auth',
        redirect: '/login',
        name: 'Auth',
        component: AuthLayout,
        meta: {isGuest: true},
        children: [
            {
                path: '/login',
                name: 'Login',
                component: Login
            },
            {
                path: '/register',
                name: 'Register',
                component: Register
            },

        ]
    }

];


const router = createRouter({
    history: createWebHashHistory(),
    routes
});


router.beforeEach((to, from, next) => {
    if(to.meta.requiresAuth && !store.state.user.token){
        next({name: 'Login'});
    }else if(store.state.user.token && to.meta.isGuest){
        next({name: 'Articles'});
    }else{
        next();
    }
});


export default router;