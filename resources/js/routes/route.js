import VueRouter from 'vue-router';

import ExampleComponent from '../components/ExampleComponent.vue';
import ManageKPIComponent from '../components/ManageKPIComponent.vue';

import DepartmentalKPIComponent from '../components/DepartmentalKPIComponent.vue';
import OrganizationalKPIComponent from '../components/OrganizationalKPIComponent.vue';

import RateYourself from '../components/RateYourself.vue';

import KpiFrequencyComponent from '../components/KpiFrequencyComponent.vue';

import BootComponent from '../components/boot/BootComponent.vue';




export default new VueRouter({

    mode: 'hash',
    routes: [
        {
            path: '/',
            name: 'departmental-kpi',
            component: DepartmentalKPIComponent
        },
        {
            path: '/departmental-kpi',
            name: 'departmental-kpi',
            component: DepartmentalKPIComponent
        },
        {
            path: '/kpi-frequency',
            name: 'kpi-frequency',
            component: KpiFrequencyComponent
        },
        {
            path: '/manage-organizational-kpi',
            // hash: '#manage-kpi',
            name: 'manage-organizational-kpi',
            component: OrganizationalKPIComponent
        },
        {
            path: '/rate-yourself/:userId/:workdeptId/:linemanagerId',
            name: 'rate-yourself',
            component: RateYourself
        }
    ]

});
