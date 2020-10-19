<template>
    <div v-if="application">
        <page-header title="Job Post Application">
            <router-link to="/applications" class="muted-btn"
                >&larr; Job applications</router-link
            >
        </page-header>
        <div class="my-12">
            <p class="mb-2">
                <span class="type-b2 text-navy">Position: </span>
                <span>{{ application.post.position }}</span>
            </p>
            <p class="mb-10">
                <span class="type-b2 text-navy">School: </span>
                <span>{{ application.post.school_name }}</span>
            </p>

            <p class="type-b2 text-navy mb-4">Cover letter</p>
            <div class="type-b1" v-html="application.cover_letter"></div>

            <div class="my-10">
                <p class="mb-2">
                    <span class="type-b2 text-navy">Email: </span>
                    <span>{{ application.email }}</span>
                </p>
                <p class="mb-10">
                    <span class="type-b2 text-navy">Phone number: </span>
                    <span>{{ application.phone }}</span>
                </p>
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
        application() {
            return this.$store.getters["applications/byId"](
                this.$route.params.application
            );
        },
    },

    created() {
        this.$store.dispatch("applications/fetchApplications");
    },
};
</script>
