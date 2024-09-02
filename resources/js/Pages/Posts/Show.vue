<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Container from '@/Components/Container.vue';
    import Pagination from '@/Components/Pagination.vue';
    import {formatDate} from '@/Utilities/date.js';
    import Comment from '@/Components/Comment.vue';
    import { useForm } from '@inertiajs/vue3';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    const props = defineProps(['post', 'comments']);
    
    const commentForm = useForm({
        body: '',
    });
    const addComment = () => {
        commentForm.post(route('posts.comments.store', props.post.id), {
            preserveScroll: true,
            onSuccess: () => form.reset()
        });
    }
    

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
                
                <form @submit.prevent="addComment">
                    <div class="mt-4">
                        <InputLabel for="body" value="Comment" />
                        <textarea
                            id="body"
                            
                            v-model="commentForm.body"
                            class="block w-full mt-1 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"       
                        />
                        <PrimaryButton type="submit"
                            class="mt-4"> Add Comment 
                        </PrimaryButton>
                        <InputError :message="commentForm.errors.body" class="mt-2" />
                    </div>
                </form>
                
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