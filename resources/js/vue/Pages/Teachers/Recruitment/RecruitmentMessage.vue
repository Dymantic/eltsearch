<template>
    <div v-if="message">
        <page-header title="School Message">
            <delete-confirmation
                @confirmed="dismissRecruitmentAttempt"
                :disabled="waiting_on_delete"
                item="this message"
                >Dismiss</delete-confirmation
            >
        </page-header>

        <div class="my-12 max-w-lg">
            <p class="my-6">
                {{ message.school.name }} has viewed your profile, and reached
                out to you. Should you wish, you may contact the school with the
                details they provided.
            </p>

            <div class="max-w-lg p-6 rounded-lg shadow">
                <p class="border-b border-gray-300 pb-6 mb-6 type-b1">
                    {{ message.message }}
                </p>
                <div class="flex flex-col md:flex-row justify-between">
                    <div class="flex leading-none items-center">
                        <person-icon class="h-5 mr-3 text-navy"></person-icon>
                        <p>{{ message.contact_person }}</p>
                    </div>
                    <div class="flex leading-none items-center">
                        <mail-icon class="h-5 mr-3 text-navy"></mail-icon>
                        <a
                            target="_blank"
                            class="hover:text-navy hover:underline text-sky-blue"
                            :href="`mailto:${message.email}`"
                            >{{ message.email }}</a
                        >
                    </div>
                    <div class="flex leading-none items-center">
                        <phone-icon class="h-5 mr-3 text-navy"></phone-icon>
                        <p>{{ message.phone }}</p>
                    </div>
                </div>
            </div>
            <div class="my-6"></div>
        </div>
        <div class="my-12 max-w-2xl">
            <p class="type-b2 border-b border-gray-300 pb-2 mb-6">
                School Info
            </p>
            <div class="flex">
                <div class="flex-1">
                    <p class="type-h3">{{ message.school.name }}</p>
                    <p class="text-gray-600 type-b2 my-3">
                        {{ message.school.location }}
                    </p>
                    <p>{{ message.school.introduction }}</p>
                </div>
                <div class="w-16 md:w-32 h-16 md:h-32 ml-6">
                    <img
                        :src="message.school.logo.thumb"
                        class="w-full h-full object-cover"
                    />
                </div>
            </div>
            <p class="my-6 type-b2">School Images</p>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-1">
                <div v-for="image in message.school.images" class="">
                    <img
                        :src="image.thumb"
                        class="w-full h-full object-cover"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../../Components/PageHeader";
import PersonIcon from "../../../Components/Icons/PersonIcon";
import MailIcon from "../../../Components/Icons/MailIcon";
import PhoneIcon from "../../../Components/Icons/PhoneIcon";
import DeleteConfirmation from "../../../Components/DeleteConfirmation";
import { showError, showSuccess } from "../../../../libs/notifications";
export default {
    components: {
        DeleteConfirmation,
        PhoneIcon,
        MailIcon,
        PersonIcon,
        PageHeader,
    },

    data() {
        return {
            waiting_on_delete: false,
        };
    },

    computed: {
        message() {
            return this.$store.getters["recruitments/byId"](
                this.$route.params.recruitment
            );
        },
    },

    mounted() {
        this.$store.dispatch("recruitments/fetch");
    },

    methods: {
        dismissRecruitmentAttempt() {
            this.waiting_on_delete = true;
            this.$store
                .dispatch("recruitments/dismiss", this.message.id)
                .then(() => {
                    showSuccess("Message dismissed");
                    this.$router.push("/notifications");
                })
                .catch(() => showError("Failed to dismiss message"))
                .then(() => (this.waiting_on_delete = false));
        },
    },
};
</script>
