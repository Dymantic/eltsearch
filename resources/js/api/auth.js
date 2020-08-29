import { post } from "./http";

function resetPassword(formData) {
    return post("/api/me/reset-password", formData);
}

export { resetPassword };
