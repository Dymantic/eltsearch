<template>
    <div v-if="post">
        <page-header title="Matched Job">
            <delete-confirmation
                :disabled="waiting_on_delete"
                item="this job match"
                @confirmed="dismissMatch"
                >Dismiss Match</delete-confirmation
            >
        </page-header>
        <div class="my-12">
            <job-post
                :apply-url="`/job-matches/${match.id}/apply`"
                :post="post"
            ></job-post>
        </div>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../Components/PageHeader";
import JobPost from "../../Components/JobPost";
import DeleteConfirmation from "../../Components/DeleteConfirmation";
import { showError, showSuccess } from "../../../libs/notifications";
export default {
    components: { DeleteConfirmation, JobPost, PageHeader },

    data() {
        return {
            waiting_on_delete: false,
        };
    },

    computed: {
        match() {
            return this.$store.getters["matches/byId"](
                this.$route.params.job_match
            );
        },

        post() {
            return this.match ? this.match.post : null;
        },
    },

    mounted() {
        this.$store.dispatch("matches/fetch");
    },

    methods: {
        dismissMatch() {
            this.waiting_on_delete = true;

            this.$store
                .dispatch("matches/dismiss", this.match.id)
                .then(() => {
                    showSuccess("Job match dismissed.");
                    this.$router.push("/job-matches");
                })
                .catch(() => showError("Failed to dismiss match."))
                .then(() => (this.waiting = false));
        },
    },
};
</script>
