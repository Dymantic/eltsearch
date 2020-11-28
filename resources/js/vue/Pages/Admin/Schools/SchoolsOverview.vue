<template>
    <div>
        <page-header title="Schools Overview">
            <router-link class="btn btn-primary" to="/schools/browse"
                >Browse</router-link
            >
        </page-header>

        <div class="my-12 flex flex-col md:flex-row flex-wrap">
            <number-stat
                class="mr-4 mb-4"
                :stat="total_count"
                title="Total schools on board"
            ></number-stat>
            <number-stat
                class="mr-4 mb-4"
                :stat="sign_ups"
                title="Signed up in the last month"
            ></number-stat>
        </div>

        <div class="my-12">
            <p class="type-h4 mb-6">Recently Signed Up</p>
            <div class="p-6 rounded-lg shadow">
                <div
                    v-for="school in recent"
                    :key="school.id"
                    class="flex items-center my-1 border-b border-gray-200"
                >
                    <div class="w-6 h-6 rounded-full overflow-hidden mx-4">
                        <img
                            :src="school.logo.thumb"
                            class="w-full h-full object-contain"
                        />
                    </div>

                    <p class="w-64 truncate mr-4 type-b2">
                        <router-link
                            :to="`/schools/${school.id}/show`"
                            class="hover:text-sky-blue"
                            >{{ school.name }}</router-link
                        >
                    </p>

                    <p class="w-48 truncate mr-4">{{ school.location }}</p>
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
        total_count() {
            return this.$store.state.schools.total_count;
        },

        recent() {
            return this.$store.state.schools.recent;
        },

        sign_ups() {
            return this.$store.state.schools.signed_up_last_month;
        },
    },

    mounted() {
        this.$store.dispatch("schools/fetch");
    },
};
</script>
