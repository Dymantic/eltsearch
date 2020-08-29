<template>
    <div v-if="employment">
        <div class="flex justify-between mb-8">
            <p class="text-lg font-bold">Edit previous employment info</p>
            <div class="flex justify-end items-center">
                <delete-employment
                    :employer="employment.employer"
                    :employment-id="employment.id"
                ></delete-employment>
                <router-link to="/previous-employments" class="ml-4"
                    >Back</router-link
                >
            </div>
        </div>
        <previous-employment-form
            :employment="employment"
        ></previous-employment-form>
    </div>
</template>

<script type="text/babel">
import PreviousEmploymentForm from "./PreviousEmploymentForm";
import DeleteEmployment from "./DeleteEmployment";
import { showError } from "../../../libs/notifications";
export default {
    components: {
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
