import {
    createJobPost,
    fetchJobPostOptions,
    fetchSchoolJobPosts,
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

        fetchPosts({ commit }, school_id) {
            return fetchSchoolJobPosts(school_id).then((posts) =>
                commit("setPosts", posts)
            );
        },

        refreshPosts({ dispatch }, school_id) {
            return dispatch("fetchPosts", school_id).catch(() =>
                showError("Failed to fetch job posts")
            );
        },

        createPost({ dispatch }, { school_id, formData }) {
            return createJobPost(school_id, formData).then(() =>
                dispatch("refreshPosts", school_id)
            );
        },

        updatePost({ dispatch }, { post_id, formData, school_id }) {
            return updateJobPost(post_id, formData).then(() =>
                dispatch("refreshPosts", school_id)
            );
        },
    },
};
