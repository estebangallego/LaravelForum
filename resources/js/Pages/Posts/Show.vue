<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Container from '@/Components/Container.vue';
    import Pagination from '@/Components/Pagination.vue';
    import {formatDate} from '@/Utilities/date.js';
    import Comment from '@/Components/Comment.vue';
    
    const props = defineProps(['post', 'comments']);

</script>

<template>
    <AppLayout :title="post.title">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ post.title }}
            </h2>
            <span class="text-gray-500 text-sm">{{ formatDate(post.created_at) }} by {{ post.user.name }}</span>
        </template>

        <Container>
            <article>
                <pre class="whitespace-pre-wrap font-sans">{{ post.body }}</pre>
            </article>
            <div class="mt-6">
                <h3 class="text-lg font-medium text-gray-900">Comments</h3>
                <ul class="divide-y divide-gray-200 mt-4">
                    <li v-for="comment in comments.data" :key="comment.id" class="px-2 py-4">
                        <Comment :comment="comment"/>
                    </li>
                </ul>
                
                <Pagination :meta="comments.meta" :only="only" />    

            </div>
        </Container>

    </AppLayout>
</template>