<template>
    <form @submit.prevent="submit" class="max-w-xl">
        <div class="my-6">
            <p class="type-h4">Announcement text:</p>
            <p class="text-gray-600 my-6">
                Preferably kept short and sweet, especially public
                announcements.
            </p>
            <div class="mb-8">
                <p class="type-b2">Adding links to announcements:</p>
                <p>
                    You may use Markdown formatting to add links to the text.
                </p>
                <p>Links are written as [link text](link address)</p>
                <p class="my-2">
                    <strong>E.g. </strong>Click [here](https://example.com) for
                    more info
                </p>
            </div>
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

        <div class="my-12">
            <p class="mt-12 type-h4">Is this announcement "urgent"?</p>
            <checkbox-input
                v-model="formData.urgent"
                :value="true"
                label="Yes, it is urgent"
                help-text="Urgent announcements will be styled more drastically to try attract attention. Only use if necessary."
            ></checkbox-input>
        </div>

        <p class="mt-12 type-h4">When should the announcement be shown</p>
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
import CheckboxInput from "../../Components/Forms/CheckboxInput";
export default {
    components: { CheckboxInput, SubmitButton, TextField, DatePicker },

    props: ["announcement", "type"],

    data() {
        return {
            waiting: false,
            formData: {
                body: { en: "", zh: "" },
                starts: new Date(),
                ends: new Date(),
                urgent: false,
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
                urgent: this.announcement.is_urgent,
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
