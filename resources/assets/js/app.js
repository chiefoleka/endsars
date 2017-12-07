
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
// this file lists out base helpers functions needed although the application

require('./bootstrap');

(function(){
  window.headers = {
    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
  };
  $.ajaxSetup({
    headers: headers
  });

})()

window.Vue = require('vue')

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('tweets', require('./components/TweetsComponent.vue'))
Vue.component('feeds', require('./components/FeedsComponent.vue'))
Vue.component('stories', require('./components/StoriesComponent.vue'))
Vue.component('delete', require('./components/DeleteComponent.vue'))

const app = new Vue({
    el: '#app'
});
