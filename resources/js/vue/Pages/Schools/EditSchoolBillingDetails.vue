<template>
    <div v-if="school">
        <page-header title="Billing Info"></page-header>

        <billing-info-form :school="school"></billing-info-form>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../Components/PageHeader";
import BillingInfoForm from "../../Components/Schools/BillingInfoForm";
export default {
    components: {
        BillingInfoForm,
        PageHeader,
    },

    computed: {
        school() {
            return this.$store.state.schoolprofile.current_school;
        },
    },
};
</script>
