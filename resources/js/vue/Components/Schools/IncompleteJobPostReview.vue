<template>
    <div class="my-12 max-w-xl">
        <p class="type-b2 mb-6">
            Your post is not complete enough to publish. Please review your
            post, and complete any missing sections.
        </p>
        <div class="grid grid-cols-1 sm:grid-cols-2">
            <div
                v-for="{ label, complete } in required_fields"
                :key="label"
                class="mb-1"
            >
                <span>{{ label }}</span>
                <span v-if="complete" class="text-green-500">&check;</span>
                <span v-else class="text-red-500">&cross;</span>
            </div>
        </div>

        <div class="mt-8 flex justify-end">
            <router-link
                :to="`/job-posts/${post.id}/edit`"
                class="btn btn-primary"
                >Edit Post</router-link
            >
        </div>
    </div>
</template>

<script type="text/babel">
export default {
    props: ["post"],

    computed: {
        required_fields() {
            return this.post.presented.required_fields;
        },
    },
};
</script>
