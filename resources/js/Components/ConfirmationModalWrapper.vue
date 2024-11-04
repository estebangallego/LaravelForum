<script setup>
    import ConfirmationModal from '@/Components/ConfirmationModal.vue';
    import PrimaryButton from './PrimaryButton.vue';
    import SecondaryButton from './SecondaryButton.vue';
</script>


<template>
    <ConfirmationModal :show="true">

        <template #title>
            Are you sure?
        </template>

        <template #content>
            Do you really want to delete this item?
        </template>

        <template #footer>
            <PrimaryButton @click="$emit('confirm')">
                Confirm
            </PrimaryButton>
            <SecondaryButton @click="$emit('close')">
                Cancel
            </SecondaryButton>
        </template>

    </ConfirmationModal>
</template>