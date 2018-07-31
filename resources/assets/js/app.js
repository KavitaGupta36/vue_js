

//Vue.component( 'v-select', vSelect );
require('./bootstrap');

Vue.component('example-component', require('./components/ExampleComponent.vue').default );
Vue.component('pagination', require('laravel-vue-pagination'));

const app = new Vue({
    el: '#app'

    /*mounted(){
    	axios.get('/skills').then(response => console.log(response));
    }*/
});
