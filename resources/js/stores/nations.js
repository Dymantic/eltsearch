import { fetchNations } from "../api/nations";
import { showError } from "../libs/notifications";

export default {
    namespaced: true,

    state: {
        all: [],
    },

    getters: {
        forSelect: (state) => (lang) => {
            const l = lang || "en";
            return state.all.map((nation) => ({
                value: nation.id,
                text: nation.nationality[l],
            }));
        },
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
