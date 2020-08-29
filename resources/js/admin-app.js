import Vue from "vue";
import VueRouter from "vue-router";
import Vuex from "vuex";

Vue.use(VueRouter);
Vue.use(Vuex);

import notifications from "./stores/notifications";
import profile from "./stores/admin/profile";
import locations from "./stores/admin/locations";
import schooltypes from "./stores/admin/schooltypes";
const store = new Vuex.Store({
    modules: {
        notifications,
        profile,
        locations,
        schooltypes,
    },
});

import routes from "./routes/admin/routes";
const router = new VueRouter({
    routes,
});

import MainNavigation from "./vue/Components/Admin/MainNavigation";
Vue.component("main-navigation", MainNavigation);
import AppShell from "./vue/Pages/AppShell";

window.app = new Vue({
    el: "#app",

    router,
    store,

    components: {
        AppShell,
    },
});
