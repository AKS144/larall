//const { default: Vue } = require('vue');//disabled in 28 part for star-rating

require('./bootstrap');

//this are plugins
window.Vue = require('vue');
window.swal = require('sweetalert');//added
window.$ = require('jquery');//added for


Vue.config.devtools = true;
import Vue from 'vue';
import StarRating from 'vue-star-rating';

//googlemaps
import * as VueGoogleMaps from 'vue2-google-maps';
Vue.use(VueGoogleMaps, {
    load: {
        key: 'AIzaSyC15vLKgszuTdiU9NORBcgDPX_YDntcN40'
    }
});
//ends for maps

/**
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('products', require('./components/ProductComponent.vue').default);
Vue.component('products', require('./components/ProductComponent.vue').default);
Vue.component('checkout', require('./components/CheckoutComponent.vue').default);
Vue.component('detail', require('./components/DetailComponent.vue').default);
Vue.component('star-rating', StarRating);
Vue.component('maps', require('./components/MapComponent.vue').default);
//Vue.component('vue2-google-maps', VueGoogleMaps);


const app = new Vue({
    el: '#app',
});
