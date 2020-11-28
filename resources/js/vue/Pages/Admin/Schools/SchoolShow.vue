<template>
    <div>
        <page-header title="School Profile"></page-header>

        <busy-loading v-show="fetching"></busy-loading>

        <div v-if="school">
            <div class="flex flex-col md:flex-row justify-between max-w-3xl">
                <div class="md:pr-8">
                    <p class="type-h3">{{ school.name }}</p>
                    <p class="type-b2 my-2">
                        {{ school.school_types_names.join(", ") }}
                    </p>
                    <p class="my-2">{{ school.location }}</p>
                    <p class="my-2 max-w-sm">{{ school.introduction }}</p>
                </div>
                <div class="w-48 mx-auto mt-6 md:mt-0">
                    <img :src="school.logo.thumb" class="w-full" />
                </div>
            </div>

            <div class="max-w-3xl shadow p-6 rounded-lg my-12">
                <p class="type-h4 mb-3">School Images</p>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div v-for="image in school.images" class="w-full h-full">
                        <img
                            :src="image.thumb"
                            class="w-full h-full object-cover"
                        />
                    </div>
                </div>
                <p v-if="!school.images.length" class="text-gray-600">
                    {{ school.name }} hasn't uploaded any images yet.
                </p>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../../Components/PageHeader";
import BusyLoading from "../../../Components/BusyLoading";
import { showError } from "../../../../libs/notifications";
export default {
    components: { PageHeader, BusyLoading },

    data() {
        return {
            fetching: true,
            school: null,
        };
    },

    created() {
        this.$store
            .dispatch("schools/getById", this.$route.params.school)
            .then((school) => (this.school = school))
            .catch(() => showError("Failed to find school"))
            .then(() => (this.fetching = false));
    },
};
</script>
