<template>
    <div>
        <page-header title="Job Posts">
            <router-link to="/job-posts/create" class="btn btn-primary"
                >Create New Post</router-link
            >
        </page-header>
        <div>
            <div v-for="post in posts" :key="post.id" class="shadow my-8 p-6">
                <p>
                    <router-link :to="`/job-posts/${post.id}/edit`">{{
                        post.position
                    }}</router-link>
                </p>
                <p>{{ post.school_name }}</p>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../Components/PageHeader";
export default {
    components: {
        PageHeader,
    },

    computed: {
        posts() {
            return this.$store.state.posts.all;
        },

        schoolId() {
            const school = this.$store.state.schoolprofile.current_school;
            return school ? school.id : null;
        },
    },

    mounted() {
        if (this.schoolId) {
            this.fetch();
        }
    },

    watch: {
        schoolId(to) {
            if (to) {
                this.fetch();
            }
        },
    },

    methods: {
        fetch() {
            this.$store.dispatch("posts/fetchPosts", this.schoolId);
        },
    },
};
</script>
