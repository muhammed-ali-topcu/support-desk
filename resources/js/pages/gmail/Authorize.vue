<script>
import AppLayout from '@/layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

export default {
    components: {
        AppLayout,
        Link,
    },

    props: {

    },

    data() {
        return {
            breadcrumbs: [  
                {
                    title: 'Gmail I',
                    href: route('gmail.authorize'),
                },
            ],
        };
    },

};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <h1 class="text-2xl font-bold  mb-4">Gmail</h1>
        <a :href="route('gmail.authorize')"
            class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
            <i class="fab fa-google"></i> Connect Gmail Account
        </a>


    </AppLayout>
</template>