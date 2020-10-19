import {
    createJobPost,
    fetchJobPostOptions,
    fetchSchoolJobPosts,
    publishJobPost,
    retractJobPost,
    updateJobPost,
} from "../../api/schools/job_posts";
import { showError } from "../../libs/notifications";

export default {
    namespaced: true,

    state: {
        options: null,
        all: [],
    },

    getters: {
        postById: (state) => (id) =>
            state.all.find((post) => post.id === parseInt(id)),
    },

    mutations: {
        setOptions(state, options) {
            state.options = options;
        },

        setPosts(state, posts) {
            state.all = posts;
        },
    },

    actions: {
        fetchOptions({ commit }) {
            return fetchJobPostOptions().then((options) =>
                commit("setOptions", options)
            );
        },

        fetchPosts({ state, dispatch, rootState }) {
            if (!rootState.schoolprofile.current_school) {
                return Promise.reject("No school profile set");
            }

            if (state.all.length) {
                return Promise.resolve();
            }

            return dispatch("refreshPosts");
        },

        refreshPosts({ rootState, commit }) {
            if (!rootState.schoolprofile.current_school) {
                return Promise.reject("No school profile set");
            }

            return fetchSchoolJobPosts(
                rootState.schoolprofile.current_school.id
            )
                .then((posts) => commit("setPosts", posts))
                .catch(() => showError("Unable to fetch posts"));
        },

        createPost({ dispatch }, { school_id, formData }) {
            return createJobPost(school_id, formData).then(() =>
                dispatch("refreshPosts")
            );
        },

        updatePost({ dispatch }, { post_id, formData, school_id }) {
            return updateJobPost(post_id, formData).then(() =>
                dispatch("refreshPosts")
            );
        },

        publishPost({ dispatch }, post_id) {
            return publishJobPost(post_id).then(() => dispatch("refreshPosts"));
        },

        retractPost({ dispatch }, post_id) {
            return retractJobPost(post_id).then(() => dispatch("refreshPosts"));
        },
    },
};
