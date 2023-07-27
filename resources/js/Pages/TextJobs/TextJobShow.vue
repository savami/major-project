<template>
    <AnimatedBackgroundLayout>
        <h1 class="text-center my-8 text-3xl text-white font-bold">Result</h1>
        <div class="textToBeCopied relative p-4">
            <pre class="text-gray-200">{{ seoText }}</pre>
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
    padding: 0 11rem;

}
</style>

<script setup>
import AnimatedBackgroundLayout from "../../Layouts/AnimatedBackgroundLayout.vue";
import {ClipboardIcon} from "@heroicons/vue/20/solid/index.js";

const props = defineProps({
    seoText: {
        type: String,
        required: true
    }
})

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
