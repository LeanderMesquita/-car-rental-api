/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';

import vuex from 'vuex'
vue.use(vuex)

const store = new vuex.Store({
    state: {
        
    }
})
/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});

import ExampleComponent from './components/ExampleComponent.vue';
app.component('example-component', ExampleComponent);

// Starting
import LoginComponent from './components/LoginComponent.vue';
app.component('login-component', LoginComponent);
import HomeComponent from './components/HomeComponent.vue';
app.component('home-component', HomeComponent);






// Utilities
import InputContainerComponent from './components/utilities/InputContainerComponent.vue';
app.component('input-container-component', InputContainerComponent);

import TableComponent from './components/utilities/TableComponent.vue';
app.component('table-component', TableComponent);

import CardComponent from './components/utilities/CardComponent.vue';
app.component('card-component', CardComponent);
import ModalComponent from './components/utilities/ModalComponent.vue';
app.component('modal-component', ModalComponent);

import AlertComponent from './components/utilities/AlertComponent.vue';
app.component('alert-component', AlertComponent);

import PaginateComponent from './components/utilities/PaginateComponent.vue';
app.component('paginate-component', PaginateComponent);






// Main 
import CarrosComponent from './components/CarrosComponent.vue';
app.component('carros-component', CarrosComponent);

import ClientesComponent from './components/ClientesComponent.vue';
app.component('clientes-component', ClientesComponent);

import MarcasComponent from './components/MarcasComponent.vue';
app.component('marcas-component', MarcasComponent);

import ModelosComponent from './components/ModelosComponent.vue';
app.component('modelos-component', ModelosComponent);

import LocacoesComponent from './components/LocacoesComponent.vue';
app.component('locacoes-component', LocacoesComponent);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.mount('#app');
