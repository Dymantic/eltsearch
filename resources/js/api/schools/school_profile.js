import { get, post } from "../http";

function fetchSchoolProfiles() {
    return get(`/api/schools/user-schools`);
}

function updateSchoolProfile(school_id, formData) {
    return post(`/api/schools/${school_id}`, formData);
}

function updateSchoolBillingInfo(school_id, formData) {
    return post(`/api/schools/${school_id}/billing-details`, formData);
}

export { fetchSchoolProfiles, updateSchoolProfile, updateSchoolBillingInfo };
