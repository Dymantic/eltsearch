import Vue from "vue";
import VueRouter from "vue-router";
import Vuex from "vuex";

Vue.use(VueRouter);
Vue.use(Vuex);

import messages from "./stores/messages";
import profile from "./stores/admin/profile";
import locations from "./stores/admin/locations";
import schooltypes from "./stores/admin/schooltypes";
import notifications from "./stores/notifications";
import lang from "./stores/schools/lang";
import announcements from "./stores/admin/announcements";
import posts from "./stores/admin/job_posts";
import teachers from "./stores/admin/teachers";
import schools from "./stores/admin/schools";
const store = new Vuex.Store({
    modules: {
        messages,
        profile,
        locations,
        schooltypes,
        notifications,
        lang,
        announcements,
        posts,
        teachers,
        schools,
    },
});

import routes from "./routes/admin/routes";
const router = new VueRouter({
    routes,
});

import transPlugin from "./vue/transPlugin";
Vue.use(transPlugin);

import MainNavigation from "./vue/Components/Admin/MainNavigation";
import TopBar from "./vue/Components/Admin/TopBar";
Vue.component("main-navigation", MainNavigation);
Vue.component("top-bar", TopBar);
import AppShell from "./vue/Pages/AppShell";

window.app = new Vue({
    el: "#app",

    router,
    store,

    components: {
        AppShell,
    },
});
