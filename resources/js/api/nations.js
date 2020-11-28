import { get } from "./http";

function fetchNations() {
    return get("/api/nations");
}

export { fetchNations };
