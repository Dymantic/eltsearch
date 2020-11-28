<template>
    <div>
        <paged-data-list
            title="Published Job Posts"
            :query="queryFunction"
            :initial-descending="true"
            initial-order="published"
            v-slot="{ list, setOrder, order, descending }"
        >
            <div>
                <table class="w-full">
                    <thead>
                        <tr class="text-left">
                            <th class="p-2">
                                <button
                                    class="focus:outline-none type-b2 flex items-center"
                                    @click="setOrder('published', true)"
                                >
                                    <span>Published</span>
                                    <sorted-asc-icon
                                        v-show="
                                            order === 'published' && !descending
                                        "
                                        class="h-4 text-gray-600 ml-1"
                                    ></sorted-asc-icon>
                                    <sorted-desc-icon
                                        v-show="
                                            order === 'published' && descending
                                        "
                                        class="h-4 text-gray-600 ml-1"
                                    ></sorted-desc-icon>
                                </button>
                            </th>
                            <th class="p-2">
                                <button
                                    class="focus:outline-none type-b2 flex items-center"
                                    @click="setOrder('school')"
                                >
                                    <span>School Name</span>
                                    <sorted-asc-icon
                                        v-show="
                                            order === 'school' && !descending
                                        "
                                        class="h-4 text-gray-600 ml-1"
                                    ></sorted-asc-icon>
                                    <sorted-desc-icon
                                        v-show="
                                            order === 'school' && descending
                                        "
                                        class="h-4 text-gray-600 ml-1"
                                    ></sorted-desc-icon>
                                </button>
                            </th>
                            <th class="p-2">
                                <button
                                    class="focus:outline-none type-b2 flex items-center"
                                    @click="setOrder('position')"
                                >
                                    <span>Position</span>
                                    <sorted-asc-icon
                                        v-show="
                                            order === 'position' && !descending
                                        "
                                        class="h-4 text-gray-600 ml-1"
                                    ></sorted-asc-icon>
                                    <sorted-desc-icon
                                        v-show="
                                            order === 'position' && descending
                                        "
                                        class="h-4 text-gray-600 ml-1"
                                    ></sorted-desc-icon>
                                </button>
                            </th>
                            <th class="p-2">
                                <button
                                    class="focus:outline-none type-b2 flex items-center"
                                    @click="setOrder('area')"
                                >
                                    <span>Location</span>
                                    <sorted-asc-icon
                                        v-show="order === 'area' && !descending"
                                        class="h-4 text-gray-600 ml-1"
                                    ></sorted-asc-icon>
                                    <sorted-desc-icon
                                        v-show="order === 'area' && descending"
                                        class="h-4 text-gray-600 ml-1"
                                    ></sorted-desc-icon>
                                </button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(post, index) in list"
                            :key="post.id"
                            :class="{ 'bg-gray-100': index % 2 }"
                        >
                            <td class="px-2 py-1">
                                {{ post.first_published }}
                            </td>
                            <td class="px-2 py-1 flex">
                                <div
                                    class="w-6 h-6 rounded-full overflow-hidden mr-4"
                                >
                                    <img
                                        :src="post.logo.thumb"
                                        class="w-full -full object-contain"
                                    />
                                </div>
                                <router-link
                                    :to="`/job-posts/${post.id}/show`"
                                    class="hover:text-sky-blue type-b2"
                                >
                                    {{ post.school_name }}
                                </router-link>
                            </td>
                            <td class="px-2 py-1">{{ post.position }}</td>
                            <td class="px-2 py-1">{{ post.area }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </paged-data-list>
    </div>
</template>

<script type="text/babel">
import PagedDataList from "../../../Components/General/PagedDataList";
import SortedAscIcon from "../../../Components/Icons/SortedAscIcon";
import SortedDescIcon from "../../../Components/Icons/SortedDescIcon";
import { queryJobPosts } from "../../../../api/admin/job_posts";
export default {
    components: { PagedDataList, SortedAscIcon, SortedDescIcon },

    data() {
        return {
            queryFunction: queryJobPosts,
        };
    },
};
</script>
