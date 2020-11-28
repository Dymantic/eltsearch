<template>
    <form @submit.prevent="submit" class="max-w-xl">
        <div class="my-6">
            <p class="type-h4">Announcement text:</p>
            <p class="text-gray-600 my-6">
                Preferably kept short and sweet, especially public
                announcements.
            </p>
            <text-field
                label="English"
                v-model="formData.body.en"
                :error-msg="formErrors.body"
            ></text-field>

            <text-field
                class="mt-4"
                label="Chinese"
                v-model="formData.body.zh"
            ></text-field>
        </div>

        <p class="my-8 type-h4">When should the announcement be shown</p>
        <div class="flex flex-col md:flex-row">
            <div class="mt-6 mr-8">
                <p class="font-bold mb-2">
                    Starts from:
                </p>
                <p class="text-sm text-red-600" v-show="formErrors.starts">
                    {{ formErrors.starts }}
                </p>
                <date-picker
                    v-model="formData.starts"
                    input-class="border-gray-300 border p-2"
                ></date-picker>
            </div>

            <div class="mt-6">
                <p class="font-bold mb-2">
                    Ends on:
                </p>
                <p class="text-sm text-red-600" v-show="formErrors.ends">
                    {{ formErrors.ends }}
                </p>
                <date-picker
                    v-model="formData.ends"
                    input-class="border-gray-300 border p-2"
                ></date-picker>
            </div>
        </div>

        <div class="my-6">
            <submit-button :waiting="waiting">Save Announcement</submit-button>
        </div>
    </form>
</template>

<script type="text/babel">
import DatePicker from "vuejs-datepicker";
import TextField from "../../Components/Forms/TextField";
import {
    clearValidationErrors,
    setValidationErrors,
} from "../../../libs/forms";
import { showError, showSuccess } from "../../../libs/notifications";
import SubmitButton from "../../Components/Forms/SubmitButton";
export default {
    components: { SubmitButton, TextField, DatePicker },

    props: ["announcement", "type"],

    data() {
        return {
            waiting: false,
            formData: {
                body: { en: "", zh: "" },
                starts: new Date(),
                ends: new Date(),
            },
            formErrors: {
                body: "",
                starts: "",
                ends: "",
            },
        };
    },

    computed: {
        saveAction() {
            if (this.announcement) {
                return "announcements/update";
            }

            const actions = {
                public: "announcements/createForPublic",
                teachers: "announcements/createForTeachers",
                schools: "announcements/createForSchools",
            };

            return actions[this.type];
        },

        payload() {
            if (this.announcement) {
                return {
                    announcement_id: this.announcement.id,
                    formData: this.formData,
                };
            }

            return this.formData;
        },
    },

    mounted() {
        if (this.announcement) {
            this.formData = {
                body: {
                    en: this.announcement.body.en,
                    zh: this.announcement.body.zh,
                },
                starts: new Date(this.announcement.starts_raw),
                ends: new Date(this.announcement.ends_raw),
            };
        }
    },

    methods: {
        submit() {
            this.waiting = true;
            this.formErrors = clearValidationErrors(this.formErrors);

            this.$store
                .dispatch(this.saveAction, this.payload)
                .then(this.onSuccess)
                .catch(this.onError)
                .then(() => (this.waiting = false));
        },

        onSuccess() {
            showSuccess("Announcement saved");
            this.$router.push("/announcements");
        },

        onError({ status, data }) {
            if (status === 422) {
                return (this.formErrors = setValidationErrors(
                    this.formErrors,
                    data.errors
                ));
            }
            showError("Failed to save announcement");
        },
    },
};
</script>
