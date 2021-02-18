<template>
    <div v-if="employment">
        <page-header title="Edit previous employment info" :back="true">
            <delete-employment
                :employer="employment.employer"
                :employment-id="employment.id"
            ></delete-employment>
        </page-header>

        <previous-employment-form
            :employment="employment"
        ></previous-employment-form>
    </div>
</template>

<script type="text/babel">
import PreviousEmploymentForm from "./PreviousEmploymentForm";
import DeleteEmployment from "./DeleteEmployment";
import { showError } from "../../../libs/notifications";
import PageHeader from "../PageHeader";
export default {
    components: {
        PageHeader,
        PreviousEmploymentForm,
        DeleteEmployment,
    },

    computed: {
        employment() {
            return this.$store.getters["profile/employmentById"](
                this.$route.params.employment
            );
        },
    },

    mounted() {
        this.$store
            .dispatch("profile/fetchPreviousEmployments")
            .catch(() => showError("Unable to fetch employment history"));
    },
};
</script>
