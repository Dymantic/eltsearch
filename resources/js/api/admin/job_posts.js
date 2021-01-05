import { del, get, post } from "../http";

function getJobPostsOverview() {
    return get("/api/admin/job-posts-overview");
}

function queryJobPosts(
    page = 1,
    search = "",
    order = "published",
    descending = true
) {
    const direction = descending ? "desc" : "asc";
    return get(
        `/api/admin/job-posts?page=${page}&q=${search}&order=${order}&direction=${direction}`
    );
}

function getJobPostById(job_post_id) {
    return get(`/api/admin/job-posts/${job_post_id}`);
}

function disableJobPost(job_post_id) {
    return post("/api/admin/disabled-job-posts", { job_post_id });
}

function reinstateJobPost(job_post_id) {
    return del(`/api/admin/disabled-job-posts/${job_post_id}`);
}

export {
    getJobPostsOverview,
    queryJobPosts,
    getJobPostById,
    disableJobPost,
    reinstateJobPost,
};
