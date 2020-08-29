import Vue from "vue";
import VueRouter from "vue-router";
import Vuex from "vuex";

Vue.use(VueRouter);
Vue.use(Vuex);

import notifications from "./stores/notifications";
import profile from "./stores/schools/profile";
import schoolprofile from "./stores/schools/school_profile";
import locations from "./stores/schools/locations";
import posts from "./stores/schools/job_posts";
const store = new Vuex.Store({
    modules: {
        notifications,
        profile,
        schoolprofile,
        locations,
        posts,
    },
});

import routes from "./routes/schools/routes";
const router = new VueRouter({
    routes,
});

import MainNavigation from "./vue/Components/Schools/MainNavigation";
Vue.component("main-navigation", MainNavigation);
import AppShell from "./vue/Pages/AppShell";

window.app = new Vue({
    el: "#app",

    router,
    store,

    components: {
        AppShell,
    },

    created() {
        this.$store.dispatch("schoolprofile/fetchProfiles");
    },
});
