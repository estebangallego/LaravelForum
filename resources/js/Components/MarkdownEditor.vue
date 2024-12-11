<template>
    <div v-if="editor" class="bg-white rounded-md shadow-sm border-0
         ring-1 ring-inset ring-gray-300
         placeholder:text-gray-400
         focus:ring-2 focus:ring-inset focus:ring-indigo-600">
         <menu class="flex divide-x border-b">
            <li>
                <button @click="() => editor.chain().focus().toggleBold().run()"
                    type="button"
                    class="px-3 py-2 rounded-tl-md"
                    :class="[editor.isActive('bold') ? 'bg-indigo-500 text-white' : 'hover:bg-gray-200']"
                    title="Bold">
                    <i class="ri-bold"></i>
                </button>
            </li>
            <li>
                <button @click="() => editor.chain().focus().toggleItalic().run()"
                    type="button"
                    class="px-3 py-2"
                    :class="[editor.isActive('italic') ? 'bg-indigo-500 text-white' : 'hover:bg-gray-200']"
                    title="Italic">
                    <i class="ri-italic"></i>
                </button>
            </li>
            <li>
                <button @click="() => editor.chain().focus().toggleStrike().run()"
                    type="button"
                    class="px-3 py-2"
                    :class="[editor.isActive('strike') ? 'bg-indigo-500 text-white' : 'hover:bg-gray-200']"
                    title="Strikethrough">
                    <i class="ri-strikethrough"></i>
                </button>
            </li>
            <li>
                <button @click="() => editor.chain().focus().toggleCodeBlock().run()"
                    type="button"
                    class="px-3 py-2"
                    :class="[editor.isActive('codeBlock') ? 'bg-indigo-500 text-white' : 'hover:bg-gray-200']"
                    title="Code Block">
                    <i class="ri-code-s-line"></i>
                </button>
            </li>
            <li> 
                <button @click="() => editor.chain().focus().toggleHeading({ level: 1 }).run()"
                    type="button"
                    class="px-3 py-2"
                    :class="[editor.isActive('heading', { level: 1 }) ? 'bg-indigo-500 text-white' : 'hover:bg-gray-200']"
                    title="Heading 1">
                    <i class="ri-h-1"></i>
                </button>
            </li>
            <li>
                <button @click="() => editor.chain().focus().toggleHeading({ level: 2 }).run()"
                    type="button"
                    class="px-3 py-2"
                    :class="[editor.isActive('heading', { level: 2 }) ? 'bg-indigo-500 text-white' : 'hover:bg-gray-200']"
                    title="Heading 2">
                    <i class="ri-h-2"></i>
                </button>
            </li>
            <li>
                <button @click="() => editor.chain().focus().toggleHeading({ level: 3 }).run()"
                    type="button"
                    class="px-3 py-2"
                    :class="[editor.isActive('heading', { level: 3 }) ? 'bg-indigo-500 text-white' : 'hover:bg-gray-200']"
                    title="Heading 3">
                    <i class="ri-h-3"></i>
                </button> 
            </li>
            <li>
                <button @click="() => editor.chain().focus().toggleBlockquote().run()"
                    type="button"
                    class="px-3 py-2"
                    :class="[editor.isActive('blockquxwote') ? 'bg-indigo-500 text-white' : 'hover:bg-gray-200']"
                    title="Quote">
                    <i class="ri-double-quotes-l"></i>
                </button>
            </li>
            <li>
                <button @click="() => editor.chain().focus().toggleBulletList().run()"
                    type="button"
                    class="px-3 py-2"
                    :class="[editor.isActive('bulletList') ? 'bg-indigo-500 text-white' : 'hover:bg-gray-200']"
                    title="Bullet List">
                    <i class="ri-list-unordered"></i>
                </button>
            </li>
            <li>
                <button @click="() => editor.chain().focus().toggleOrderedList().run()"
                    type="button"
                    class="px-3 py-2"
                    :class="[editor.isActive('orderedList') ? 'bg-indigo-500 text-white' : 'hover:bg-gray-200']"
                    title="Ordered List">
                    <i class="ri-list-ordered"></i>
                </button>
            </li>
            <li>
                <button @click="() => editor.chain().focus().setHorizontalRule().run()"
                    type="button"
                    class="px-3 py-2"
                    :class="[editor.isActive('horizontalRule') ? 'bg-indigo-500 text-white' : 'hover:bg-gray-200']"
                    title="Horizontal Rule">
                    <i class="ri-separator"></i>
                </button>
            </li>
         </menu>
        <editor-content :editor="editor" />
    </div>
</template>

  <script setup>
    import { useEditor, EditorContent } from '@tiptap/vue-3'
    import StarterKit from '@tiptap/starter-kit'
    import { watch } from 'vue';
    import 'remixicon/fonts/remixicon.css'
    // Including markdown extension: npm install tiptap-markdown
    import { Markdown } from 'tiptap-markdown';
    import Link from '@tiptap/extension-link';

    const props = defineProps({
        modelValue: '',
    });

    const emit = defineEmits(['update:modelValue']);

    const editor = useEditor({
      content: '<p>I’m running Tiptap with Vue.js. This will be the  Markdown!🎉</p>',
      extensions: [StarterKit, Markdown, Link],
      editorProps: {
        attributes: {
          class: 'min-h-[512px] prose prose-sm max-w-none py-2 px-3',
        },
      },
      onUpdate: () => {
        emit('update:modelValue', editor.value?.storage.markdown.getMarkdown());
      },
    });

    watch(() => props.modelValue, (value) => {
        if (value === editor.value?.storage.markdown.getMarkdown()) return;
        editor.value?.commands.setContent(value);
    }, { immediate: true });


  </script>

