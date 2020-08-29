<template>
    <div>
        <div class="flex justify-between mb-8">
            <p class="text-lg font-bold">Add previous employment info</p>
            <router-link to="/previous-employments">Back</router-link>
        </div>

        <previous-employment-form></previous-employment-form>
    </div>
</template>

<script type="text/babel">
import PreviousEmploymentForm from "./PreviousEmploymentForm";
export default {
    components: {
        PreviousEmploymentForm,
    },
};
</script>
