<template>
    <div>
        <page-header title="Session Expired"></page-header>
        <div class="my-12 max-w-lg p-6 shadow">
            <p class="type-h4">Oh dear</p>
            <p class="my-4">
                While you were away, your session expired and you were logged
                out. You will need to log back in to continue with what you were
                doing.
            </p>
            <div class="flex justify-end mt-6">
                <a href="/login" class="btn btn-primary">Login</a>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../Components/PageHeader";
export default {
    components: { PageHeader },
};
</script>
