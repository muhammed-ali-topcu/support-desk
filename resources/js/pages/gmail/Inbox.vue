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
        emails: {
            type: Object,
            required: true,
        },
    },

    data() {
        return {
            breadcrumbs: [
                {
                    title: 'Gmail',
                    href: route('gmail.index'),
                },
            ],
        };
    },

};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Gmail Inbox</h1>
            </div>

            <div class=" overflow-hidden sm:rounded-lg divide-y divide-gray-200">
                <div v-for="email in emails" :key="email.id" class="px-6 py-4 hover:bg-gray-50 transition-colors duration-150">
                    <div class="flex justify-between items-start">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center space-x-3">
                                <h3 class="text-base font-medium text-gray-900 truncate">
                                    {{ email.subject || '(No Subject)' }}
                                </h3>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">
                                From: <span class="font-medium text-gray-900">{{ email.from }}</span>
                            </p>
                            <p class="mt-1 text-sm text-gray-600 line-clamp-2">
                                {{ email.body.slice(0, 200) }}{{ email.body.length > 200 ? '...' : '' }}
                            </p>
                        </div>
                        <div class="ml-4 flex-shrink-0">
                            <p class="text-sm text-gray-500">
                                {{ email.timestamp }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>