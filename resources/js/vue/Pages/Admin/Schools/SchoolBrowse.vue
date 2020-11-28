<template>
    <div>
        <paged-data-list
            title="Browse Schools"
            :query="queryFunction"
            :initial-descending="false"
            initial-order="name"
            v-slot="{ list, setOrder, order, descending }"
        >
            <div>
                <table class="w-full">
                    <thead>
                        <tr class="text-left">
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
                                    @click="setOrder('location')"
                                >
                                    <span>Location</span>
                                    <sorted-asc-icon
                                        v-show="
                                            order === 'location' && !descending
                                        "
                                        class="h-4 text-gray-600 ml-1"
                                    ></sorted-asc-icon>
                                    <sorted-desc-icon
                                        v-show="
                                            order === 'location' && descending
                                        "
                                        class="h-4 text-gray-600 ml-1"
                                    ></sorted-desc-icon>
                                </button>
                            </th>
                            <th class="p-2">
                                <button
                                    class="focus:outline-none type-b2 flex items-center"
                                    @click="setOrder('signedup')"
                                >
                                    <span>Signed Up</span>
                                    <sorted-asc-icon
                                        v-show="
                                            order === 'signedup' && !descending
                                        "
                                        class="h-4 text-gray-600 ml-1"
                                    ></sorted-asc-icon>
                                    <sorted-desc-icon
                                        v-show="
                                            order === 'signedup' && descending
                                        "
                                        class="h-4 text-gray-600 ml-1"
                                    ></sorted-desc-icon>
                                </button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(school, index) in list"
                            :key="school.id"
                            :class="{ 'bg-gray-100': index % 2 }"
                        >
                            <td class="px-2 py-1 flex">
                                <div
                                    class="w-6 h-6 rounded-full overflow-hidden mr-4"
                                >
                                    <img
                                        :src="school.logo.thumb"
                                        class="w-full -full object-cover"
                                    />
                                </div>
                                <router-link
                                    :to="`/schools/${school.id}/show`"
                                    class="hover:text-sky-blue type-b2"
                                >
                                    {{ school.name }}
                                </router-link>
                            </td>
                            <td class="px-2 py-1">{{ school.location }}</td>
                            <td class="px-2 py-1">{{ school.signed_up }}</td>
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
import { querySchools } from "../../../../api/admin/schools";
export default {
    components: { PagedDataList, SortedAscIcon, SortedDescIcon },

    data() {
        return {
            queryFunction: querySchools,
        };
    },
};
</script>
