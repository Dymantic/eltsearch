function showSuccess(message) {
    window.app.$store.commit("messages/addSuccess", message);
}

function showError(message) {
    window.app.$store.commit("messages/addError", message);
}

function showWarning(message) {
    window.app.$store.commit("messages/addWarning", message);
}

export { showSuccess, showError, showWarning };
