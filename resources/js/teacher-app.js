import Vue from "vue";
import VueRouter from "vue-router";
import Vuex from "vuex";

Vue.use(VueRouter);
Vue.use(Vuex);

import messages from "./stores/messages";
import profile from "./stores/teachers/profile";
import locations from "./stores/teachers/locations";
import placements from "./stores/teachers/placements";
import applications from "./stores/teachers/applications";
import notifications from "./stores/notifications";
import lang from "./stores/schools/lang";
const store = new Vuex.Store({
    modules: {
        messages,
        profile,
        locations,
        placements,
        applications,
        notifications,
        lang,
    },
});

import routes from "./routes/teachers/routes";

const router = new VueRouter({
    routes: routes,
});

import transPlugin from "./vue/transPlugin";
Vue.use(transPlugin);

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
