<template>
    <div v-if="generalInfo">
        <profile-disabled
            v-if="is_disabled"
            class="my-8 max-w-lg mx-auto"
        ></profile-disabled>

        <div class="max-w-xl mx-auto p-6 rounded-lg shadow">
            <div class="flex flex-col md:flex-row justify-between">
                <div class="flex-1">
                    <p class="type-h3">{{ generalInfo.name }}</p>
                    <p class="mt-3 type-h4 text-gray-600">
                        {{ generalInfo.email }}
                    </p>
                    <p class="mt-4">{{ generalInfo.nationality }}</p>

                    <div class="mt-6">
                        <p>
                            <span class="type-b2">Native Language: </span
                            ><span>{{ generalInfo.native_language }}</span>
                        </p>

                        <p>
                            <span class="type-b2">Other Languages: </span
                            ><span>{{ generalInfo.other_languages }}</span>
                        </p>
                        <p>
                            <span class="type-b2">Born: </span
                            ><span>{{ generalInfo.date_of_birth }}</span>
                        </p>
                        <p>
                            <span class="type-b2"
                                >Years of Teaching Experience: </span
                            ><span>{{ generalInfo.years_experience }}</span>
                        </p>
                    </div>
                </div>
                <div>
                    <image-upload
                        class="mx-auto mt-12 md:mt-0"
                        width="32"
                        height="32"
                        :round="true"
                        :initial-src="profile.avatar"
                        :upload-path="`/api/teachers/avatar`"
                        @uploaded="$store.dispatch('profile/refreshBasicInfo')"
                    ></image-upload>
                </div>
            </div>
            <div class="flex justify-end mt-4">
                <router-link to="/general-info/edit" class="btn btn-primary"
                    >Edit Info</router-link
                >
            </div>
        </div>

        <div
            class="max-w-xl shadow rounded-lg p-6 mx-auto my-12"
            v-if="education"
        >
            <p class="type-h3">Education</p>

            <p class="type-h4 mt-3">
                {{ education.education_qualification }}
                <span
                    class="type-b3 text-gray-600"
                    v-show="education.education_level"
                    >({{ education.education_level }})</span
                >
            </p>
            <p class="type-b1 text-gray-600 mt-4" v-if="missing_education">
                Please set your education information.
            </p>
            <p class="type-b1 mt-1">{{ education.education_institution }}</p>

            <div class="flex justify-end mt-4">
                <router-link to="/education/edit" class="btn btn-primary"
                    >Edit</router-link
                >
            </div>
        </div>

        <div class="my-12 max-w-xl mx-auto p-6 shadow rounded-lg">
            <teacher-location></teacher-location>
        </div>
    </div>
</template>

<script type="text/babel">
import TeacherLocation from "../../Components/Teachers/TeacherLocation";
import ImageUpload from "../../Components/ImageUpload";
import { showError } from "../../../libs/notifications";
import ProfileDisabled from "../../Components/Teachers/ProfileDisabled";
export default {
    components: {
        ProfileDisabled,
        ImageUpload,
        TeacherLocation,
    },

    computed: {
        profile() {
            return this.$store.state.profile;
        },

        generalInfo() {
            return this.$store.state.profile.general_info;
        },

        education() {
            return this.$store.state.profile.education_info;
        },

        missing_education() {
            return (
                !this.education.education_qualification &&
                !this.education.education_level
            );
        },

        is_disabled() {
            return this.$store.getters["profile/profile_disabled"];
        },
    },

    created() {
        this.$store
            .dispatch("profile/fetchGeneralInfo")
            .catch(() => showError("Failed to fetch info"));

        this.$store
            .dispatch("profile/fetchEducationInfo")
            .catch(() => showError("Failed to fetch education info"));
    },
};
</script>
