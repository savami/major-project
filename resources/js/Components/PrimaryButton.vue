<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <button :type="type" class="inline-flex items-center px-4 py-2 bg-white border border-transparent rounded-md font-semibold text-xs text-indigo-600 uppercase tracking-widest hover:bg-indigo-500 hover:text-white focus:bg-indigo-500 focus:text-white active:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition ease-in-out transition-250">
        <slot />
    </button>
</template>
