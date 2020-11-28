<template>
    <div>
        <page-header title="Job Posts">
            <router-link to="/job-posts/browse" class="btn btn-primary"
                >Browse</router-link
            >
        </page-header>

        <div class="my-12 flex flex-col md:flex-row flex-wrap">
            <number-stat
                class="mr-4 mb-4"
                :stat="total_live"
                title="Job posts currently live"
            ></number-stat>
            <number-stat
                class="mr-4 mb-4"
                :stat="last_week"
                title="Posted in the last week"
            ></number-stat>
        </div>

        <div class="my-12">
            <p class="type-h4 mb-6">Recently Published</p>
            <div class="p-6 rounded-lg shadow">
                <div
                    v-for="post in recent"
                    :key="post.id"
                    class="flex items-center my-1 border-b border-gray-200"
                >
                    <p class="type-b2">{{ post.first_published }}</p>
                    <div class="w-6 h-6 rounded-full overflow-hidden mx-4">
                        <img
                            :src="post.logo.thumb"
                            class="w-full h-full object-contain"
                        />
                    </div>

                    <p class="w-48 truncate mr-4 type-b2">
                        <router-link
                            :to="`/job-posts/${post.id}/show`"
                            class="hover:text-sky-blue"
                            >{{ post.position }}</router-link
                        >
                    </p>

                    <p class="w-48 truncate mr-4">{{ post.school_name }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../../Components/PageHeader";
import NumberStat from "../../../Components/NumberStat";
export default {
    components: { NumberStat, PageHeader },

    computed: {
        total_live() {
            return this.$store.state.posts.total_live;
        },

        last_week() {
            return this.$store.state.posts.posted_in_last_week;
        },

        recent() {
            return this.$store.state.posts.recent;
        },
    },

    mounted() {
        this.$store.dispatch("posts/fetch");
    },
};
</script>
