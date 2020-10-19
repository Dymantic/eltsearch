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
import applications from "./stores/schools/applications";
import lang from "./stores/schools/lang";
const store = new Vuex.Store({
    modules: {
        notifications,
        profile,
        schoolprofile,
        locations,
        posts,
        applications,
        lang,
    },
});

import routes from "./routes/schools/routes";
const router = new VueRouter({
    routes,
});

router.beforeEach((to, from, next) => {
    if (store.state.profile.school_ids.length < 1) {
        store.commit("profile/setProfileDetails", window.currentProfile);
    }
    if (!store.state.schoolprofile.profiles.length) {
        store
            .dispatch("schoolprofile/fetchProfiles")
            .then(next)
            .catch(() => showError("Unable to fetch school information"));
    } else {
        next();
    }
});

import transPlugin from "./vue/transPlugin";
Vue.use(transPlugin);

import MainNavigation from "./vue/Components/Schools/MainNavigation";
Vue.component("main-navigation", MainNavigation);
import AppShell from "./vue/Pages/AppShell";
import { showError } from "./libs/notifications";

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
