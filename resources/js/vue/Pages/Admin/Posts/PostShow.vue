<template>
    <div>
        <page-header title="Job Post"></page-header>

        <p v-show="!post && fetching">Fetching Post</p>
        <p v-show="!post && !fetching">This post does not exist.</p>

        <div v-if="post" class="my-12">
            <job-post :post="post"></job-post>
        </div>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../../Components/PageHeader";
import JobPost from "../../../Components/JobPost";
import { showError } from "../../../../libs/notifications";
export default {
    components: { JobPost, PageHeader },

    data() {
        return {
            fetching: true,
            post: null,
        };
    },

    mounted() {
        this.$store
            .dispatch("posts/getById", this.$route.params.post)
            .then((post) => {
                this.post = post;
            })
            .catch(() => showError("Unable to find post"))
            .then(() => (this.fetching = false));
    },
};
</script>
