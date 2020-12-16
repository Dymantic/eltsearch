import { fetchNations } from "../api/nations";
import { showError } from "../libs/notifications";

export default {
    namespaced: true,

    state: {
        all: [],
    },

    getters: {
        forSelect: (state) =>
            state.all.map((nation) => ({
                value: nation.id,
                text: nation.nationality,
            })),
    },

    mutations: {
        setNations(state, nations) {
            state.all = nations;
        },
    },

    actions: {
        fetch({ state, commit }) {
            if (state.all.length) {
                return Promise.resolve();
            }

            return fetchNations()
                .then((nations) => commit("setNations", nations))
                .catch(() => showError("Failed to fetch nations"));
        },
    },
};
