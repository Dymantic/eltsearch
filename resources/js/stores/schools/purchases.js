import {
    fetchSchoolPackages,
    fetchSchoolResumePassInfo,
    getSchoolPurchases,
    purchasePackageForSchool,
} from "../../api/schools/paurchasing";
import { showError } from "../../libs/notifications";

export default {
    namespaced: true,

    state: {
        purchases: [],
        packages: [],
        two_checkout: {
            merchant_code: window.currentProfile.merchant,
        },
        resumePass: {
            has_access: false,
            expires_on: "",
            days_remaining: 0,
        },
    },

    getters: {
        tokenPackages: (state) =>
            state.packages.filter((pack) => pack.type === "token"),

        resumePassPackages: (state) =>
            state.packages.filter((pack) => pack.type === "resume_pass"),

        packageById: (state) => (id) => state.packages.find((p) => p.id === id),

        purchaseById: (state) => (id) =>
            state.purchases.find((p) => p.id === parseInt(id)),
    },

    mutations: {
        setPackages(state, packages) {
            state.packages = packages;
        },

        setPurchases(state, purchases) {
            state.purchases = purchases;
        },

        setResumePass(state, passInfo) {
            state.resumePass = passInfo;
        },
    },

    actions: {
        fetchPackages({ dispatch, state }) {
            if (state.packages.length) {
                return Promise.resolve();
            }

            return dispatch("refreshPackages");
        },

        refreshPackages({ commit }) {
            return fetchSchoolPackages()
                .then((packages) => commit("setPackages", packages))
                .catch(() => showError("Failed to fetch package info"));
        },

        fetchPurchases({ dispatch, state }, school_id) {
            if (state.purchases.length) {
                return Promise.resolve();
            }

            return dispatch("refreshPurchases", school_id);
        },

        refreshPurchases({ commit }, school_id) {
            return getSchoolPurchases(school_id)
                .then((purchases) => commit("setPurchases", purchases))
                .catch(() => "Failed to fetch purchases");
        },

        purchasePackage({ dispatch }, { school_id, formData }) {
            return purchasePackageForSchool(school_id, formData).then(
                (purchase) => {
                    dispatch("refreshPurchases", school_id);
                    dispatch("tokens/refresh", school_id, { root: true });
                    return purchase;
                }
            );
        },

        checkResumePass({ commit, rootState }, school_id) {
            if (!school_id) {
                school_id = rootState.schoolprofile.current_school.id;
            }
            return fetchSchoolResumePassInfo(school_id)
                .then((passInfo) => commit("setResumePass", passInfo))
                .catch(() => showError("Unable to get resume pass info"));
        },
    },
};
