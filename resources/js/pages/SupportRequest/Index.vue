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

    methods: {
        
    },
    
};
</script>

<template>
<AppLayout :breadcrumbs="breadcrumbs">


    <h1 class="text-2xl font-bold ">Support Requests</h1>
    <div class="mt-4">
    <table class="table table-auto w-full">
        <thead>
            <tr>
                <th>Id</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="supportRequest in supportRequests.data" :key="supportRequest.id">
                <td>{{ supportRequest.id }}</td>
                <td>{{ supportRequest.email }}</td>
                <td>{{ supportRequest.subject }}</td>
                <td>{{ supportRequest.message }}</td>
                <td>{{ supportRequest.created_at }}</td>
                <td>
                    <!-- <Link :href="route('support-requests.show', supportRequest.id)">Show</Link> -->
                </td>
            </tr>
            <tr v-if="supportRequests.data.length === 0">
                <td colspan="5" class="text-center">No support requests found.</td>
            </tr>
        </tbody>
        
    </table>    
    <Pagination :links="supportRequests.links" />
    </div>





</AppLayout>

        

</template>