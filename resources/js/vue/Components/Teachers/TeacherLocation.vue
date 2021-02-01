<template>
    <div>
        <p class="type-h3">Location</p>
        <p class="my-4" v-if="!current_location">
            Where are you based? If you are already living and working in an ELT
            supported location, let us know. This will help us find the right
            job for you. If you have not decided on a place to settle yet, you
            may leave this unset.
        </p>
        <p v-else class="my-4">
            Are you still based in
            <span class="type-b2">{{ current_location }}</span
            >? Keeping this up to date helps us find the right job for you.
        </p>
        <div class="flex justify-end">
            <choose-location
                @chosen="setLocation"
                label="Edit"
                heading="Where are you based?"
            ></choose-location>
        </div>
    </div>
</template>

<script type="text/babel">
import ChooseLocation from "./ChooseLocation";
import { showError, showSuccess } from "../../../libs/notifications";
export default {
    components: { ChooseLocation },

    computed: {
        current_location() {
            return this.$store.getters["profile/current_location"];
        },
    },

    methods: {
        setLocation(area_id) {
            this.$store
                .dispatch("profile/setLocation", area_id)
                .then(() => showSuccess("Location updated"))
                .catch(() => showError("Failed to update location"));
        },
    },
};
</script>
