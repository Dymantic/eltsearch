import { get } from "../http";

function fetchSchoolTypes(lang = "en") {
    return get(`/api/school-types?lang=${lang}`);
}

export { fetchSchoolTypes };
