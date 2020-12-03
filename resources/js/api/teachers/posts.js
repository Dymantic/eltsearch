import { get } from "../http";

function fetchPostBySlug(post_slug) {
    return get(`/api/job-posts/${post_slug}`);
}

export { fetchPostBySlug };
