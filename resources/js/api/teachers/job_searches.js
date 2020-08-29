import { get, post } from "../http";

function fetchJobSearchOptions() {
    return get("/api/teachers/job-search-options");
}

function saveJobSearch(formData) {
    return post("/api/teachers/job-searches", formData);
}

export { saveJobSearch, fetchJobSearchOptions };
