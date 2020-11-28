<template>
    <div>
        <page-header title="New Public Announcement"></page-header>

        <div class="my-12">
            <announcement-form type="public"></announcement-form>
        </div>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../Components/PageHeader";
import AnnouncementForm from "./AnnouncementForm";
export default {
    components: { AnnouncementForm, PageHeader },
};
</script>
