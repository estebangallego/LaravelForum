<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Container from '@/Components/Container.vue';
    defineProps(['post']);

    const formatDate = (date) => {
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        return new Date(date).toLocaleDateString('en', options);
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
        </Container>

    </AppLayout>
</template>