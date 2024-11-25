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
                    <TextInput id="title" v-model="form.title" class="mt-2 w-full" aria-placeholder="Give it a great title" />

                    ----------------------
                    <MarkdownEditor v-model="form.body" />
                    ----------------------

                    <InputError :message="form.errors.title" class="mt-2" />
                </div>
                <div>
                    <InputLabel for="body" class="mt-4"> Body </InputLabel>
                    <textarea id="body" v-model="form.body" type="text" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" rows="12" />
                    <InputError :message="form.errors.body" class="mt-2" />
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


</script>
