import Vue from "vue";
import VueRouter from "vue-router";
import Vuex from "vuex";

Vue.use(VueRouter);
Vue.use(Vuex);

import general from "./stores/general";
import messages from "./stores/messages";
import profile from "./stores/teachers/profile";
import locations from "./stores/locations";
import placements from "./stores/teachers/placements";
import applications from "./stores/teachers/applications";
import notifications from "./stores/notifications";
import lang from "./stores/schools/lang";
import matches from "./stores/teachers/matches";
import nations from "./stores/nations";
import recruitments from "./stores/teachers/recruitments";

const store = new Vuex.Store({
    modules: {
        general,
        messages,
        profile,
        locations,
        placements,
        applications,
        notifications,
        lang,
        matches,
        nations,
        recruitments,
    },
});

import routes from "./routes/teachers/routes";

const router = new VueRouter({
    routes: routes,
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition;
        } else {
            return { x: 0, y: 0 };
        }
    },
});

import transPlugin from "./vue/transPlugin";
Vue.use(transPlugin);

import AppShell from "./vue/Pages/AppShell";
import MainNavigation from "./vue/Components/Teachers/MainNavigation";
import TopBar from "./vue/Components/Teachers/TopBar";
Vue.component("main-navigation", MainNavigation);
Vue.component("top-bar", TopBar);
window.app = new Vue({
    el: "#app",

    router,
    store,

    components: {
        AppShell,
    },
});
