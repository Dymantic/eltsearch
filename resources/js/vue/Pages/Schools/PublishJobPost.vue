<template>
    <div v-if="post">
        <page-header :title="trns('publish_post.title')">
            <router-link
                :to="`/job-posts/${post.id}/show`"
                class="type-b2 text-navy hover:text-sky-blue"
                >{{ trns("publish_post.view_button") }}</router-link
            >
        </page-header>

        <incomplete-job-post-review
            :post="post"
            v-if="!can_publish"
        ></incomplete-job-post-review>

        <div v-if="can_publish">
            <div class="my-12" v-if="post_status === 'disabled'">
                <p
                    class="rounded-lg border border-red-600 bg-red-100 p-4 max-w-md"
                >
                    {{ trns("publish_post.disabled_note") }}
                </p>
            </div>

            <div class="my-12" v-if="post_status === 'private'">
                <p class="max-w-lg">
                    {{
                        trns("publish_post.private_note", "", {
                            published: post.presented.first_published,
                            expires: post.presented.expires_on,
                        })
                    }}
                </p>
                <div class="my-12">
                    <submit-button
                        :waiting="waiting"
                        role="button"
                        @click.native="publish"
                        >{{ trns("publish_post.republish") }}</submit-button
                    >
                </div>
            </div>

            <div class="my-12" v-if="post_status === 'draft'">
                <div v-if="available_tokens === 0">
                    <p class="max-w-lg">
                        {{ trns("publish_post.no_tokens") }}
                    </p>
                    <div class="mt-6">
                        <router-link to="/tokens" class="btn btn-primary">{{
                            trns("publish_post.buy_token")
                        }}</router-link>
                    </div>
                </div>
                <div v-else>
                    <div class="mb-6">
                        <p>{{ trns("publish_post.ready") }}</p>
                        <p class="my-4">
                            {{
                                trns("publish_post.shown_until", "", {
                                    expires: one_month_later,
                                })
                            }}
                        </p>
                        <p
                            v-html="
                                trns('publish_post.single_cost', '', {
                                    remaining: available_tokens - 1,
                                })
                            "
                        ></p>
                    </div>

                    <submit-button
                        :waiting="waiting"
                        role="button"
                        @click.native="publish"
                        >Publish</submit-button
                    >
                </div>
            </div>

            <div class="my-12" v-if="post_status === 'live'">
                <p
                    class="max-w-lg"
                    v-html="
                        trns('publish_post.live_note', '', {
                            expires: post.presented.expires_on,
                        })
                    "
                ></p>
                <div class="my-12">
                    <submit-button
                        :waiting="waiting"
                        role="button"
                        @click.native="retract"
                        >{{ trns("publish_post.retract") }}</submit-button
                    >
                </div>
            </div>

            <div class="my-12" v-if="post_status === 'expired'">
                <div v-if="available_tokens === 0">
                    <p class="max-w-lg mt-6">
                        {{ trns("publish_post.no_tokens") }}
                    </p>
                    <div class="mt-6">
                        <router-link to="/tokens" class="btn btn-primary">{{
                            trns("publish_post.buy_token")
                        }}</router-link>
                    </div>
                </div>
                <div v-else>
                    <div class="mb-6">
                        <p class="max-w-lg">
                            {{ trns("publish_post.expired_note") }}
                        </p>
                        <p class="my-4">
                            {{
                                trns("publish_post.shown_until", "", {
                                    expires: one_month_later,
                                })
                            }}
                        </p>
                        <p
                            v-html="
                                trns('publish_post.single_cost', '', {
                                    remaining: available_tokens - 1,
                                })
                            "
                        ></p>
                    </div>

                    <submit-button
                        :waiting="waiting"
                        role="button"
                        @click.native="publish"
                        >Publish</submit-button
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

        post_status() {
            return this.post.presented.status.state;
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
            .catch(() => showError(this.trns("errors.fetch_job_posts")));

        this.$store.dispatch("tokens/fetchTokens", this.school.id);
    },

    methods: {
        publish() {
            this.waiting = true;

            this.$store
                .dispatch("posts/publishPost", this.post.id)
                .then(() => {
                    showSuccess(this.trns("publish_post.published"));
                })
                .catch(() => this.trns("publish_post.publish_error"))
                .then(() => (this.waiting = false));
        },

        retract() {
            this.$store
                .dispatch("posts/retractPost", this.post.id)
                .then(() => {
                    showSuccess(this.trns("publish_post.retracted"));
                })
                .catch(() => showError(this.trns("publish_post.retract_error")))
                .then(() => (this.waiting = false));
        },
    },
};
</script>
