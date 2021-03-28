import Vue from "vue";
import Vuex from "vuex";
import {alertMutations, imageMutations, loaderMutations,previewMutation,toastMutations, tournamentMutations} from "./mutations";
import {imageActions, tournamentActions} from "./actions";
import {tournamentGetters} from './getters'
Vue.use(Vuex);
//ejecutar funciones desde los componenetes $store.state.name

const store = new Vuex.Store({
    // strict:true,
    state: {
        images:[],
        preview:false,
        image_selected:null,
        tournament:{
            id:null,
            title:null,
            participants:[]
        },
        new_participant:{
            id:null,
            name:null,
            image_url:null,
            order:null
        },
        participant_id:null
    },
    mutations: Object.assign({},loaderMutations,alertMutations,toastMutations,imageMutations,previewMutation,tournamentMutations),
    actions: Object.assign({},imageActions,tournamentActions),
    getters: Object.assign({},tournamentGetters),


});

export default store;
