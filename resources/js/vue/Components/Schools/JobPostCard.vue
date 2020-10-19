<template>
    <div class="shadow my-8 p-6 rounded-lg max-w-3xl">
        <p class="type-b3 text-gray-600 mb1">
            {{ post.presented.originally_created }}
        </p>
        <p class="type-h3 text-navy">
            <router-link
                class="hover:text-sky-blue"
                :to="`/job-posts/${post.id}/show`"
                >{{ post.position }}</router-link
            >
        </p>
        <p>{{ post.school_name }}</p>
        <p>{{ trns("posts_index.card.status") }}: Draft</p>
        <div class="flex justify-end mt-4">
            <router-link
                class="text-btn ml-4"
                :to="`/job-posts/${post.id}/images`"
                >{{ trns("actions.images") }}</router-link
            >
            <router-link
                class="text-btn ml-4"
                :to="`/job-posts/${post.id}/show`"
                >{{ trns("actions.view") }}</router-link
            >
            <router-link
                class="text-btn ml-4"
                :to="`/job-posts/${post.id}/edit`"
                >{{ trns("actions.edit") }}</router-link
            >
        </div>
    </div>
</template>

<script type="text/babel">
export default {
    props: ["post"],
};
</script>
