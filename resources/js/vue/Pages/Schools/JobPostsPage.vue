<template>
    <div>
        <page-header :title="trns('posts_index.title')">
            <router-link to="/job-posts/create" class="btn btn-primary">{{
                trns("posts_index.create_post")
            }}</router-link>
        </page-header>

        <div class="my-12" v-show="posts.length === 0">
            <p class="text-gray-600">{{ trns("posts_index.no_posts") }}</p>
        </div>

        <div>
            <job-post-card
                v-for="post in posts"
                :post="post"
                :key="post.id"
            ></job-post-card>
        </div>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../Components/PageHeader";
import JobPostCard from "../../Components/Schools/JobPostCard";
export default {
    components: {
        PageHeader,
        JobPostCard,
    },

    computed: {
        posts() {
            return this.$store.state.posts.all;
        },
    },

    mounted() {
        this.fetch();
    },

    methods: {
        fetch() {
            this.$store.dispatch("posts/fetchPosts", this.schoolId);
        },
    },
};
</script>
