<template>
    <div class="" v-if="school">
        <page-header :title="trns('show_profile.title')"> </page-header>

        <profile-disabled v-if="is_disabled" class="my-8"></profile-disabled>

        <div class="max-w-3xl p-6 rounded-lg shadow-lg">
            <div class="mb-2 pb-2 border-b border-gray-300">
                <p class="type-h3">{{ school.name }}</p>
            </div>
            <div class="flex flex-col md:flex-row justify-between">
                <div class="flex-1 lg:pr-16 md:pr-8">
                    <p class="type-b2 text-sky-blue">{{ school.location }}</p>
                    <p>{{ school.school_types_names.join(", ") }}</p>
                    <p
                        class="type-b1 my-4 overflow-auto"
                        style="max-height: 20rem;"
                        v-html="school.introduction_formatted"
                    ></p>
                </div>
                <div class="w-40 mx-auto">
                    <p class="text-center type-b2 mb-2">
                        {{ trns("show_profile.logo") }}:
                    </p>
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
            <div class="flex justify-end mt-6">
                <router-link to="/profile/edit" class="btn btn-primary">{{
                    trns("actions.edit")
                }}</router-link>
            </div>
        </div>

        <div class="my-12 max-w-3xl rounded-lg shadow p-6">
            <div class="flex justify-between mb-4 border-b border-gray-300">
                <p class="type-h3">{{ trns("show_profile.images") }}</p>
            </div>

            <p v-show="school.images.length === 0">
                {{ trns("show_profile.no_images") }}
            </p>

            <div class="flex space-x-8 w-full w-full overflow-x-auto">
                <div
                    v-for="image in school.images"
                    class="w-40 h-32 flex-shrink-0"
                >
                    <img
                        :src="image.thumb"
                        alt=""
                        class="w-full h-full object-contain"
                    />
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <router-link class="btn btn-primary" to="/profile/images">{{
                    trns("actions.edit_images")
                }}</router-link>
            </div>
        </div>

        <div class="my-12 p-6 shadow-lg rounded-lg max-w-3xl">
            <billing-details-summary :school="school"></billing-details-summary>
        </div>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../Components/PageHeader";
import ImageUpload from "../../Components/ImageUpload";
import BillingDetailsSummary from "../../Components/Schools/BillingDetailsSummary";
import ProfileDisabled from "../../Components/Schools/ProfileDisabled";
export default {
    components: {
        ProfileDisabled,
        BillingDetailsSummary,
        PageHeader,
        ImageUpload,
    },

    computed: {
        school() {
            return this.$store.state.schoolprofile.current_school;
        },

        is_disabled() {
            return this.$store.getters["schoolprofile/is_disabled"];
        },
    },
};
</script>
