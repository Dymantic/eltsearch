<template>
    <div>
        <paged-data-list
            title="Browse Purchases"
            :query="queryFunction"
            search-placeholder="Search by ref no"
            :initial-descending="true"
            initial-order="date"
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
                                    @click="setOrder('date')"
                                >
                                    <span>Date</span>
                                    <sorted-asc-icon
                                        v-show="order === 'date' && !descending"
                                        class="h-4 text-gray-600 ml-1"
                                    ></sorted-asc-icon>
                                    <sorted-desc-icon
                                        v-show="order === 'date' && descending"
                                        class="h-4 text-gray-600 ml-1"
                                    ></sorted-desc-icon>
                                </button>
                            </th>
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
                                <span class="type-b2">Ref No.</span>
                            </th>
                            <th class="p-2">
                                <button
                                    class="focus:outline-none type-b2 flex items-center"
                                    @click="setOrder('amount')"
                                >
                                    <span>Amount</span>
                                    <sorted-asc-icon
                                        v-show="
                                            order === 'amount' && !descending
                                        "
                                        class="h-4 text-gray-600 ml-1"
                                    ></sorted-asc-icon>
                                    <sorted-desc-icon
                                        v-show="
                                            order === 'amount' && descending
                                        "
                                        class="h-4 text-gray-600 ml-1"
                                    ></sorted-desc-icon>
                                </button>
                            </th>
                            <th class="p-2">
                                <span class="type-b2">Item</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(purchase, index) in list"
                            :key="purchase.id"
                            :class="{ 'bg-gray-100': index % 2 }"
                        >
                            <td>
                                <div
                                    class="w-2 h-2 rounded-full"
                                    :class="{
                                        'bg-green-300': purchase.paid,
                                        'bg-red-300': !purchase.paid,
                                    }"
                                ></div>
                            </td>
                            <td class="px-2 py-1">
                                {{ purchase.purchase_date }}
                            </td>
                            <td class="px-2 py-1 flex">
                                <router-link
                                    :to="`/purchases/${purchase.id}/show`"
                                    class="hover:text-sky-blue type-b2"
                                >
                                    {{ purchase.customer_name }}
                                </router-link>
                            </td>
                            <td class="px-2 py-1">
                                {{ purchase.ref_no }}
                            </td>
                            <td class="px-2 py-1">
                                {{ purchase.pretty_price }}
                            </td>
                            <td class="px-2 py-1">
                                {{ purchase.package.name }}
                            </td>
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
import { queryPurchases } from "../../../../api/admin/purchases";
export default {
    components: { PagedDataList, SortedAscIcon, SortedDescIcon },

    data() {
        return {
            queryFunction: queryPurchases,
        };
    },
};
</script>
