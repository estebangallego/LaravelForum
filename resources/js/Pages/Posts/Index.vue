<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Container from '@/Components/Container.vue';
    import { Link } from '@inertiajs/vue3';
    import Pagination from '@/Components/Pagination.vue';
    import {formatDate} from '@/Utilities/date.js';
    defineProps(['posts']);

</script>

<template>
    <AppLayout title="Post List">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Posts
            </h2>
        </template>

        <Container>
            <ul class="divide-y divide-gray-200">
                <li v-for="post in posts.data" :key="post.id" class="px-2 py-4">
                    <Link :href="route('posts.show', post.id)" class="group">
                        <span class="font-semibold group-hover:text-indigo-500">{{ post.title }}</span>
                        <p class="text-gray-500 text-sm">{{ formatDate(post.created_at) }} by {{ post.user.name }}</p>
                    </Link>
                </li>   
            </ul>
            <Pagination :meta="posts.meta" />
        </Container>
    </AppLayout>
</template>