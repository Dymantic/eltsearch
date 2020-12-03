<template>
    <div>
        <page-header title="Recent Job Matches"></page-header>

        <div class="my-12">
            <p class="text-grey-600" v-show="!matches.length">
                There are no job matches for you at the moment.
            </p>
            <div
                v-for="match in matches"
                :key="match.id"
                class="mb-8 shadow p-6 rounded-lg relative"
            >
                <p class="type-b2">{{ match.matched_on }}</p>
                <div class="flex flex-col md:flex-row md:items-center mt-4">
                    <img
                        :src="match.post.logo.thumb"
                        class="absolute md:static top-0 right-0 w-8 m-6 md:m-0"
                    />
                    <p class="md:mx-6">{{ match.post.position }}</p>
                    <p class="md:mx-6">{{ match.post.school_name }}</p>
                    <p class="md:mx-6">{{ match.post.area }}</p>
                </div>
                <div class="mt-4 flex justify-end">
                    <router-link
                        :to="`/job-matches/${match.id}/post`"
                        class="text-navy hover:text-sky-blue type-b2"
                        >View Post</router-link
                    >
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../Components/PageHeader";
export default {
    components: { PageHeader },

    computed: {
        matches() {
            return this.$store.state.matches.all;
        },
    },

    mounted() {
        this.$store.dispatch("matches/fetch");
    },
};
</script>
