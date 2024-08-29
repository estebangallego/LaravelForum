<script setup>
    import { formatDate } from '@/Utilities/date.js';
    defineProps(['comment']);
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
            <span class="text-gray-500 text-sm">{{ formatDate(comment.created_at) }}</span>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  