/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

// import 'bootstrap/dist/css/bootstrap.css'
// import 'bootstrap-vue/dist/bootstrap-vue.css'

import VueRouter from 'vue-router';

import VModal from 'vue-js-modal'
// import BootstrapVue from 'bootstrap-vue'

// import VueDropdown from 'vue-dynamic-dropdown/VueDropdown'


Vue.use(VueRouter);

Vue.use(VModal, { dynamic: true, dynamicDefaults: { clickToClose: false } });

// Vue.use(BootstrapVue);


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.mixin({
    data() {
        return {
            storage: {},
            $user_id: '',
            $linemanager_id: '',
            $is_linemanager: '',
            $is_admin: '',
            $workdept_id: '',
            editMode: false,
            data: {},
            list: []
        };
    },
    computed: {
        isAdmin() {
            return (+this.localstorageGet('is_admin') == 1);
        },
        isLineManager() {
            return (+this.localstorageGet('is_linemanager') == 1);
        },
        isOther() {
            return (!this.isLineManager && !this.isAdmin);
        }
    },
    methods: {
        localstorageSave(k, v) {
            // alert('local storage...');
            localStorage.setItem(k, v);
            this.storage[k] = v;
        },
        localstorageGet(k) {
            let r = this.storage[k];
            return localStorage.getItem(k); //this.storage[k]; //
        },
        getUserId() {
            return +this.localstorageGet('user_id');
        },
        getLineManagerId() {
            ///rate-yourself/:userId/:workdeptId/:linemanagerId
            return +this.localstorageGet('linemanager_id');
        },
        getWorkDeptId() {
            return +this.localstorageGet('workdept_id');
        },
        rateYourself() {
            location.hash = '/rate-yourself/' + this.getUserId() + '/' + this.getWorkDeptId() + '/' + this.getLineManagerId();
        },
        checkUserRole() {
            //  alert('boot startup ... ');
            if (this.isLineManager) {
                this.rateYourself();
            } else if (this.isAdmin) {
                location.hash = '/departmental-kpi';
                //  location.reload();
            } else {
                this.rateYourself();
            }
        },

        /////Crud Mixin
        getCreateApi() {
            return '';
        },
        getDeleteApi(id) {
            return '';
        },
        getUpdateApi(id) {
            return '';     
        },
        getFetchApi() {
            return '';
        },
        doGet(url) {
            this.startAjax();
            return fetch(url, {
                method: 'GET'
            }).then(res => { 
                this.stopAjax();
                return res.json();
            });
        },
        doPost(url, data) {
            this.startAjax();
            data._token = laravel.csrfToken;
            return fetch(url, {
                method: 'POST',
                body: JSON.stringify(data),
                headers: { "content-Type": "application/json" }
            }).then(res => {
                this.stopAjax();
                return res.json();
            });
        },
        doSave() {
            // this.startAjax();
            this.doPost(this.getUpdateApi(this.data.id), this.data)
                .then(res => {
                    // this.stopAjax();
                    toastr.success(res.message);
                    this.doFetch();
                });
        },
        doCreate() {
            // this.startAjax();
            this.doPost(this.getCreateApi(), this.data)
                .then(res => {
                    // this.stopAjax();
                    toastr.success(res.message);
                    this.doFetch();
                });
        },
        doDelete() {
            // this.startAjax();
            this.doPost(this.getDeleteApi(this.data.id), {})
                .then(res => {
                    // this.stopAjax();
                    toastr.success(res.message);
                    this.doFetch();
                });
        },
        pick(inData) {
            this.data = inData;
            this.editMode = true;
        },
        unpick() {
            this.editMode = false;   
        },
        save() {
            if (this.editMode) {
                this.doSave();
            } else {
                this.doCreate();
            }
        },
        doFetch() {
            this.doGet(this.getFetchApi()).then(res => {
                this.list = res.data;
                this.afterFetch();
            });
        },
        afterFetch() { },
        startAjax(){
            this.$root.$emit('ajax-start');
        },
        stopAjax(){
            this.$root.$emit('ajax-stop');
        }


    }
});

Vue.component('kpi-menu-link', require('./components/KpiMenu.vue').default);

Vue.component('kpi-rate-form-user', require('./components/KpiRateFormUser.vue').default);

Vue.component('kpi-rate-form-linemanager', require('./components/KpiRateFormLineManager.vue').default);

Vue.component('kpi-boot', require('./components/boot/BootComponent.vue').default);

Vue.component('kpi-frequency-interval', require('./components/KpiFrequencyIntervalComponent.vue').default);

Vue.component('kpi-user-value', require('./components/KpiUserValueComponent.vue').default);

Vue.component('ajax-loader', require('./components/AjaxLoaderComponent.vue').default);

//AjaxLoaderComponent
//KpiFrequencyIntervalComponent

// 

// Vue.component('kpi-user-role-boot', require('./components/boot/BootComponent.vue').default);
// KpiRateFormLineManager
// KpiRateForm


import router from './routes/route.js';

// let baseRoute = 'kpi-plugin';

// const router = new VueRouter({

//     mode: 'hash',
//     routes: [
//         {
//             path: '/',
//             name: 'example-component',
//             component: ExampleComponent
//         },
//         {
//             path:'/manage-kpi',
//             // hash: '#manage-kpi',
//             name: 'manage-kpi-component',
//             component: ManageKPIComponent
//         }
//     ]

// });

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router
});
