<template>
    <div>
        <p class="type-h3 capitalize pb-2 mb-2 border-b border-gray-300">
            {{ teacher.name }}
        </p>
        <div class="flex flex-col md:flex-row justify-between">
            <div>
                <p class="type-h4 my-2">{{ teacher.nationality }}</p>
                <p>
                    <span
                        ><span class="type-b2">Age:</span>
                        {{ teacher.age || "Unknown" }}</span
                    >
                    <span
                        v-show="teacher.date_of_birth"
                        class="mx-3 text-sm text-gray-600"
                        >({{ teacher.date_of_birth }})</span
                    >
                </p>
                <p class="my-1">
                    <span class="type-b2">Teaching experience: </span
                    >{{ teacher.years_experience }} years
                </p>
                <p class="my-1">
                    <span class="type-b2">Native language: </span
                    >{{ teacher.native_language }}
                </p>
                <p class="my-1">
                    <span class="type-b2">Other languages: </span
                    >{{ teacher.other_languages }}
                </p>
                <p class="my-1">
                    <span class="type-b2">Email: </span
                    ><a
                        target="_blank"
                        rel="nofollow"
                        :href="`mailto:${teacher.email}`"
                        class="hover:text-sky-blue"
                        >{{ teacher.email }}</a
                    >
                </p>
            </div>
            <div class="w-48 mt-3">
                <img :src="teacher.avatar" />
            </div>
        </div>

        <div class="my-12">
            <p class="type-h4 pb-2 mb-2 border-b border-gray-300">Education</p>

            <p class="my-2" v-if="complete_education_info">
                <span class="type-b2">{{
                    teacher.education_qualification
                }}</span>
                from
                <span class="type-b2">{{ teacher.education_institution }}</span>
            </p>
            <p v-else class="text-gray-600">
                {{ teacher.name }} has not completed their education info
            </p>
        </div>

        <div class="my-12">
            <p class="type-h4 pb-2 mb-2 border-b border-gray-300">
                Employment History
            </p>
            <p class="text-gray-600" v-if="!teacher.previous_employment.length">
                {{ teacher.name }} has not added any previous employment history
            </p>
            <div
                v-for="employment in teacher.previous_employment"
                :key="employment.id"
                class="my-6 max-w-xl"
            >
                <p class="type-h4">{{ employment.employer }}</p>
                <p class="type-b2 text-sky-blue">
                    {{ employment.job_title }}
                </p>
                <p class="text-gray-600 type-b2">{{ employment.duration }}</p>
                <p class="type-b1 mt-3">{{ employment.description }}</p>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
export default {
    props: ["teacher"],

    computed: {
        complete_education_info() {
            return (
                this.teacher.education_institution &&
                this.teacher.education_qualification
            );
        },
    },
};
</script>
