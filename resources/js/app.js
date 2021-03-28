window.Vue = require('vue')
require('./bootstrap');
require('../../public/libraries/jquery-bracket/dist/jquery.bracket.js');
require('../../public/libraries/dropzone/dist/dropzone.js');
require('../../node_modules/gasparesganga-jquery-loading-overlay/dist/loadingoverlay.min.js');
// import VueSweetalert2 from 'vue-sweetalert2';
// Vue.use(VueSweetalert2,options);

import store from './store/index';

window.Swal = require('sweetalert2');
const options = {
    timer:1500,
    showConfirmButton:false,
    showCancelButton:false
};


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component('auth-container', require('./components/auth/AuthContainer.vue').default);

Vue.component('form-login', require('./components/auth/FormLogin.vue').default);
Vue.component('form-register', require('./components/auth/FormRegister.vue').default);

Vue.component('cards-profile', require('./components/profiles/CardsProfile.vue').default);
Vue.component('cards-lists', require('./components/lists/CardsLists.vue').default);
Vue.component('form-poll', require('./components/polls/FormPoll.vue').default);
Vue.component('show-poll', require('./components/polls/ShowPoll.vue').default);
Vue.component('chart-results', require('./components/polls/ChartResults.vue').default);

Vue.component('form-tournament', require('./components/tournaments/FormTournament.vue').default);
Vue.component('edit-tournament', require('./components/tournaments/EditTournament.vue').default);


Vue.component('tournament', require('./components/tournaments/Tournament.vue').default);
Vue.component('participant-create', require('./components/tournaments/ParticipantCreate.vue').default);
Vue.component('participant-list', require('./components/tournaments/ParticipantList.vue').default);
Vue.component('tournament-preview',require('./components/tournaments/TournamentPreview.vue').default);
Vue.component('modal-form-image', require('./components/images/ModalFormImage.vue').default);
Vue.component('image-list', require('./components/images/ImageList.vue').default);
Vue.component('section-upload-image', require('./components/images/SectionUploadImage.vue').default);







/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    store,

});
