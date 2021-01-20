<template>
    <div>
        <page-header title="Employment History">
            <router-link
                to="/previous-employments/create"
                class="btn btn-primary"
                >Add Employer</router-link
            >
        </page-header>

        <div class="my-12 max-w-xl">
            <p class="text-gray-600">
                You have not entered any previous work experience yet. Add your
                experience to increase your chances of finding the best job for
                you.
            </p>
        </div>

        <div>
            <div
                v-for="employment in employments"
                :key="employment.id"
                class="m-6 p-6 shadow rounded-lg max-w-3xl"
            >
                <p class="type-h4">{{ employment.employer }}</p>
                <p class="type-b2 text-sky-blue">
                    {{ employment.job_title }}
                </p>
                <p class="text-gray-600 type-b2">{{ employment.duration }}</p>
                <p class="type-b1 mt-3">{{ employment.description }}</p>
                <div class="mt-4 flex justify-end">
                    <router-link
                        :to="`/previous-employments/${employment.id}/edit`"
                        class="btn btn-primary"
                        >Edit</router-link
                    >
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../PageHeader";
import PreviousEmploymentForm from "./PreviousEmploymentForm";
import { showError } from "../../../libs/notifications";
export default {
    components: {
        PageHeader,
        PreviousEmploymentForm,
    },

    computed: {
        employments() {
            return this.$store.state.profile.previous_employments;
        },
    },

    mounted() {
        this.$store
            .dispatch("profile/fetchPreviousEmployments")
            .catch(() => showError("Unable to fetch employment history."));
    },
};
</script>
