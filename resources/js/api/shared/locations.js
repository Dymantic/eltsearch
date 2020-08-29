import { get } from "../http";

function allLocations(lang = "en") {
    return get(`/api/locations?lang=${lang}`);
}

export { allLocations };
