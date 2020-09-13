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

        fetchPosts({ dispatch, commit, rootState }) {
            if (!rootState.schoolprofile.current_school) {
                return dispatch("schoolprofile/fetchProfiles", null, {
                    root: true,
                }).then(() => {
                    fetchSchoolJobPosts(
                        rootState.schoolprofile.current_school.id
                    ).then((posts) => commit("setPosts", posts));
                });
            }
            const schoolio = rootState.schoolprofile.current_school.id;
            return fetchSchoolJobPosts(schoolio).then((posts) =>
                commit("setPosts", posts)
            );
        },

        refreshPosts({ dispatch }) {
            return dispatch("fetchPosts").catch(() =>
                showError("Failed to fetch job posts")
            );
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
