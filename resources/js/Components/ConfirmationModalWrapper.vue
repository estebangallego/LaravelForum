<script setup >
    import ConfirmationModal from '@/Components/ConfirmationModal.vue';
    import PrimaryButton from './PrimaryButton.vue';
    import SecondaryButton from './SecondaryButton.vue';
    import {useConfirm} from '@/Utilities/Composables/useConfirm.js';
    
    const {state, confirm, cancel} = useConfirm();

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
            <SecondaryButton class="ml-3" @click="cancel">
                Cancel
            </SecondaryButton>
        </template>

    </ConfirmationModal>
</template>