<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Container from '@/Components/Container.vue';
    import { Link } from '@inertiajs/vue3';
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
            <ul>
                <li v-for="post in posts" :key="post.id" class="px-2 py-4">
                    <Link :href="post.id"><span class="font-semibold">{{ post.title }}</span></Link>
                </li>   
            </ul>
        </Container>
    </AppLayout>
</template>
``