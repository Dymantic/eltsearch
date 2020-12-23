<template>
    <div class="mt-4" v-if="!complete">
        <router-link :to="url" class="type-b2 text-navy hover:text-sky-blue"
            >{{ action }} &gt;</router-link
        >
        <p class="text-gray-600">{{ reason }}</p>
    </div>
    <div v-else class="mt-4">
        <div class="flex leading-none items-center">
            <p class="type-b2 text-navy">{{ action }}</p>
            <check-icon class="text-sky-blue h-5 ml-2"></check-icon>
        </div>
        <p class="text-gray-600">{{ done }}</p>
    </div>
</template>

<script type="text/babel">
import CheckIcon from "../../Icons/CheckIcon";
export default {
    components: { CheckIcon },

    props: ["complete", "action", "reason", "done", "url"],
};
</script>
