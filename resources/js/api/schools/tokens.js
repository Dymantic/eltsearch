import { get } from "../http";

function getSchoolTokens(school_id) {
    return get(`/api/schools/${school_id}/tokens`);
}

export { getSchoolTokens };
