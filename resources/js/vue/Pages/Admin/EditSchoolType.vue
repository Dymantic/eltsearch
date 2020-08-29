<template>
    <div v-if="type">
        <page-header :title="`Edit ${type.name.en}`"></page-header>
        <school-type-form :type="type"></school-type-form>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../Components/PageHeader";
import SchoolTypeForm from "../../Components/Admin/SchoolTypeForm";
export default {
    components: {
        PageHeader,
        SchoolTypeForm,
    },

    computed: {
        type() {
            return this.$store.getters["schooltypes/schoolTypeById"](
                this.$route.params.type
            );
        },
    },

    mounted() {
        this.$store.dispatch("schooltypes/refreshAll");
    },
};
</script>
