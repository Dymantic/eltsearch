<template>
    <div>
        <page-header :title="trns('resume_pass.title')">
            <p v-show="passInfo.has_access" class="type-b1">
                {{
                    trns("resume_pass.valid_until", "", {
                        date: passInfo.expires_on,
                    })
                }}
            </p>
        </page-header>

        <no-access
            :pass-info="passInfo"
            v-if="!passInfo.has_access && passInfo.access_checked"
        ></no-access>

        <reminder-to-extend
            :pass-info="passInfo"
            v-if="passInfo.has_access && passInfo.days_remaining < 21"
        ></reminder-to-extend>

        <div
            class="my-12"
            v-if="passInfo.has_access && passInfo.access_checked"
        >
            <resume-pass-filters @applied="useFilters"></resume-pass-filters>

            <div class="flex mb-4">
                <p class="type-b1 mr-8">
                    {{
                        trns("resume_pass.total_records", "", {
                            total_records,
                            page,
                            total_pages,
                        })
                    }}
                </p>
                <div>
                    <button
                        class="mx-6 text-navy hover:text-sky-blue type-b2"
                        v-show="page > 1"
                        @click="prevPage"
                    >
                        &lt; {{ trns("resume_pass.prev_page") }}
                    </button>
                    <button
                        class="mx-6 text-navy hover:text-sky-blue type-b2"
                        v-show="page < total_pages"
                        @click="nextPage"
                    >
                        {{ trns("resume_pass.next_page") }} &gt;
                    </button>
                </div>
            </div>

            <busy-loading v-if="fetching"></busy-loading>

            <p
                class="my-6 test-gray-600"
                v-show="!teachers.length && !fetching"
            >
                {{ trns("resume_pass.no_results") }}
            </p>

            <div class="" v-if="teachers.length">
                <table class="w-full">
                    <thead>
                        <tr class="text-left">
                            <th class="p-2"></th>
                            <th class="p-2">
                                <button
                                    class="focus:outline-none type-b2 flex items-center"
                                    @click="setOrder('name')"
                                >
                                    <span>{{
                                        trns("resume_pass.teacher_name")
                                    }}</span>
                                    <sorted-asc-icon
                                        v-show="order === 'name' && !descending"
                                        class="h-4 text-gray-600 ml-1"
                                    ></sorted-asc-icon>
                                    <sorted-desc-icon
                                        v-show="order === 'name' && descending"
                                        class="h-4 text-gray-600 ml-1"
                                    ></sorted-desc-icon>
                                </button>
                            </th>
                            <th class="p-2">
                                <button
                                    class="focus:outline-none type-b2 flex items-center"
                                    @click="setOrder('nationality')"
                                >
                                    <span>{{
                                        trns("resume_pass.nationality")
                                    }}</span>
                                    <sorted-asc-icon
                                        v-show="
                                            order === 'nationality' &&
                                            !descending
                                        "
                                        class="h-4 text-gray-600 ml-1"
                                    ></sorted-asc-icon>
                                    <sorted-desc-icon
                                        v-show="
                                            order === 'nationality' &&
                                            descending
                                        "
                                        class="h-4 text-gray-600 ml-1"
                                    ></sorted-desc-icon>
                                </button>
                            </th>
                            <th class="p-2">
                                <button
                                    class="focus:outline-none type-b2 flex items-center"
                                    @click="setOrder('age')"
                                >
                                    <span>{{ trns("resume_pass.age") }}</span>
                                    <sorted-asc-icon
                                        v-show="order === 'age' && !descending"
                                        class="h-4 text-gray-600 ml-1"
                                    ></sorted-asc-icon>
                                    <sorted-desc-icon
                                        v-show="order === 'age' && descending"
                                        class="h-4 text-gray-600 ml-1"
                                    ></sorted-desc-icon>
                                </button>
                            </th>
                            <th class="p-2">
                                {{ trns("resume_pass.education") }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="teacher in teachers" :key="teacher.slug">
                            <td>
                                <div
                                    class="h-6 w-6 overflow-hidden rounded-full"
                                >
                                    <img
                                        :src="teacher.avatar"
                                        class="w-full h-full object-cover"
                                    />
                                </div>
                            </td>
                            <td class="px-2 py-1">
                                <router-link
                                    class="text-navy font-bold hover:text-sky-blue"
                                    :to="`/resume-pass/teachers/${teacher.slug}`"
                                    >{{ teacher.name }}</router-link
                                >
                            </td>
                            <td class="px-2 py-1">{{ teacher.nationality }}</td>
                            <td class="px-2 py-1">{{ teacher.age }}</td>
                            <td class="px-2 py-1">
                                {{ teacher.education_qualification }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import PageHeader from "../../Components/PageHeader";
import NoAccess from "../../Components/Schools/ResumePass/NoAccess";
import ReminderToExtend from "../../Components/Schools/ResumePass/ReminderToExtend";
import BusyLoading from "../../Components/BusyLoading";
import { queryTeachers } from "../../../api/schools/teachers";
import CheckboxInput from "../../Components/Forms/CheckboxInput";
import SelectField from "../../Components/Forms/SelectField";
import ResumePassFilters from "../../Components/Schools/ResumePass/ResumePassFilters";
import SortedAscIcon from "../../Components/Icons/SortedAscIcon";
import SortedDescIcon from "../../Components/Icons/SortedDescIcon";
export default {
    components: {
        SortedDescIcon,
        SortedAscIcon,
        ResumePassFilters,
        SelectField,
        CheckboxInput,
        BusyLoading,
        ReminderToExtend,
        NoAccess,
        PageHeader,
    },

    data() {
        return {
            teachers: [],
            filters: {
                area: false,
                nation_id: null,
            },
            fetching: true,
            order: "name",
            descending: false,
            currentFilters: {
                area: 0,
                exp_level: 0,
                nation: 0,
            },
            total_pages: 1,
            page: 1,
            total_records: 0,
        };
    },

    computed: {
        passInfo() {
            return this.$store.state.purchases.resumePass;
        },

        schoolArea() {
            return this.$store.getters["schoolprofile/areaId"];
        },

        schoolId() {
            return this.$store.state.profile.current_school_id;
        },

        prev_page_no() {
            return Math.max(this.page - 1, 1);
        },

        next_page_no() {
            return Math.min(this.page + 1, this.total_pages);
        },
    },

    mounted() {
        this.$store.dispatch("purchases/checkResumePass").then(() => {
            if (this.$store.state.purchases.resumePass.has_access) {
                this.fetchTeachers({});
            }
        });
    },

    methods: {
        fetchTeachers() {
            this.fetching = true;
            queryTeachers(this.schoolId, {
                area: this.currentFilters.area,
                page: this.page,
                exp_level: this.currentFilters.exp_level,
                nation: this.currentFilters.nation,
                order: this.order,
                direction: this.descending ? "desc" : "asc",
            })
                .then((page) => {
                    this.teachers = page.items;
                    this.total_pages = page.last_page;
                    this.page = page.page;
                    this.total_records = page.total;
                })
                .then(() => (this.fetching = false));
        },

        useFilters({ area, experience, nation_id }) {
            this.currentFilters = {
                area: area ? this.schoolArea : 0,
                exp_level: experience || 0,
                nation: nation_id || 0,
            };
            this.page = 1;
            this.fetchTeachers();
        },

        setOrder(column) {
            if (this.order === column) {
                this.descending = !this.descending;
            }
            this.order = column;
            this.page = 1;
            this.fetchTeachers();
        },

        prevPage() {
            this.page = Math.max(this.page - 1, 1);
            this.fetchTeachers();
        },

        nextPage() {
            this.page = Math.min(this.page + 1, this.total_pages);
            this.fetchTeachers();
        },
    },
};
</script>
