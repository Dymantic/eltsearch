<template>
    <div>
        <paged-data-list
            title="Browse Teachers"
            :query="queryFunction"
            :initial-descending="false"
            initial-order="name"
            v-slot="{ list, setOrder, order, descending }"
        >
            <div>
                <table class="w-full">
                    <thead>
                        <tr class="text-left">
                            <th class="p-2"></th>
                            <th class="p-2">
                                <button
                                    class="focus:outline-none type-b2 flex items-center"
                                    @click="setOrder('name')"
                                >
                                    <span>Name</span>
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
                                    <span>Nationality</span>
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
                                    @click="setOrder('signed_up', true)"
                                >
                                    <span>Signed Up</span>
                                    <sorted-asc-icon
                                        v-show="
                                            order === 'signed_up' && !descending
                                        "
                                        class="h-4 text-gray-600 ml-1"
                                    ></sorted-asc-icon>
                                    <sorted-desc-icon
                                        v-show="
                                            order === 'signed_up' && descending
                                        "
                                        class="h-4 text-gray-600 ml-1"
                                    ></sorted-desc-icon>
                                </button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(teacher, index) in list"
                            :key="teacher.id"
                            :class="{ 'bg-gray-100': index % 2 }"
                        >
                            <td>
                                <div
                                    class="w-6 h-6 rounded-full overflow-hidden"
                                >
                                    <img
                                        :src="teacher.avatar"
                                        class="w-full -full object-cover"
                                    />
                                </div>
                            </td>
                            <td class="px-2 py-1">
                                <router-link
                                    :to="`/teachers/${teacher.id}/show`"
                                    class="hover:text-sky-blue type-b2"
                                >
                                    {{ teacher.name }}
                                </router-link>
                            </td>
                            <td class="px-2 py-1">{{ teacher.nationality }}</td>
                            <td class="px-2 py-1">{{ teacher.signed_up }}</td>
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
import { queryTeachers } from "../../../../api/admin/teachers";
export default {
    components: { PagedDataList, SortedAscIcon, SortedDescIcon },

    data() {
        return {
            queryFunction: queryTeachers,
        };
    },
};
</script>
