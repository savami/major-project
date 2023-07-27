<template>
    <AnimatedBackgroundLayout>
        <h1 class="text-center my-8 text-3xl text-white font-bold">Result</h1>
        <div class="textToBeCopied relative">
            <pre id="typing-effect" class="text-gray-200 bg-white rounded bg-opacity-20 backdrop-blur-xl drop-shadow-lg max-w-4xl mx-auto">{{ displayedText }}</pre>
            <div class="text-center mt-8">
                <button
                    type="button"
                    @click="copyToClipboard"
                    class="inline-flex items-center gap-x-2 rounded-md bg-emerald-500 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition ease-in-out duration-150"
                >
                    <ClipboardIcon class="-ml-0.5 h-5 w-5" aria-hidden="true"/>
                    Copy to clipboard
                </button>
            </div>
        </div>
    </AnimatedBackgroundLayout>
</template>

<style scoped>
pre {
    white-space: pre-wrap;
    padding: 1rem 2rem;

}

#typing-effect::after {
    content: "|";
    animation: blink 1s steps(1) infinite;
}

@keyframes blink {
    50% {
        opacity: 0;
    }
}
</style>

<script setup>
import AnimatedBackgroundLayout from "../../Layouts/AnimatedBackgroundLayout.vue";
import {ClipboardIcon} from "@heroicons/vue/20/solid/index.js";
import {ref, watchEffect} from "vue";

const props = defineProps({
    seoText: {
        type: String,
        required: true
    }
})

let displayedText = ref('');
let currentIndex = ref(0);

watchEffect(() => {
    if (currentIndex.value < props.seoText.length) {
        setTimeout(() => {
            displayedText.value += props.seoText[currentIndex.value];
            currentIndex.value++;
        }, 10);
    }
});

function copyToClipboard() {
    // Create a new textarea element and give it id='temp_element'
    let textarea = document.createElement('textarea')
    textarea.id = 'temp_element'
    // Optional step to make less noise in the page, if any!
    textarea.style.height = 0
    // Now append it to your page somewhere, I chose <body>
    document.body.appendChild(textarea)
    // Give our textarea a value of whatever inside the seoText
    textarea.value = props.seoText
    // Now copy whatever inside the textarea to clipboard
    let selector = document.querySelector('#temp_element')
    selector.select()
    document.execCommand('copy')
    // Remove the textarea
    document.body.removeChild(textarea)
    console.log("Text has been copied to clipboard");
}
</script>
