<script setup >
    import ConfirmationModal from '@/Components/ConfirmationModal.vue';
    import PrimaryButton from './PrimaryButton.vue';
    import SecondaryButton from './SecondaryButton.vue';
    import {useConfirm} from '@/Utilities/Composables/useConfirm.js';
    import { watchEffect, ref, nextTick } from 'vue';
    
    const {state, confirm, cancel} = useConfirm();
    const cancelButtonRef = ref(null);

    watchEffect( async () => {
        if (state.show) {
            await nextTick();
            cancelButtonRef.value?.$el.focus();
        }
    });

</script>


<template>
    <ConfirmationModal :show="state.show">
        <template #title>
            {{ state.title }}
        </template>

        <template #content>
            {{ state.message }}
        </template>

        <template #footer>
            <PrimaryButton @click="confirm">
                Confirm
            </PrimaryButton>
            <SecondaryButton ref="cancelButtonRef" class="ml-3" @click="cancel">
                Cancel
            </SecondaryButton>
        </template>

    </ConfirmationModal>
</template>