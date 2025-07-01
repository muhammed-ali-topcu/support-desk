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
        filters: {
            type: Object,
            default: () => ({}),
        },
    },

    data() {
        return {
            form: {
                search: this.filters.search || ''
            },
            breadcrumbs: [
                {
                    title: 'Support Requests',
                    href: route('support-requests.index'),
                },
            ],
        };
    },

    watch: {
        'form.search': {
            handler(value) {
                this.$inertia.get(route('support-requests.index'), 
                    { search: value },
                    {
                        preserveState: true,
                        preserveScroll: true,
                        replace: true
                    }
                );
            },
        }
    }
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">Support Requests</h1>
            <div class="relative">
                <input
                    v-model="form.search"
                    type="text"
                    placeholder="Search..."
                    class="p-2 pr-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent w-72"
                />
            </div>
        </div>
        
        <div class="mt-4">
            <div>
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th class="p-3 text-left text-sm font-medium ">Id</th>
                            <th class="p-3 text-left text-sm font-medium ">Email</th>
                            <th class="p-3 text-left text-sm font-medium ">Subject</th>
                            <th class="p-3 text-left text-sm font-medium ">Message</th>
                            <th class="p-3 text-left text-sm font-medium ">Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="supportRequest in supportRequests.data" :key="supportRequest.id"
                            class="border-b ">
                            <td class="p-3 text-sm ">{{ supportRequest.id }}</td>
                            <td class="p-3 text-sm ">{{ supportRequest.email }}</td>
                            <td class="p-3 text-sm ">{{ supportRequest.subject }}</td>
                            <td class="p-3 text-sm ">{{ supportRequest.message }}</td>
                            <td class="p-3 text-sm ">{{ supportRequest.created_at }}</td>
                        </tr>
                        <tr v-if="supportRequests.data.length === 0">
                            <td colspan="5" class="p-3 text-center text-sm ">
                                No support requests found.
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