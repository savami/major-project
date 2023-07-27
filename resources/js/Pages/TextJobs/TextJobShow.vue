<template>
    <AnimatedBackgroundLayout>
        <h1 class="text-center my-8 text-3xl text-white font-bold">Result</h1>
        <div class="textToBeCopied relative">
            <pre id="typing-effect"
                 class="text-gray-200 bg-white rounded bg-opacity-20 backdrop-blur-xl drop-shadow-lg max-w-4xl mx-auto">{{ displayedText }}</pre>
            <div class="text-center mt-8 flex justify-center space-x-8">
                <button
                    type="button"
                    @click="copyToClipboard"
                    class="inline-flex items-center gap-x-2 rounded-md bg-emerald-500 px-3.5 py-2.5 text-md font-semibold text-white shadow-sm hover:bg-emerald-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition ease-in-out duration-150"
                >
                    <ClipboardIcon class="-ml-0.5 h-5 w-5" aria-hidden="true"/>
                    Copy to clipboard
                </button>
                <button
                    v-if="!showDetails"
                    type="button"
                    @click="toggleShowDetails"
                    class="inline-flex items-center gap-x-2 rounded-md bg-purple-500 px-3.5 py-2.5 text-md font-semibold text-white shadow-sm hover:bg-purple-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-purple-600 transition ease-in-out duration-150"
                >
                    View details
                    <DocumentMagnifyingGlassIcon class="-mr-0.5 h-5 w-5" aria-hidden="true"/>
                </button>
                <button
                    v-if="showDetails"
                    type="button"
                    @click="toggleShowDetails"
                    class="inline-flex items-center gap-x-2 rounded-md bg-red-500 px-3.5 py-2.5 text-md font-semibold text-white shadow-sm hover:bg-red-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600 transition ease-in-out duration-150"
                >
                    Close Details
                    <XMarkIcon class="-mr-0.5 h-5 w-5" aria-hidden="true"/>
                </button>
            </div>
            <div v-show="showDetails" class="card mt-8 p-4 bg-white rounded shadow-lg w-full max-w-4xl mx-auto">
                <h2 class="text-xl font-bold mb-4">Details of "{{ textJob.name }}" text</h2>
                <div class="flex flex-wrap justify-between items-end">
                    <div class="w-full sm:w-1/3">
                        <h3 class="font-bold text-blue-600">Subject</h3>
                        <p>{{ textJob.subject }}</p>

                        <h3 class="font-bold text-blue-600 mt-4">Word Amount</h3>
                        <p>{{ textJob.word_amount }}</p>

                        <h3 class="font-bold text-blue-600 mt-4">Tone</h3>
                        <p>{{ textJob.text_tone }}</p>

                        <h3 class="font-bold text-blue-600 mt-4">Intent</h3>
                        <p>{{ textJob.audience_intent }}</p>
                    </div>

                    <div class="w-full sm:w-2/3">
                        <h3 class="font-bold text-blue-600 mt-4">Primary Keyword</h3>
                        <p>{{ textJob.primary_keyword }}</p>

                        <h3 class="font-bold text-blue-600 mt-4">Secondary Keywords</h3>
                        <p>{{ textJob.secondary_keywords }}</p>

                        <h3 class="font-bold text-blue-600 mt-4">Call to Action</h3>
                        <p>{{ textJob.call_to_action }}</p>

                        <h3 class="font-bold text-blue-600 mt-4">Output Language</h3>
                        <p v-if="!textJob.text_language">English</p>
                        <p v-if="textJob.text_language">{{ textJob.text_language }}</p>
                    </div>
                </div>
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

.textToBeCopied {
    display: flex;
    flex-direction: column;
    align-items: center;
    height: 100vh;
    overflow-y: auto;
}
</style>

<script setup>
import AnimatedBackgroundLayout from "../../Layouts/AnimatedBackgroundLayout.vue";
import {ClipboardIcon, DocumentMagnifyingGlassIcon, XMarkIcon} from "@heroicons/vue/20/solid/index.js";
import {ref, watchEffect} from "vue";

const props = defineProps({
    seoText: {
        type: String,
        required: true
    },
    textJob: {
        type: Array,
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

let showDetails = ref(false);

function toggleShowDetails() {
    showDetails.value = !showDetails.value;
}

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
