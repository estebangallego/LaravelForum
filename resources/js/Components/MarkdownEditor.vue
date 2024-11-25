<template>
    <div class="bg-white rounded-md shadow-sm border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400">
        <editor-content :editor="editor" />
    </div>
</template>

  <script setup>
    import { useEditor, EditorContent } from '@tiptap/vue-3'
    import StarterKit from '@tiptap/starter-kit'
    import { watch } from 'vue';
    // Including markdown extension: npm install tiptap-markdown
    import { Markdown } from 'tiptap-markdown';

    const props = defineProps({
        modelValue: '',
    });

    const emit = defineEmits(['update:modelValue']);

    const editor = useEditor({
      content: '<p>I’m running Tiptap with Vue.js. This will be the  Markdown!🎉</p>',
      extensions: [StarterKit, Markdown],
      editorProps: {
        attributes: {
          class: 'prose prose-sm max-w-none',
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

