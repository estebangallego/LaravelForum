<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Container from '@/Components/Container.vue';
    import { Link } from '@inertiajs/vue3';
    import Pagination from '@/Components/Pagination.vue';
    import {formatDate} from '@/Utilities/date.js';
    import PageHeading from '@/Components/PageHeading.vue';
    defineProps(['posts', 'selectedTopic']);

</script>

<template>
    <AppLayout title="Post List">
        <template #header>
            <Link :href="route('posts.index')" class="mb-4 inline-block text-sm hover:text-indigo-500 transition-colors">
                <PrimaryButton>
                    Back to all topics
                </PrimaryButton>
            </Link>
            <PageHeading>
                {{ selectedTopic ? selectedTopic.name : 'All Posts' }}
                <p v-if="selectedTopic" class="text-gray-500 text-sm">
                    {{ selectedTopic.description }}
                </p>
            </PageHeading>
        </template>

        <Container>
            <ul class="divide-y divide-gray-200">
                <li v-for="post in posts.data" :key="post.id" class="flex items-center justify-between flex-col md:flex-row mt-4 mb-4">
                    <Link 
                        :href="post.routes.show" class="group">
                        <span class="font-semibold group-hover:text-indigo-500 transition-colors">{{ post.title }}</span>
                        <p class="text-gray-500 text-sm">{{ formatDate(post.created_at) }} by {{ post.user.name }}</p>
                    </Link>
                    <Link 
                        :href="route('posts.index', { topic: post.topic.slug })"
                        class="rounded-full
                        py-0.5
                        px-2 
                        text-gray-500 
                        text-sm border 
                        border-gray-300
                        hover:bg-indigo-500 
                        hover:text-white 
                        transition-colors 
                        mb-2 mt-2 md:mt-0">
                        {{ post.topic.name }}
                    </Link>
                </li>   
            </ul>
            <Pagination :meta="posts.meta" />
        </Container>
    </AppLayout>
</template>