import Vue from "vue";
import VueRouter from "vue-router";
import Vuex from "vuex";

Vue.use(VueRouter);
Vue.use(Vuex);

import notifications from "./stores/notifications";
import profile from "./stores/teachers/profile";
import locations from "./stores/teachers/locations";
import placements from "./stores/teachers/placements";
const store = new Vuex.Store({
    modules: {
        notifications,
        profile,
        locations,
        placements,
    },
});

import routes from "./routes/teachers/routes";

const router = new VueRouter({
    routes: routes,
});

import AppShell from "./vue/Pages/AppShell";
import MainNavigation from "./vue/Components/Teachers/MainNavigation";
Vue.component("main-navigation", MainNavigation);
window.app = new Vue({
    el: "#app",

    router,
    store,

    components: {
        AppShell,
    },
});
