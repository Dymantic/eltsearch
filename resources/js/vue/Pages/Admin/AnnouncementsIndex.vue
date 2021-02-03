<template>
    <div>
        <page-header title="Announcements">
            <multi-button text="New Announcement">
                <router-link to="/announcements/create-public"
                    >For Public</router-link
                >
                <router-link to="/announcements/create-teachers"
                    >For Teachers</router-link
                >
                <router-link to="/announcements/create-schools"
                    >For Schools</router-link
                >
            </multi-button>
        </page-header>

        <current-announcement
            :announcement="current_public"
            class="my-12"
            type="public"
        ></current-announcement>

        <current-announcement
            :announcement="current_schools"
            class="my-12"
            type="schools"
        ></current-announcement>

        <current-announcement
            :announcement="current_teachers"
            class="my-12"
            type="teachers"
        ></current-announcement>

        <div class="my-12">
            <p class="type-h4 mb-4">Upcoming Announcements</p>
            <p class="my-4 text-gray-600" v-show="!upcoming.length">
                There are no upcoming announcements at this time.
            </p>

            <div class="p-6 shadow rounded-lg">
                <div
                    class="mb-2 border-b border-gray-200"
                    v-for="announcement in upcoming"
                    :key="announcement.id"
                >
                    <div class="flex items-center">
                        <p class="type-b2 capitalize text-sky-blue w-20">
                            {{ announcement.type }}
                        </p>
                        <p class="type-b2 mx-4">{{ announcement.dates }}</p>

                        <router-link
                            class="text-sky-blue hover:text-navy"
                            :to="`/announcements/${announcement.id}/show`"
                            >View</router-link
                        >
                    </div>
                    <p class="py-2" v-html="announcement.body_formatted.en"></p>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../Components/PageHeader";
import MultiButton from "../../Components/MultiButton";
import CurrentAnnouncement from "./CurrentAnnouncement";
export default {
    components: { CurrentAnnouncement, PageHeader, MultiButton },

    computed: {
        current_public() {
            return this.$store.getters["announcements/currentForType"](
                "public"
            );
        },

        current_schools() {
            return this.$store.getters["announcements/currentForType"](
                "schools"
            );
        },

        current_teachers() {
            return this.$store.getters["announcements/currentForType"](
                "teachers"
            );
        },

        upcoming() {
            return this.$store.getters["announcements/upcoming"];
        },
    },

    mounted() {
        this.$store.dispatch("announcements/fetch");
    },
};
</script>
