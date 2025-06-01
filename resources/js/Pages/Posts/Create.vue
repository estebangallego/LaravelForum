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
                    <div class="mt-2">
                        <InputLabel for="topic_id"> Select Topic </InputLabel>
                        <select id="topic_id" v-model="form.topic_id" class="mt-2 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option v-for="topic in topics" :key="topic.id" :value="topic.id">
                                {{ topic.name }}
                            </option>
                        </select>
                        <InputError :message="form.errors.topic_id" class="mt-2" />
                    </div>
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
    import axios from 'axios';
    const props = defineProps({
        topics: {
            type: Array,
            required: true,
        },
    });
    const form = useForm({
        body: '',
        title: '',
        topic_id: props.topics[0].id,
    });

    const createPost = () => form.post(route('posts.store'));
    const autofill = async () => {
       const response = await axios.get(route('api.post-content'));
       form.title = response.data.title;
       form.body = response.data.body;
    }
</script>
