<template>
    <div v-if="post">
        <page-header :title="trns('post_images.title')">
            <router-link
                :to="`/job-posts/${post.id}/show`"
                class="text-btn mr-4"
                >{{ trns("post_images.actions.view") }}</router-link
            >
            <router-link :to="`/job-posts/`" class="muted-btn"
                >&larr; {{ trns("post_images.actions.back") }}</router-link
            >
        </page-header>

        <div>
            <sortable-gallery
                :title="trns('post_images.gallery_title')"
                :images="post_images"
                :upload-url="`/api/job-posts/${post.id}/images`"
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
        post() {
            return this.$store.getters["posts/postById"](
                this.$route.params.post
            );
        },

        post_images() {
            return this.post.presented.images.map((image) => ({
                id: image.id,
                src: image.thumb,
                delete_url: `/api/job-posts/${this.post.id}/images/${image.id}`,
                position: 1,
            }));
        },
    },

    mounted() {
        this.$store.dispatch("posts/fetchPosts");
    },

    methods: {
        refreshSchool() {
            this.$store.dispatch("posts/refreshPosts");
        },

        handleFailure(message) {
            showError(message);
        },
    },
};
</script>
