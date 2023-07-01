<template>
 <AnimatedBackgroundLayout>
    <h1 class="text-center my-8 text-3xl text-white font-bold">Results</h1>
     <div class="container">
         <div class="image-container" v-for="photo in pexelsResponse.photos" :key="photo.id">
             <a :href="photo.url" target="_blank">
                 <img :src="photo.src.medium" :alt="photo.alt" class="image" />
                 <div class="overlay">
                     <p class="photographer-name">Shot by: {{ photo.photographer }}</p>
                     <p class="view-on-pexels">Click to view on Pexels</p>
                 </div>
             </a>
         </div>
    </div>
 </AnimatedBackgroundLayout>
</template>

<style scoped>
.container {
    padding: 3rem;
    column-count: 3;
    column-gap: 2em;
    margin: 0 auto;
}

.image-container {
    position: relative;
    display: inline-block;
    width: 100%;
    margin-bottom: 2em;
    break-inside: avoid;
    transition: ease-in-out .3s;
    border-radius: 5px;
}

.image-container:hover {
    transform: scale(1.05); /* adjust as needed for desired hover scale effect */
}

.image-container a {
    display: block;
}

.image-container img {
    width: 100%;
    height: auto;
    display: block;
    border-radius: 5px;
}

.overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5); /* adjust as needed for desired dimming effect */
    opacity: 0;
    transition: opacity 0.3s ease-in-out;
    display: flex;
    flex-direction: column;
    justify-content: space-around;
    align-items: center;
}

.overlay p {
    color: #fff;
    text-align: center;
}

.image-container:hover .overlay {
    opacity: 1;
}

</style>

<script setup>
import AnimatedBackgroundLayout from "../../Layouts/AnimatedBackgroundLayout.vue";

const props = defineProps(
    {
        pexelsResponse: Object,
    }
)
</script>
