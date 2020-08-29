<template>
    <div>
        <div class="flex justify-between items-center">
            <p class="text-lg font-bold">Employment History</p>
            <router-link to="/previous-employments/create"
                >Add Employer</router-link
            >
        </div>
        <div>
            <div
                v-for="employment in employments"
                :key="employment.id"
                class="m-6 p-6 shadow"
            >
                <p class="font-bold">{{ employment.employer }}</p>
                <p class="text-sm uppercase text-gray-600">
                    {{ employment.job_title }}
                </p>
                <p>{{ employment.duration }}</p>
                <p>{{ employment.description }}</p>
                <router-link :to="`/previous-employments/${employment.id}/edit`"
                    >Edit</router-link
                >
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import PreviousEmploymentForm from "./PreviousEmploymentForm";
import { showError } from "../../../libs/notifications";
export default {
    components: { PreviousEmploymentForm },

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
