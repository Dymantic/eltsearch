<template>
    <div v-if="post">
        <page-header title="Publish Post"> </page-header>

        <div class="my-12" v-if="!post.is_public">
            <p>
                You are about to publish your job-post. Once it is published it
                will be live on the site for 30 days.
            </p>
            <div class="my-12">
                <submit-button
                    :waiting="waiting"
                    role="button"
                    @click.native="publish"
                    >Publish</submit-button
                >
            </div>
        </div>

        <div v-else class="my-12">
            <p>
                Your post is currently public, and live on the site. You may
                retract the post if you would like to not have it shown publicly
                anymore. Note taht this will not affect the date when the post
                will be retired.
            </p>
            <div class="my-12">
                <submit-button
                    :waiting="waiting"
                    role="button"
                    @click.native="retract"
                    >Retract</submit-button
                >
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../Components/PageHeader";
import SubmitButton from "../../Components/Forms/SubmitButton";
import { showError, showSuccess } from "../../../libs/notifications";
export default {
    components: {
        PageHeader,
        SubmitButton,
    },

    data() {
        return {
            waiting: false,
        };
    },

    computed: {
        post() {
            return this.$store.getters["posts/postById"](
                this.$route.params.post
            );
        },
    },

    created() {
        this.$store
            .dispatch("posts/fetchPosts")
            .catch(() => showError("Unable to fetch posts"));
    },

    methods: {
        publish() {
            this.waiting = true;

            this.$store
                .dispatch("posts/publishPost", this.post.id)
                .then(() => {
                    showSuccess("Your post has been published");
                })
                .catch(() => {})
                .then(() => (this.waiting = false));
        },

        retract() {
            this.$store
                .dispatch("posts/retractPost", this.post.id)
                .then(() => {
                    showSuccess("Your post has been retracted");
                })
                .catch(() => {})
                .then(() => (this.waiting = false));
        },
    },
};
</script>
