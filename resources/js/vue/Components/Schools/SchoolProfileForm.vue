<template>
    <form @submit.prevent="submit">
        <text-field
            class="my-6 max-w-md"
            label="School name"
            v-model="formData.name"
            :error-msg="formErrors.name"
        ></text-field>

        <textarea-field
            class="my-6 max-w-lg"
            label="Introduction"
            v-model="formData.introduction"
            :error-msg="formErrors.introduction"
        ></textarea-field>

        <div class="my-8 max-w-lg">
            <p class="font-bold mb-1">Main School Location</p>
            <div class="flex justify-between">
                <p>{{ current_location }}</p>
                <choose-location
                    label="Set location"
                    @chosen="setArea"
                ></choose-location>
            </div>
        </div>

        <div class="my-8 max-w-lg">
            <p class="font-bold mb-1">Type of school</p>
            <p class="my-3 text-gray-600">
                Choose what types your school falls into. You may select more
                than one.
            </p>
            <school-type-options
                :options="schoolTypes"
                v-model="formData.school_types"
            ></school-type-options>
        </div>

        <div class="my-8">
            <submit-button :waiting="waiting"
                >Update School Profile</submit-button
            >
        </div>
    </form>
</template>

<script type="text/babel">
import TextField from "../../Components/Forms/TextField";
import TextareaField from "../../Components/Forms/TextareaField";
import ChooseLocation from "../../Components/Teachers/ChooseLocation";
import SchoolTypeOptions from "../../Components/Schools/SchoolTypeOptions";
import SubmitButton from "../../Components/Forms/SubmitButton";
import {
    clearValidationErrors,
    setValidationErrors,
} from "../../../libs/forms";
import { showError, showSuccess } from "../../../libs/notifications";
export default {
    components: {
        TextField,
        TextareaField,
        ChooseLocation,
        SchoolTypeOptions,
        SubmitButton,
    },

    props: ["profile", "school-types"],

    data() {
        return {
            waiting: false,
            formData: {
                name: this.profile.name,
                introduction: this.profile.introduction,
                area_id: this.profile.area_id,
                school_types: this.profile.school_types.map((type) => type.id),
            },
            formErrors: {
                name: "",
                introduction: "",
                area_id: "",
                school_types: "",
            },
        };
    },

    computed: {
        current_location() {
            if (!this.formData.area_id) {
                return "No location set";
            }

            const loc = this.$store.getters["locations/area_info"](
                this.formData.area_id
            );

            if (!loc) {
                return "No location set";
            }

            return `${loc.area_name}, ${loc.region_name}, ${loc.country_name}`;
        },
    },

    created() {
        this.$store.dispatch("locations/fetchLocations", "zh");
    },

    mounted() {
        // this.setForm();
    },

    methods: {
        setArea(area) {
            this.formData.area_id = area;
        },

        setForm() {
            this.formData = {
                name: this.profile.name,
                introduction: this.profile.introduction,
                area_id: this.profile.area_id,
                school_types: this.profile.school_types.map((type) => type.id),
            };
        },

        submit() {
            this.waiting = true;
            this.formErrors = clearValidationErrors(this.formErrors);

            this.$store
                .dispatch("schoolprofile/updateProfile", {
                    school_id: this.profile.id,
                    formData: this.formData,
                })
                .then(this.onSuccess)
                .catch(this.onError)
                .then(() => (this.waiting = false));
        },

        onSuccess() {
            showSuccess("School profile updated.");
            this.$router.push("/profile");
        },

        onError({ status, data }) {
            if (status === 422) {
                return (this.formErrors = setValidationErrors(
                    this.formErrors,
                    data.errors
                ));
            }
            showError("Failed to save profile info.");
        },
    },
};
</script>
