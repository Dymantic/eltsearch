import { get } from "./http";

function refreshProfileInfo() {
    return get("/api/basic-profile");
}

export { refreshProfileInfo };
