<template>
    <div>
        <page-header title="Teachers">
            <router-link to="/teachers/browse" class="btn btn-primary"
                >Browse</router-link
            >
        </page-header>

        <div class="my-12 md:flex">
            <number-stat
                class="md:mr-6 mb-4"
                :stat="total_count"
                title="Total teachers on board"
            ></number-stat>
            <number-stat
                class="md:mr-6 mb-4"
                :stat="signed_up"
                title="Teachers signed up in the last month"
            ></number-stat>
        </div>

        <div class="my-12">
            <p class="type-h4 mb-6">Recent Signups</p>
            <div class="p-6 shadow rounded-lg">
                <div
                    v-for="teacher in recent"
                    :key="teacher.id"
                    class="flex items-center my-1 border-b border-gray-200 py-1"
                >
                    <div
                        class="w-8 h-8 rounded-full overflow-hidden mr-4 flex-shrink-0"
                    >
                        <img
                            :src="teacher.avatar"
                            class="w-full h-full object-cover"
                        />
                    </div>
                    <div class="flex flex-col md:flex-row">
                        <p class="w-48 truncate mr-4 type-b2 capitalize">
                            <router-link
                                :to="`/teachers/${teacher.id}/show`"
                                class="hover:text-sky-blue"
                                >{{ teacher.name }}</router-link
                            >
                        </p>
                        <p>{{ teacher.nationality }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../../Components/PageHeader";
import NumberStat from "../../../Components/NumberStat";
export default {
    components: { PageHeader, NumberStat },

    computed: {
        total_count() {
            return this.$store.state.teachers.total_count;
        },

        signed_up() {
            return this.$store.state.teachers.signed_up_last_month;
        },

        recent() {
            return this.$store.state.teachers.recent;
        },
    },

    mounted() {
        this.$store.dispatch("teachers/fetch");
    },
};
</script>
