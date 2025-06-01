<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Container from '@/Components/Container.vue';
    import { Link } from '@inertiajs/vue3';
    import Pagination from '@/Components/Pagination.vue';
    import {formatDate} from '@/Utilities/date.js';
    import PageHeading from '@/Components/PageHeading.vue';
    import Pill from '@/Components/Pill.vue';
    defineProps(['posts', 'selectedTopic', 'topics']);

</script>

<template>
    <AppLayout title="Post List">
        <template #header>
            <PageHeading>
                {{ selectedTopic ? selectedTopic.name : 'All Posts' }}
                <p v-if="selectedTopic" class="text-gray-500 text-sm">
                    {{ selectedTopic.description }}
                </p>
                <menu class="flex flex-wrap mt-2 space-x-1">
                    <Pill :href="route('posts.index')" :filled="!selectedTopic">All Posts</Pill>
                    <li v-for="topic in topics" :key="topic.id">
                        <Pill :href="route('posts.index', { topic: topic.slug })" :filled="selectedTopic && selectedTopic.id === topic.id">
                            {{ topic.name }}
                        </Pill>
                    </li>
                </menu>
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
                    <Pill :href="route('posts.index', { topic: post.topic.slug })">{{ post.topic.name }}</Pill>
                </li>   
            </ul>
            <Pagination :meta="posts.meta" />
        </Container>
    </AppLayout>
</template>