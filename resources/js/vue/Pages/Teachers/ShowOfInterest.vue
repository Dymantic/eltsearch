<template>
    <div v-if="application" class="">
        <page-header title="Get in touch" :back="true">
            <router-link
                :to="`/applications/${application.id}/post`"
                class="text-btn mr-4"
                >View Post</router-link
            >
            <router-link
                :to="`/applications/${application.id}/details`"
                class="text-btn"
                >Your Application</router-link
            >
        </page-header>

        <div class="max-w-2xl" v-if="application.show_of_interest">
            <p class="type-b1">
                Hey, good news!
                <span class="type-b2">{{ application.post.school_name }}</span>
                has reviewed your application for
                <span class="type-b2">{{ application.post.position }}</span> and
                they would like you to take the next step and get in touch with
                them. Reach out with the following details:
            </p>

            <div class="mt-12">
                <p class="mb-1">
                    <span class="type-b2 text-navy">Contact person: </span
                    >{{ application.show_of_interest.name }}
                </p>
                <p class="mb-1">
                    <span class="type-b2 text-navy">Email: </span>
                    <a
                        target="_blank"
                        rel="nofollow"
                        :href="`mailto:application.show_of_interest.email`"
                        >{{ application.show_of_interest.email }}</a
                    >
                </p>
                <p class="mb-1">
                    <span class="type-b2 text-navy">Phone number: </span
                    >{{ application.show_of_interest.phone }}
                </p>
            </div>
        </div>
        <div v-else>
            <p>
                Sorry, {{ application.post.school_name }} have not responded to
                your application yet.
            </p>
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
