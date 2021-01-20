<template>
    <div class="my-12 max-w-xl">
        <p class="type-b2 mb-6">
            {{ trns("incomplete_post_publish.explain") }}
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
                >{{ trns("incomplete_post_publish.edit") }}</router-link
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
