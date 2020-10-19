<template>
    <div class="" v-if="school">
        <page-header :title="trns('show_profile.title')">
            <router-link to="/profile/edit" class="btn btn-primary">{{
                trns("actions.edit")
            }}</router-link>
        </page-header>

        <div class="max-w-xl p-6 rounded-lg shadow-lg">
            <div class="flex flex-col md:flex-row justify-between">
                <div class="flex-1">
                    <p class="type-h3">{{ school.name }}</p>
                    <p class="type-b2 text-sky-blue">{{ school.location }}</p>
                    <p class="type-b1 my-4">{{ school.introduction }}</p>
                </div>
                <div class="w-40 mx-auto">
                    <image-upload
                        class="mx-auto mt-12 md:mt-0"
                        width="40"
                        height="40"
                        :round="false"
                        :initial-src="school.logo.thumb"
                        :upload-path="`/api/schools/${school.id}/logos`"
                        @uploaded="
                            $store.dispatch('schoolprofile/refreshProfile')
                        "
                    ></image-upload>
                </div>
            </div>
            <div
                class="border-t border-gray-300 space-x-4 flex pt-2 divide-x divide-gray-400"
            >
                <span
                    class="pl-4 type-b4"
                    v-for="school_type in school.school_types_names"
                    >{{ school_type }}</span
                >
            </div>
        </div>

        <div class="my-12">
            <div class="flex justify-between mb-4">
                <p class="type-h3">{{ trns("show_profile.images") }}</p>
                <router-link class="text-btn" to="/profile/images">{{
                    trns("actions.edit_images")
                }}</router-link>
            </div>

            <div class="flex space-x-8 w-full w-full overflow-x-auto">
                <div
                    v-for="image in school.images"
                    class="w-40 h-32 flex-shrink-0"
                >
                    <img
                        :src="image.thumb"
                        alt=""
                        class="w-full h-full object-cover"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../Components/PageHeader";
import ImageUpload from "../../Components/ImageUpload";
export default {
    components: {
        PageHeader,
        ImageUpload,
    },

    computed: {
        school() {
            return this.$store.state.schoolprofile.current_school;
        },
    },
};
</script>
