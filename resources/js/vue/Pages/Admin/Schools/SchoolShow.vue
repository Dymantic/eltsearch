<template>
    <div>
        <page-header title="School Profile">
            <delete-confirmation
                v-if="can_disable"
                @confirmed="disable"
                btn-text="Disable profile"
                mode="primary"
                :disabled="waiting_on_disable"
                :message="`You are about to disable the profile of ${school_name}. The school's profile will no longer be visible or active on the site.`"
                >Disable</delete-confirmation
            >
            <delete-confirmation
                v-if="can_reinstate"
                @confirmed="reinstate"
                btn-text="Reinstate profile"
                mode="primary"
                :disabled="waiting_on_reinstate"
                :message="`You are about to reinstate the profile of ${school_name}. They will once again have full access to the school functions.`"
                >Reinstate</delete-confirmation
            >
        </page-header>

        <busy-loading v-show="fetching"></busy-loading>

        <div v-if="school">
            <div class="flex flex-col md:flex-row justify-between max-w-3xl">
                <div class="md:pr-8">
                    <div class="flex items-center">
                        <p class="type-h3 mr-3">{{ school.name }}</p>
                        <colour-label
                            colour="red"
                            text="Profile Disabled"
                            v-if="school.is_disabled"
                        ></colour-label>
                    </div>
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
import { showError, showSuccess } from "../../../../libs/notifications";
import DeleteConfirmation from "../../../Components/DeleteConfirmation";
import { disableSchool, reinstateSchool } from "../../../../api/admin/schools";
import ColourLabel from "../../../Components/ColourLabel";
export default {
    components: { ColourLabel, DeleteConfirmation, PageHeader, BusyLoading },

    data() {
        return {
            fetching: true,
            school: null,
            waiting_on_disable: false,
            waiting_on_reinstate: false,
        };
    },

    computed: {
        can_disable() {
            return this.school && !this.school.is_disabled;
        },

        can_reinstate() {
            return this.school && this.school.is_disabled;
        },

        school_name() {
            return this.school ? this.school.name : "this school";
        },
    },

    created() {
        this.fetch();
    },

    methods: {
        fetch() {
            this.fetching = true;
            this.$store
                .dispatch("schools/getById", {
                    school_id: this.$route.params.school,
                    force: true,
                })
                .then((school) => (this.school = school))
                .catch(() => showError("Failed to find school"))
                .then(() => (this.fetching = false));
        },

        disable() {
            this.waiting_on_disable = true;
            disableSchool(this.school.id)
                .then(() => {
                    this.fetch();
                    showSuccess("Profile disabled.");
                    this.$store.dispatch("schools/refresh");
                })
                .catch(() => showError("Failed to disable school profile"))
                .then(() => (this.waiting_on_disable = false));
        },

        reinstate() {
            this.waiting_on_reinstate = true;
            reinstateSchool(this.school.id)
                .then(() => {
                    this.fetch();
                    showSuccess("Profile reinstated.");
                    this.$store.dispatch("schools/refresh");
                })
                .catch(() => showError("Failed to reinstate school profile"))
                .then(() => (this.waiting_on_reinstate = false));
        },
    },
};
</script>
