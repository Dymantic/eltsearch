<template>
    <div v-if="post">
        <page-header title="Publish Post">
            <router-link
                :to="`/job-posts/${post.id}/show`"
                class="type-b2 text-navy hover:text-sky-blue"
                >View Post</router-link
            >
        </page-header>

        <incomplete-job-post-review
            :post="post"
            v-if="!can_publish"
        ></incomplete-job-post-review>

        <div v-else>
            <div class="my-12" v-if="!post.is_public">
                <div v-if="!post.presented.has_been_published">
                    <div v-if="available_tokens === 0">
                        <p class="max-w-lg">
                            Sorry, you currently do not have any tokens to use
                            to publish your job post. First get a token, then
                            you can publish.
                        </p>
                        <div class="mt-6">
                            <router-link
                                to="/purchasing"
                                class="btn btn-primary"
                                >Buy Token</router-link
                            >
                        </div>
                    </div>
                    <div v-else>
                        <div class="mb-6">
                            <p>Your post is ready to publish.</p>
                            <p class="my-4">
                                It will be shown until {{ one_month_later }}
                            </p>
                            <p>
                                <span class="type-b2">Cost: </span>1 token ({{
                                    available_tokens - 1
                                }}
                                remaining)
                            </p>
                        </div>

                        <submit-button
                            :waiting="waiting"
                            role="button"
                            @click.native="publish"
                            >Publish</submit-button
                        >
                    </div>
                </div>
                <div v-else>
                    <p class="max-w-lg">
                        Your post was originally published on
                        {{ post.presented.first_published }} and expires on
                        {{ post.presented.expires_on }}. You may republish to
                        make it live again.
                    </p>
                    <div class="my-12">
                        <submit-button
                            :waiting="waiting"
                            role="button"
                            @click.native="publish"
                            >Re-Publish</submit-button
                        >
                    </div>
                </div>
            </div>

            <div v-else class="my-12">
                <p class="max-w-lg">
                    Your post is currently public, and will be live on the site
                    until
                    <span class="type-b2">{{ post.presented.expires_on }}</span
                    >. You may retract the post if you would like to not have it
                    shown publicly anymore. Note that this will not affect the
                    date when the post will be retired.
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
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../Components/PageHeader";
import SubmitButton from "../../Components/Forms/SubmitButton";
import { showError, showSuccess } from "../../../libs/notifications";
import IncompleteJobPostReview from "../../Components/Schools/IncompleteJobPostReview";
export default {
    components: {
        IncompleteJobPostReview,
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

        can_publish() {
            return this.post.presented.ready_for_publication;
        },

        available_tokens() {
            return this.$store.state.tokens.valid.length;
        },

        one_month_later() {
            const now = new Date();
            now.setDate(now.getDate() + 30);
            return now.toLocaleDateString("en", {});
        },

        school() {
            return this.$store.state.schoolprofile.current_school;
        },
    },

    created() {
        this.$store
            .dispatch("posts/fetchPosts")
            .catch(() => showError("Unable to fetch posts"));

        this.$store.dispatch("tokens/fetchTokens", this.school.id);
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
