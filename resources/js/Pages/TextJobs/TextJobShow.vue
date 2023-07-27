<template>
    <AnimatedBackgroundLayout>
        <h1 class="text-center my-8 text-3xl text-white font-bold">Result</h1>
        <div id="typewriter">
            <pre class="text-gray-200">{{ seoText }}</pre>
        </div>
    </AnimatedBackgroundLayout>
</template>

<style scoped>
pre {
    white-space: pre-wrap;
    padding: 0 11rem;

}
</style>

<script setup>
import AnimatedBackgroundLayout from "../../Layouts/AnimatedBackgroundLayout.vue";

const props = defineProps({
    seoText: {
        type: String,
        required: true
    }
})
</script>
