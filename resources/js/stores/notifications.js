export default {
    namespaced: true,

    state: {
        queue: [],
    },

    mutations: {
        addSuccess(state, message) {
            state.queue.push({
                type: "success",
                message,
                confirm: false,
                timestamp: new Date().getTime(),
            });
        },

        addError(state, message) {
            state.queue.push({
                type: "error",
                message,
                confirm: true,
                timestamp: new Date().getTime(),
            });
        },

        addWarning(state, message) {
            state.queue.push({
                type: "warning",
                message,
                confirm: false,
                timestamp: new Date().getTime(),
            });
        },

        clear(state, notification) {
            state.queue = state.queue.filter((queued) => {
                return (
                    queued.timestamp !== notification.timestamp &&
                    queued.message !== notification.message
                );
            });
        },
    },
};
