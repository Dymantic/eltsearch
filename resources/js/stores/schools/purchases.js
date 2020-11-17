import {
    fetchSchoolPackages,
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
            merchant_code: "250584922092",
            script_src: "https://2pay-js.2checkout.com/v1/2pay.js",
        },
    },

    getters: {
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
    },
};
