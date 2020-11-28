<template>
    <div class="max-w-lg p-6 shadow rounded-lg">
        <p class="type-h4">
            Current
            <span class="capitalize">{{ type }}</span> Announcement
        </p>
        <div v-if="announcement">
            <p class="my-3 type-b2 text-sky-blue">
                {{ announcement.dates }}
            </p>
            <p class="type-b2 mb-1">English</p>
            <p class="mb-2">{{ announcement.body.en }}</p>
            <p class="type-b2 mb-1">Chinese</p>
            <p>{{ announcement.body.zh }}</p>
        </div>
        <p v-else class="text-gray-600">
            There is no {{ type }} announcement at the moment.
        </p>
        <div class="mt-2 flex justify-end">
            <router-link
                v-if="announcement"
                :to="`/announcements/${announcement.id}/show`"
                class="text-sky-blue hover:text-navy"
                >View</router-link
            >
        </div>
    </div>
</template>

<script type="text/babel">
export default {
    props: ["announcement", "type"],
};
</script>
