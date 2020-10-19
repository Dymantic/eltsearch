<template>
    <div v-if="post">
        <page-header :title="trns('show_job_post.title')">
            <router-link
                :to="`/job-posts/${$route.params.post}/publish`"
                class="btn btn-primary mr-4"
                >{{ trns("actions.publish") }}</router-link
            >
            <router-link
                :to="`/job-posts/${$route.params.post}/edit`"
                class="btn btn-primary"
                >{{ trns("actions.edit") }}</router-link
            >
        </page-header>
        <div>
            <job-post :post="post.presented" :can-edit="true"></job-post>
        </div>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../Components/PageHeader";
import JobPost from "../../Components/JobPost";
import { showError } from "../../../libs/notifications";
export default {
    components: {
        PageHeader,
        JobPost,
    },

    computed: {
        post() {
            return this.$store.getters["posts/postById"](
                this.$route.params.post
            );
        },
    },

    mounted() {
        this.fetchPosts();
    },

    methods: {
        fetchPosts() {
            this.$store.dispatch("posts/refreshPosts", this.schoolId);
        },
    },
};
</script>
