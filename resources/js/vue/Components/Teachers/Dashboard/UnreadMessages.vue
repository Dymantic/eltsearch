<template>
    <div class="max-w-2xl border border-sky-blue rounded-lg p-6">
        <p class="type-h3 text-navy">You have Mail</p>
        <p class="my-6">
            You have some unread messages in your inbox.
        </p>
        <div class="flex justify-end">
            <router-link to="/notifications" class="btn btn-primary"
                >See Messages</router-link
            >
        </div>
    </div>
</template>

<script type="text/babel">
export default {};
</script>
