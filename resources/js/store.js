import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);
export const store = new Vuex.Store({
    state: {
        comments: {},
    },
    mutations: {
        initializeComments(state, payLoad) {
            state.comments = payLoad;
            if (typeof (state.comments['root']) === 'undefined') {
                state.comments['root'] = [];
            }
        },
        updateComments(state, payLoad) {
            for (var key in payLoad) {
                // if (typeof(state.comments[key]) === 'undefined' || state.comments[key] != payLoad[key]) {
                    state.comments = payLoad;
                // }
            }
        }
    }
});