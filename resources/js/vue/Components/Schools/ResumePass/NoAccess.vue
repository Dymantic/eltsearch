<template>
    <div class="my-12 max-w-lg p-6 shadow rounded-lg">
        <p class="type-h3 mb-6">Get the resume pass</p>
        <p class="my-1">
            Get access to teacher resumes to help find the right teacher for
            your school.
        </p>
        <p class="my-1">
            Find quality candidates, with the right amount of experience, and in
            your area.
        </p>
        <div class="flex justify-end mt-6">
            <router-link to="/resume-passes/buy" class="btn btn-primary"
                >Get access now</router-link
            >
        </div>
    </div>
</template>

<script type="text/babel">
export default {
    props: ["pass-info"],
};
</script>
