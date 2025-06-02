<template>
    <AppLayout :title="post.title">
        <template #header>
            <PageHeading>
                {{ post.title }}
            </PageHeading>
            <span class="text-gray-500 text-sm">{{ formatDate(post.created_at) }} by {{ post.user.name }}</span>
        </template>

        <Container>
            <Pill :href="route('posts.index', { topic: post.topic.slug })">{{ post.topic.name }}</Pill>
            <article class="mt-4 prose prose-sm max-w-none" v-html="post.html">
                
            </article>
            <div class="mt-6"> 
                <form @submit.prevent="() => commentBeingIdEdited ? updateComment() : addComment()" v-if="$page.props.auth.user" class="mt-4">
                    <div class="mt-4">
                        <InputLabel for="body" value="Comments" />
                        <MarkdownEditor
                            id="body"
                            ref="commentTextAreaRef"
                            v-model="commentForm.body"
                            editorClass="min-h-[160px]"
                            placeholder="Speak your mind..."
                        />
                        <PrimaryButton 
                            type="submit"
                            :disabled="commentForm.processing"
                            class="mt-4"
                            v-text="commentBeingEdited ? 'Update Comment' : 'Add Comment'"
                        />
                        <SecondaryButton 
                            class="mt-4 ms-3" 
                            @click="cancelEditing"
                            v-if="commentBeingEdited"
                            >
                                Cancel
                        </SecondaryButton>
                        <InputError :message="commentForm.errors.body" class="mt-2" />
                    </div>
                </form>
                
                <ul class="divide-y divide-gray-200 mt-4 break-all">
                    <li v-for="comment in comments.data" :key="comment.id" class="px-2 py-4">
                        <Comment @edit="editComment" @delete="deleteComment" :comment="comment"/>
                    </li>
                </ul>
                
                <Pagination :meta="comments.meta" :only="['comments']" />    

            </div>
        </Container>

    </AppLayout>
</template>

<script setup>
    import { ref, computed } from 'vue';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Container from '@/Components/Container.vue';
    import Pagination from '@/Components/Pagination.vue';
    import {formatDate} from '@/Utilities/date.js';
    import Comment from '@/Components/Comment.vue';
    import { useForm, router} from '@inertiajs/vue3';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import InputError from '@/Components/InputError.vue';
    import SecondaryButton from '@/Components/SecondaryButton.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import { useConfirm } from '@/Utilities/Composables/useConfirm.js';
    import MarkdownEditor from '@/Components/MarkdownEditor.vue';
    import PageHeading from '@/Components/PageHeading.vue';
    import Pill from '@/Components/Pill.vue';

    const props = defineProps(['post', 'comments']);
    const commentForm = useForm({
        body: '',
    });
    

    const commentTextAreaRef = ref(null);
    const commentBeingIdEdited = ref(null);
    const commentBeingEdited = computed(() => props.comments.data.find(comment => comment.id === commentBeingIdEdited.value));
    
    
    const editComment = (commentId) => {
        commentBeingIdEdited.value = commentId;
        commentForm.body = commentBeingEdited.value?.body;
        commentTextAreaRef.value?.focus();
    }

    const cancelEditing = () => {
        commentBeingIdEdited.value = null;
        commentForm.reset();
    }

    const addComment = () => {
        commentForm.post(route('posts.comments.store', props.post.id), {
            preserveScroll: true,
            onSuccess: () => commentForm.reset()
        });
    }

    const { confirmation } = useConfirm();

    const updateComment = async () => {
        if (! await confirmation('Are you sure you want to update this comment?')) return;
        commentForm.put(route('comments.update', commentBeingIdEdited.value), {
            preserveScroll: true,
            onSuccess: () => commentForm.reset()
        });
    }


    const deleteComment = async (commentId) => {
        if (! await confirmation('Are you sure you want to delete this comment?')) return;
        router.delete(route('comments.destroy', {
            comment:commentId, 
            page: props.comments.data.length > 1 
            ? props.comments.meta.current_page
            : Math.max(props.comments.meta.current_page - 1, 1)
        }), {
            preserveScroll: true,
        });
    }
    
</script>