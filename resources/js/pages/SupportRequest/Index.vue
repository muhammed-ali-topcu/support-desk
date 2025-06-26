<script>
import AppLayout from '@/layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import Pagination from '@/components/Pagination.vue';

export default {
    components: {
        AppLayout,
        Link,
        Pagination,
    },

    props: {
        supportRequests: {
            type: Object,
            required: true,
        },
    },

    data() {
        return {
            breadcrumbs: [
                {
                    title: 'Support Requests',
                    href: route('support-requests.index'),
                },
            ],
        };
    },

};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <h1 class="text-2xl font-bold ">Support Requests</h1>
        <div class="mt-4">
            <div class="overflow-x-auto ">
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th class="p-3 text-left text-sm font-medium text-gray-500">Id</th>
                            <th class="p-3 text-left text-sm font-medium text-gray-500">Email</th>
                            <th class="p-3 text-left text-sm font-medium text-gray-500">Subject</th>
                            <th class="p-3 text-left text-sm font-medium text-gray-500">Message</th>
                            <th class="p-3 text-left text-sm font-medium text-gray-500">Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="supportRequest in supportRequests.data" :key="supportRequest.id"
                            class="border-b hover:bg-gray-50">
                            <td class="p-3 text-sm text-gray-900">{{ supportRequest.id }}</td>
                            <td class="p-3 text-sm text-gray-900">{{ supportRequest.email }}</td>
                            <td class="p-3 text-sm text-gray-900">{{ supportRequest.subject }}</td>
                            <td class="p-3 text-sm text-gray-900">{{ supportRequest.message }}</td>
                            <td class="p-3 text-sm text-gray-900">{{ supportRequest.created_at }}</td>

                        </tr>
                        <tr v-if="supportRequests.data.length === 0">
                            <td colspan="6" class="p-3 text-center text-sm text-gray-500">No support requests found.
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="mt-2">
                    <Pagination :links="supportRequests.links" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>