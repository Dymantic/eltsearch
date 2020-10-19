<template>
    <div v-if="application">
        <page-header :title="trns('contact_applicant.title')"></page-header>

        <div class="max-w-3xl">
            <p class="my-12 max-w-lg">
                {{ trns("contact_applicant.instruction") }}
            </p>

            <div class="my-12">
                <p class="type-h4 mb-3">
                    {{ trns("contact_applicant.direct") }}
                </p>
                <p class="mb-1">
                    <span class="type-b2"
                        >{{ trns("contact_applicant.email") }}: </span
                    >{{
                        application.email ||
                        trns("contact_applicant.not_provided")
                    }}
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

            <div>
                <p class="type-h4 mb-3">
                    {{ trns("contact_applicant.inform") }}
                </p>
                <show-of-interest-form
                    :application-id="application.id"
                ></show-of-interest-form>
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
    },

    created() {
        return this.$store.dispatch("applications/fetchApplications");
    },
};
</script>
