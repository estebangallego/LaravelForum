<script setup>
    import { formatDate } from '@/Utilities/date.js';
    import { router, usePage } from '@inertiajs/vue3';
    import { computed } from 'vue';
    const props = defineProps(['comment']);
    const emit = defineEmits(['delete', 'edit']);


    const canDelete = computed(() => {
        return usePage().props.auth.user.id === props.comment.user.id;
    });

</script>

<template>
    <div class="bg-white p-4 rounded-lg shadow">
      <div class="flex items-start">
        <img class="w-10 h-10 rounded-full" src="https://i.pravatar.cc/40" alt="User avatar">
        <div class="ml-3">
          <div class="text-sm font-medium text-gray-900">{{ comment.user.name }}</div>
          <span class="text-gray-500 text-sm">{{ formatDate(comment.created_at) }}</span>

          <div class="mt-1 prose prose-sm max-w-none" v-html="comment.html"></div>

          <div class="mt-2 flex items-center space-x-4">
            <button class="text-sm text-blue-600 hover:underline">Reply</button>
            <button class="text-sm text-gray-600 hover:underline">Like</button><span class="text-gray-500 text-sm">{{ comment.likes_count }}</span>
            <form v-if="comment.can?.update" @submit.prevent="$emit('edit', comment.id)">
              <button class="text-sm text-gray-600 hover:underline">Update</button>
            </form>
            <form v-if="comment.can?.delete" @submit.prevent="$emit('delete', comment.id)">
              <button class="text-sm text-red-600 hover:underline">Delete</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  