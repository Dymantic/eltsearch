<template>
    <div v-if="school">
        <page-header :title="school.name"></page-header>

        <div>
            <sortable-gallery
                title="School Images"
                :images="school_images"
                :upload-url="`/api/schools/${school.id}/images`"
                @uploaded="refreshSchool"
                @image-cleared="refreshSchool"
                @upload-failed="handleFailure"
            ></sortable-gallery>
        </div>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../Components/PageHeader";
import SortableGallery from "../../Components/SortableGallery";
import { showError } from "../../../libs/notifications";
export default {
    components: {
        PageHeader,
        SortableGallery,
    },

    computed: {
        school() {
            return this.$store.state.schoolprofile.current_school;
        },

        school_images() {
            return this.school.images.map((image) => ({
                id: image.id,
                src: image.thumb,
                delete_url: `/api/schools/${this.school.id}/images/${image.id}`,
                position: 1,
            }));
        },
    },

    methods: {
        refreshSchool() {
            this.$store.dispatch("schoolprofile/refreshProfile");
        },

        handleFailure(message) {
            showError(message);
        },
    },
};
</script>
