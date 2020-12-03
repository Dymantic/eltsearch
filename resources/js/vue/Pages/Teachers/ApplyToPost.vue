<template>
    <div>
        <page-header title="Apply for Job"></page-header>

        <div class="my-12" v-if="post">
            <application-form :post="post"></application-form>
        </div>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../Components/PageHeader";
import { fetchPostBySlug } from "../../../api/teachers/posts";
import { showError } from "../../../libs/notifications";
import ApplicationForm from "../../Components/Teachers/ApplicationForm";
export default {
    components: { ApplicationForm, PageHeader },

    data() {
        return {
            post: null,
        };
    },

    mounted() {
        fetchPostBySlug(this.$route.params.post)
            .then((post) => (this.post = post))
            .catch(() => showError("Unable to find job post"));
    },
};
</script>
