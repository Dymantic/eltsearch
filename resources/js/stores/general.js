export default {
    namespaced: true,

    actions: {
        refreshResources({ dispatch, rootState }) {
            const type = rootState.profile.account_type;

            if (type === "teacher") {
                dispatch("matches/refresh", null, { root: true });
            }

            if (type === "school") {
                dispatch("applications/refreshApplications", null, {
                    root: true,
                });
            }
        },
    },
};
