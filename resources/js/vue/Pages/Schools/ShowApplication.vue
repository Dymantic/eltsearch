<template>
    <div v-if="application">
        <page-header :title="trns('show_application.title')" :back="true">
            <router-link
                :to="`/applications/${application.id}/contact`"
                class="btn-primary btn"
                >{{ trns("show_application.contact") }}</router-link
            >
        </page-header>

        <div class="max-w-3xl">
            <div class="my-8">
                <p>
                    <span class="type-b2"
                        >{{ trns("show_application.position") }}: </span
                    >{{ application.position }}
                </p>
                <p>
                    <span class="type-b2"
                        >{{ trns("show_application.school") }}: </span
                    >{{ application.school_name }}
                </p>
            </div>

            <div class="my-12">
                <p class="type-h4 mb-3 border-b border-gray-300 pb-1">
                    {{ trns("show_application.profile") }}
                </p>
                <div class="flex justify-between">
                    <div>
                        <p class="mb-2">
                            <span class="type-b2"
                                >{{ trns("show_application.name") }}: </span
                            >{{ application.teacher.name }}
                        </p>
                        <p class="mb-2">
                            <span class="type-b2"
                                >{{
                                    trns("show_application.nationality")
                                }}: </span
                            >{{ application.teacher.nationality }}
                        </p>
                        <p class="mb-2">
                            <span class="type-b2"
                                >{{
                                    trns("show_application.years_experience")
                                }}: </span
                            >{{ application.teacher.years_experience }}
                        </p>
                        <p class="mb-2">
                            <span class="type-b2"
                                >{{
                                    trns("show_application.native_language")
                                }}: </span
                            >{{ application.teacher.native_language }}
                        </p>
                        <p class="mb-2">
                            <span class="type-b2"
                                >{{
                                    trns("show_application.other_languages")
                                }}: </span
                            >{{ application.teacher.other_languages }}
                        </p>
                        <p class="mb-2">
                            <span class="type-b2"
                                >{{ trns("show_application.age") }}: </span
                            >{{ application.teacher.age }}
                        </p>
                        <p class="mb-2">
                            <span class="type-b2"
                                >{{
                                    trns("show_application.date_of_birth")
                                }}: </span
                            >{{ application.teacher.date_of_birth }}
                        </p>
                    </div>
                    <div class="w-40">
                        <div class="w-32 h-32">
                            <img
                                :src="application.teacher.avatar"
                                class="w-full h-full object-cover"
                                alt=""
                            />
                        </div>
                    </div>
                </div>
            </div>

            <div class="my-12">
                <p class="type-h4 mb-3 border-b border-gray-300 pb-1">
                    {{ trns("show_application.cover_letter") }}
                </p>
                <div v-html="application.cover_letter"></div>
            </div>

            <div class="my-12">
                <p class="type-h4 border-b border-gray-300 pb-1">
                    {{ trns("show_application.education") }}
                </p>
                <p class="my-2">{{ education_level }}</p>
                <p class="">
                    {{ application.teacher.education_qualification }} from
                    {{ application.teacher.education_institution }}
                </p>
            </div>

            <div class="my-12">
                <p class="type-h4 border-b border-gray-300 pb-1">
                    {{ trns("show_application.work_experience") }}
                </p>

                <div
                    v-for="employment in application.teacher
                        .previous_employment"
                    class="my-4"
                >
                    <p class="type-b2">{{ employment.job_title }}</p>
                    <p class="type-b2">{{ employment.employer }}</p>
                    <p class="type-b1 text-gray-600">
                        {{ employment.duration }}
                    </p>
                    <p class="type-b3">{{ employment.description }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../Components/PageHeader";
export default {
    components: {
        PageHeader,
    },

    computed: {
        application() {
            return this.$store.getters["applications/byId"](
                this.$route.params.application
            );
        },

        education_level() {
            if (this.application.teacher.education_level === "postgrad") {
                return "Postgraduate Degree";
            }

            if (this.application.teacher.education_level === "graduate") {
                return "Graduate Degree";
            }

            return "No Graduate Degree";
        },
    },

    created() {
        return this.$store.dispatch("applications/fetchApplications");
    },
};
</script>
