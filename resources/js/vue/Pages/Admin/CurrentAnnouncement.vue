<template>
    <div class="max-w-lg p-6 shadow rounded-lg">
        <p class="type-h4">
            Current
            <span class="capitalize">{{ type }}</span> Announcement
        </p>

        <div v-if="announcement">
            <colour-label
                colour="orange"
                text="urgent"
                v-if="announcement.is_urgent"
                class="my-3 inline-block"
            ></colour-label>
            <p class="my-3 type-b2 text-sky-blue">
                {{ announcement.dates }}
            </p>
            <p class="type-b2 mb-1">English</p>
            <p class="mb-2" v-html="announcement.body_formatted.en"></p>
            <p class="type-b2 mb-1">Chinese</p>
            <p v-html="announcement.body_formatted.zh"></p>
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
import ColourLabel from "../../Components/ColourLabel";
export default {
    components: { ColourLabel },
    props: ["announcement", "type"],
};
</script>
