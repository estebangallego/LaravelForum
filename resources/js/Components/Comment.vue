<script setup>
    import { formatDate } from '@/Utilities/date.js';
    import { router, usePage } from '@inertiajs/vue3';
    import { computed } from 'vue';
    const props = defineProps(['comment']);
    const deleteComment = () => router.delete(route('comments.destroy', props.comment.id), {
        preserveScroll: true,
    });
    
    const canDelete = computed(() => {
        console.log(usePage().props.auth.user, props.comment.user.id);
        return usePage().props.auth.user.id === props.comment.user.id;
    });

</script>

<template>
    <div class="bg-white p-4 rounded-lg shadow">
      <div class="flex items-start">
        <img class="w-10 h-10 rounded-full" src="https://i.pravatar.cc/40" alt="User avatar">
        <div class="ml-3">
          <div class="text-sm font-medium text-gray-900">{{ comment.user.name }}</div>
          <p class="mt-1 text-sm text-gray-700">
            {{ comment.body }}
          </p>
          <div class="mt-2 flex items-center space-x-4">
            <button class="text-sm text-blue-600 hover:underline">Reply</button>
            <button class="text-sm text-gray-600 hover:underline">Like</button>
            <form v-if="canDelete" @submit.prevent="deleteComment">
              <button class="text-sm text-gray-600 hover:underline">Delete</button>
            </form>
            <span class="text-gray-500 text-sm">{{ formatDate(comment.created_at) }}</span>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  