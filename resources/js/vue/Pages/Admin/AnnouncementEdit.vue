<template>
    <div v-if="announcement">
        <page-header title="Edit Announcement">
            <delete-confirmation
                item="this announcement"
                :waiting="deleting"
                @confirmed="deleteAnnouncement"
                >Delete</delete-confirmation
            >
        </page-header>

        <div class="my-12">
            <announcement-form :announcement="announcement"></announcement-form>
        </div>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../Components/PageHeader";
import AnnouncementForm from "./AnnouncementForm";
import DeleteConfirmation from "../../Components/DeleteConfirmation";
import { showError, showSuccess } from "../../../libs/notifications";
export default {
    components: { DeleteConfirmation, AnnouncementForm, PageHeader },

    data() {
        return {
            deleting: false,
        };
    },

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

    methods: {
        deleteAnnouncement() {
            this.deleting = true;

            this.$store
                .dispatch("announcements/delete", this.announcement.id)
                .then(() => {
                    showSuccess("Announcement deleted");
                    this.$router.push("/announcements");
                })
                .catch(() => showError("Failed to delete announcement"));
        },
    },
};
</script>
