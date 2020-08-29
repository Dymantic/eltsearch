<template>
    <div>
        <page-header title="Add a New School Type">
            <router-link class="muted-btn" to="/school-types"
                >&larr; Back</router-link
            >
        </page-header>
        <school-type-form></school-type-form>
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
};
</script>
