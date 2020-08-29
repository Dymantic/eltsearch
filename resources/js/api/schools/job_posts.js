import { get, post } from "../http";

function fetchJobPostOptions() {
    return get("/api/schools/job-post-options");
}

function fetchSchoolJobPosts(school_id) {
    return get(`/api/schools/${school_id}/job-posts`);
}

function createJobPost(school_id, formData) {
    return post(`/api/schools/${school_id}/job-posts`, formData);
}

function updateJobPost(post_id, formData) {
    return post(`/api/schools/job-posts/${post_id}`, formData);
}

export {
    fetchJobPostOptions,
    fetchSchoolJobPosts,
    createJobPost,
    updateJobPost,
};
