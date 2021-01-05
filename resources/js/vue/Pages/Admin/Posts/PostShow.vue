<template>
    <div>
        <page-header title="Job Post">
            <delete-confirmation
                v-if="can_disable"
                @confirmed="disable"
                btn-text="Disable post"
                mode="primary"
                :disabled="waiting_on_disable"
                :message="`You are about to disable this post from ${school_name}. It will no longer be visible on the site.`"
                >Disable</delete-confirmation
            >
            <delete-confirmation
                v-if="can_reinstate"
                @confirmed="reinstate"
                btn-text="Reinstate profile"
                mode="primary"
                :disabled="waiting_on_reinstate"
                :message="`You are about to reinstate this post from ${school_name}. It will become public once again.`"
                >Reinstate</delete-confirmation
            >
        </page-header>

        <p v-show="!post && fetching">Fetching Post</p>
        <p v-show="!post && !fetching">This post does not exist.</p>

        <div v-if="post" class="my-12">
            <div class="mb-8 flex items-center">
                <p class="type-b2 text-gray-600 mr-3">Status:</p>
                <colour-label
                    :colour="post.status.colour"
                    :text="post.status.text"
                ></colour-label>
            </div>
            <job-post :post="post"></job-post>
        </div>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../../Components/PageHeader";
import JobPost from "../../../Components/JobPost";
import { showError, showSuccess } from "../../../../libs/notifications";
import {
    disableJobPost,
    reinstateJobPost,
} from "../../../../api/admin/job_posts";
import DeleteConfirmation from "../../../Components/DeleteConfirmation";
import ColourLabel from "../../../Components/ColourLabel";
export default {
    components: { ColourLabel, DeleteConfirmation, JobPost, PageHeader },

    data() {
        return {
            fetching: true,
            post: null,
            waiting_on_disable: false,
            waiting_on_reinstate: false,
        };
    },

    computed: {
        is_disabled() {
            return this.post && this.post.is_disabled;
        },

        can_disable() {
            return this.post && !this.post.is_disabled;
        },

        can_reinstate() {
            return this.post && this.post.is_disabled;
        },

        school_name() {
            return this.post ? this.post.school_name : "school";
        },
    },

    mounted() {
        this.fetch();
    },

    methods: {
        fetch() {
            this.$store
                .dispatch("posts/getById", this.$route.params.post)
                .then((post) => {
                    this.post = post;
                })
                .catch(() => showError("Unable to find post"))
                .then(() => (this.fetching = false));
        },

        disable() {
            this.waiting_on_disable = true;
            disableJobPost(this.post.id)
                .then(() => {
                    this.$store.dispatch("posts/refresh");
                    this.fetch();
                    showSuccess("Job post disabled");
                })
                .catch(() => showError("Unable to disable post."))
                .then(() => (this.waiting_on_disable = false));
        },

        reinstate() {
            this.waiting_on_reinstate = true;
            reinstateJobPost(this.post.id)
                .then(() => {
                    this.$store.dispatch("posts/refresh");
                    this.fetch();
                    showSuccess("Job post reinstated");
                })
                .catch(() => showError("Unable to reinstate post."))
                .then(() => (this.waiting_on_reinstate = false));
        },
    },
};
</script>
