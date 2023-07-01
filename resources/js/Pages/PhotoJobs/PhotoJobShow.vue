<template>
 <AnimatedBackgroundLayout>
    <h1 class="text-center my-8 text-3xl text-white font-bold">Results</h1>

    <div class="grid grid-cols-3 gap-4">
        <div v-for="photo in pexelsResponse.photos" :key="photo.id" class="p-4">
            <img :src="photo.src.medium" :alt="photo.alt" class="w-full h-auto" />
            <h2 class="text-center mt-2">{{ photo.photographer }}</h2>
            <p class="text-center"><a :href="photo.url" target="_blank">View on Pexels</a></p>
        </div>
    </div>
 </AnimatedBackgroundLayout>
</template>

<script setup>
import AnimatedBackgroundLayout from "../../Layouts/AnimatedBackgroundLayout.vue";

const props = defineProps(
    {
        pexelsResponse: Object,
    }
)


</script>
