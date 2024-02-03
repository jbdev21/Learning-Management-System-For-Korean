window._ = require('lodash');
window.axios = require('axios');
window.moment = require('moment');

var ImageEditor = require('tui-image-editor');

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
    require('bootstrap');
    require('./jquery.crossword.js')
    // require('./wordfind.js')
    // require('./wordfindgame.js')
} catch (e) {
    console.log(e)
}

global.$ = global.jQuery = require('jquery');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}


import Echo from 'laravel-echo'

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'ad7cdc097d309d7b1621',
    cluster: 'ap3',
    encrypted: true
});


window.Vue = require('vue');

import CKEditor from '@ckeditor/ckeditor5-vue';
import VueSweetalert2 from 'vue-sweetalert2';
import VueCountdown from '@chenfengyuan/vue-countdown';
import 'sweetalert2/dist/sweetalert2.min.css';
import VueChatScroll from 'vue-chat-scroll'

Vue.component('component-comment', require('./components/Ui/ComponentBookComment/MainComponent.vue').default);
Vue.component('diary-component', require('./components/Student/Diary/MainComponent.vue').default);
Vue.component('audiorecorder-component', require('./components/Ui/AudioRecorder.vue').default);
Vue.component('notification-component', require('./components/Student/Notification/MainComponent.vue').default);
Vue.component('question-component', require('./components/Student/Quiz/QuestionComponent.vue').default);
Vue.component('question-timer', require('./components/Student/Quiz/TimerComponent.vue').default);
Vue.component('comment-component', require('./components/Ui/Comment/MainComponent.vue').default);
Vue.component(VueCountdown.name, VueCountdown);

Vue.use(VueChatScroll)
Vue.use(CKEditor);
Vue.use(VueSweetalert2);

const app = new Vue({
    el: '#app'
});


$(document).ready(function(){

    
    $('#delete-notification').click(function(){
        $('#notification-submit-type').val('delete');
        $('#notification-form').submit();
    });

    $('#mark-notification').click(function(){
        $('#notification-submit-type').val('mark');
        $('#notification-form').submit();
    });





    $('.delete-writing').click(function(){
        if( confirm('Are you sure to delete?')){
            var uri = $(this).data('uri')
            axios.delete(uri)
                .then( () => {
                    location.reload()
                })
                .catch( error => {
                    console.log(error)
                })
        }
    });


})

