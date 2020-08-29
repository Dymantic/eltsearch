function showSuccess(message) {
    window.app.$store.commit("notifications/addSuccess", message);
}

function showError(message) {
    window.app.$store.commit("notifications/addError", message);
}

function showWarning(message) {
    window.app.$store.commit("notifications/addWarning", message);
}

export { showSuccess, showError, showWarning };
