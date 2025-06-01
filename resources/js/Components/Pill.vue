<template>
    <Link 
        :href="href"
        class=" overflow-auto whitespace-nowrap rounded-full py-0.5 px-2  text-gray-500  text-sm border  border-gray-300 hover:bg-indigo-500  hover:text-white  transition-colors  mb-2 mt-2 md:mt-0 "
        :class="{' bg-indigo-500 text-white transition-colors mb-2 mt-2 md:mt-0 ': filled}"
        >
        <slot></slot>
    </Link>
</template>

<script setup>
    import { Link } from '@inertiajs/vue3';
    defineProps({
        href: {
            type: String,
            required: true,
        },
        filled: {
            default:false,
        },
    });
</script>