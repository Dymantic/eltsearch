import {
    getPurchaseById,
    getPurchasesOverview,
} from "../../api/admin/purchases";
import { showError } from "../../libs/notifications";

export default {
    namespaced: true,

    state: {
        total_this_month: 0,
        total_revenue_for_month: "$0",
        recent: [],
    },

    mutations: {
        setOverview(
            state,
            { total_this_month, total_revenue_for_month, recent }
        ) {
            state.total_this_month = total_this_month;
            state.total_revenue_for_month = total_revenue_for_month;
            state.recent = recent;
        },
    },

    actions: {
        fetch({ state, dispatch }) {
            if (state.recent.length) {
                return Promise.resolve();
            }
            return dispatch("refresh");
        },

        refresh({ commit }) {
            return getPurchasesOverview()
                .then((overview) => commit("setOverview", overview))
                .catch(() => showError("Failed to fetch purchases info"));
        },

        getById({ state }, purchase_id) {
            const from_recent = state.recent.find(
                (p) => p.id === parseInt(purchase_id)
            );

            if (from_recent) {
                return Promise.resolve(from_recent);
            }

            return getPurchaseById(purchase_id);
        },
    },
};
