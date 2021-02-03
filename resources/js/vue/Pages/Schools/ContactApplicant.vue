<template>
    <div v-if="application">
        <page-header :title="trns('contact_applicant.title')"></page-header>

        <div class="my-12" v-if="school_disabled">
            <p class="max-w-xl p-6 border-red-600 border rounded-lg bg-red-100">
                {{ trns("recruit.profile_disabled") }}
            </p>
        </div>

        <div class="max-w-3xl" v-else>
            <p class="my-12 max-w-lg">
                {{ trns("contact_applicant.instruction") }}
            </p>

            <div class="my-12">
                <p class="type-h4 mb-3">
                    {{ trns("contact_applicant.direct") }}
                </p>
                <p class="mb-1">
                    <span class="type-b2"
                        >{{ trns("contact_applicant.email") }}:
                    </span>
                    <span v-if="application.email">
                        <a
                            target="_blank"
                            rel="nofollow"
                            :href="`mailto:${application.email}`"
                            >{{ application.email }}</a
                        >
                    </span>
                    <span v-else>
                        {{ trns("contact_applicant.not_provided") }}
                    </span>
                </p>
                <p>
                    <span class="type-b2"
                        >{{ trns("contact_applicant.phone") }}: </span
                    >{{
                        application.phone ||
                        trns("contact_applicant.not_provided")
                    }}
                </p>
            </div>

            <p class="type-h4 mb-3">
                {{ trns("contact_applicant.inform") }}
            </p>
            <div v-if="!application.shown_interest">
                <show-of-interest-form
                    :application-id="application.id"
                ></show-of-interest-form>
            </div>
            <div v-else>
                {{ trns("contact_applicant.already_shown_interest") }}
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../Components/PageHeader";
import ShowOfInterestForm from "../../Components/Schools/ShowOfInterestForm";
export default {
    components: {
        PageHeader,
        ShowOfInterestForm,
    },

    computed: {
        application() {
            return this.$store.getters["applications/byId"](
                this.$route.params.application
            );
        },

        school_disabled() {
            return this.$store.getters["schoolprofile/is_disabled"];
        },
    },

    created() {
        return this.$store.dispatch("applications/fetchApplications");
    },
};
</script>
