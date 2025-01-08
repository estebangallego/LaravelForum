<template>
    <AppLayout title="Create a Post">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                 Create a Post
            </h2>
        </template>

        <Container>

            <article>
                <form @submit.prevent="createPost">
                <div>
                    <InputLabel for="title"> Title </InputLabel>
                    <TextInput id="title" v-model="form.title" class="mt-2 w-full" placeholder="Give it a title" />
                    <MarkdownEditor v-model="form.body" class="mt-2" placeholder="Add a new post" editorClass="min-h-[512px] mt-2">
                        <template #toolbar = "{ editor, toolbar }">
                            <li>
                                <button @click="autofill"
                                    type="button"
                                    class="px-3 py-2"
                                    title="Autofill">
                                    <i class="ri-article-line"></i>
                                </button>
                            </li>
                        </template>
                    </MarkdownEditor> 
                </div>

                <div>
                    <PrimaryButton type="submit" class="mt-4">Create Post</PrimaryButton>
                </div>
            </form>
            </article>

        </Container>

    </AppLayout>
</template>

<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Container from '@/Components/Container.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import InputError from '@/Components/InputError.vue';
    import { useForm } from '@inertiajs/vue3';
    import MarkdownEditor from '@/Components/MarkdownEditor.vue';
    const form = useForm({
        body: '',
        title: ''
    });

    const createPost = () => form.post(route('posts.store'));
    const autofill = () => {
        form.title = 'My first post';
        form.body = 'This is my first post';
    }

</script>
