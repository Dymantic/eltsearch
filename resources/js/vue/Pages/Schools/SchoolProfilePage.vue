<template>
    <div>
        <page-header title="School Profile">
            <router-link to="/profile/edit" class="btn btn-primary"
                >Edit</router-link
            >
        </page-header>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../Components/PageHeader";
export default {
    components: {
        PageHeader,
    },
};
</script>
