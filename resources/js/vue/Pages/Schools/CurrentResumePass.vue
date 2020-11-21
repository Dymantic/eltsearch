<template>
    <div>
        <page-header title="School Resume Pass"></page-header>

        <div class="my-12">
            <p>{{ passInfo.has_access ? "Green Light" : "Red Light" }}</p>
            <p>{{ passInfo.expires_on }}</p>
            <p>{{ passInfo.days_remaining }}</p>
            <router-link to="/resume-passes/buy">Get access</router-link>
        </div>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../Components/PageHeader";
export default {
    components: { PageHeader },

    computed: {
        passInfo() {
            return this.$store.state.purchases.resumePass;
        },
    },

    mounted() {
        this.$store.dispatch("purchases/checkResumePass");
    },
};
</script>
