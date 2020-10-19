import { get, post } from "../http";

function fetchSchoolApplications(school_id) {
    return get(`/api/schools/${school_id}/applications`);
}

function showInterestInApplicant(application_id, formData) {
    return post(
        `/api/schools/applications/${application_id}/show-of-interest`,
        formData
    );
}

export { fetchSchoolApplications, showInterestInApplicant };
