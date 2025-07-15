<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    url: String,
    confirmText: {
        type: String,
        default: 'Are you sure you want to delete this?'
    }
});

const form = useForm({});

const submit = () => {
    if (confirm(props.confirmText)) {
        form.delete(props.url);
    }
};
</script>

<template>
    <button @click="submit" 
            class="text-red-600 hover:text-red-900"
            :disabled="form.processing">
        <slot>Delete</slot>
    </button>
</template>