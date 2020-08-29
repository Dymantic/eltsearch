<template>
    <div>
        <page-header title="School Types">
            <router-link class="btn btn-primary" to="/school-types/create"
                >Add School Type</router-link
            >
        </page-header>
        <div>
            <div
                v-for="type in school_types"
                :key="type.id"
                class="p-4 shadow my-6 relative"
            >
                <p class="fotn-bold mb-2">{{ type.name.en }}</p>
                <p class="text-gray-600">{{ type.name.zh }}</p>
                <div class="lg:absolute top-0 right-0 lg:m-4 mt-4">
                    <router-link
                        :to="`/school-types/${type.id}/edit`"
                        class="text-btn mr-4"
                        >Edit</router-link
                    >
                    <delete-school-type :type="type"></delete-school-type>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../Components/PageHeader";
import DeleteSchoolType from "../../Components/Admin/DeleteSchoolType";
export default {
    components: {
        PageHeader,
        DeleteSchoolType,
    },

    computed: {
        school_types() {
            return this.$store.state.schooltypes.all;
        },
    },

    mounted() {
        this.$store.dispatch("schooltypes/refreshAll");
    },
};
</script>
