import {createStore} from "vuex";
import axiosClient from '../axios';

const store = createStore({
    state: {
        user: {
            data: {},
            token: sessionStorage.getItem('TOKEN'),
        },
        currentArticle: {
            loading: false,
            data: {

            }
        },
        articles: {
            loading: false,
            data: []
        },
    },
    getters: {},
    actions: {
        getArticle({commit}, id) {
            commit('setCurrentArticleLoading', true);
            axiosClient.get(`/article/${id}`)
                .then((res) => {
                    commit("setCurrentArticle", res.data);
                    commit('setCurrentArticleLoading', false);
                    return res;
                })
                .catch((err) => {
                    commit('setCurrentArticleLoading', false);
                    throw err;
                });
        },
        saveArticle({commit}, article){
            let response;
            if(article.id){
                response = axiosClient.put(`/article/${article.id}`, article)
                    .then((res) => {
                        commit('setCurrentArticle', res.data)
                        return res
                    });
            }else{
                response = axiosClient.post('/article', article)
                    .then((res) => {
                        commit('setCurrentArticle', res.data)
                        return res
                    });
            }
            return response;
        },
        // eslint-disable-next-line
        deleteArticle({}, id){
            return axiosClient.delete(`/article/${id}`);
        },
        getArticles({commit}){
            commit('setArticlesLoading', true);
            return axiosClient.get('/article').then((res) => {
                commit('setArticlesLoading', false);
                commit('setArticles', res.data);
                return res.data;
            });
        },
        register({commit}, user) {
            return axiosClient.post('/register', user)
                .then(({data}) => {
                    commit('setUser', data)
                    return data
                });
        },
        login({commit}, user) {
            return axiosClient.post('/login', user)
                .then(({data}) => {
                    commit('setUser', data)
                    return data
                });
        },
        logout({commit}) {
            return axiosClient.post('/logout')
                .then((response) => {
                    commit('logout')
                    return response
                });
        }
    },
    mutations: {
        setCurrentArticleLoading: (state, loading) => {
            state.currentArticle.loading = loading;
        },
        setCurrentArticle: (state, article) => {
            state.currentArticle.data = article.data;
        },
        setArticlesLoading: (state, loading) => {
            state.articles.loading = loading;
        },
        setArticles: (state, articles) => {
            state.articles.data = articles.data;
        },
        logout: (state) => {
            state.user.data = {};
            state.user.token = null;
            sessionStorage.removeItem('TOKEN');
        },
        setUser: (state, userData) => {
            state.user.token = userData.token;
            state.user.data = userData.user;
            sessionStorage.setItem('TOKEN', userData.token);
        }
    },
    modules: {}
});


export default store;