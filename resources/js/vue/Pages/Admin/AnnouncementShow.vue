<template>
    <div v-if="announcement">
        <page-header :title="`${announcement.type} Announcement`">
            <router-link
                :to="`/announcements/${announcement.id}/edit`"
                class="btn btn-primary"
                >Edit</router-link
            >
        </page-header>

        <div class="my-12">
            <p class="type-b2 text-sky-blue">Dates</p>
            <p class="type-h4 mb-6">{{ announcement.dates }}</p>

            <p class="type-b2 text-sky-blue">English</p>
            <p class="type-h4 mb-6" v-html="announcement.body_formatted.en"></p>

            <p class="type-b2 text-sky-blue">Chinese</p>
            <p class="type-h4 mb-6" v-html="announcement.body_formatted.zh"></p>
        </div>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../Components/PageHeader";
export default {
    components: { PageHeader },

    computed: {
        announcement() {
            return this.$store.getters["announcements/byId"](
                this.$route.params.announcement
            );
        },
    },

    mounted() {
        this.$store.dispatch("announcements/fetch");
    },
};
</script>
