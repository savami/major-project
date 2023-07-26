<template>
    <div class="flex flex-col justify-between h-full">
        <div
            class="text-white bg-white bg-opacity-20 backdrop-blur-lg rounded drop-shadow-lg py-5 px-8 flex flex-col items-center justify-around quiz">
            <h2 class="text-3xl font-bold mt-4 mb-2 text-center">{{ question.title }}</h2>
            <p v-if="question.explanation" class="text-md text-center max-w-4xl h-12">{{ question.explanation }}</p>
            <p v-if="!question.explanation" class="text-md text-center max-w-4xl h-12"></p>
            <div v-if="question.answerType === 'text'" class="relative z-0 w-2/3 my-20 group">
                <input
                    @keyup.enter="submitAnswer"
                    v-model="answer"
                    type="text"
                    placeholder=" "
                    class="block py-2.5 px-4 w-full mb-6 text-sm text-white bg-transparent border-2 rounded-md border-white appearance-none focus:outline-none focus:ring-0 focus:border-2 focus:border-teal-300 transition duration-200 peer"/>
                <label
                    class="peer-focus:font-bold absolute text-sm text-white duration-300 pl-4 transform -translate-y-8 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:pl-0.5 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-90 peer-focus:-translate-y-9">
                    {{ question.example }}
                </label>
            </div>

            <div v-else-if="question.answerType === 'multipleChoice'"
                 :class="`grid gap-10 my-10 justify-items-center font-bold grid-cols-${question.options.length}`">
                <button
                    class="py-2.5 px-4 w-48 h-36 text-center text-lg my-6 text-white bg-transparent border-2 rounded-md border-white appearance-none focus:outline-none focus:ring-0 focus:border-2 transition duration-200 bg-cover button-with-bg hover:scale-105"
                    :class="{ 'selected': isSelected(option) }"
                    @click="selectOption(option)"
                    v-for="(option, index) in question.options"
                    :key="index"
                    :style="{ '--image-url': `url(${option.background})`}">
                    <span>{{ option.title }}</span>
                </button>
            </div>

            <div class="flex w-full justify-between items-center mb-4 px-2.5">
                <button @click="$emit('back')"
                        class="inline-flex items-center gap-x-1.5 rounded-md bg-amber-500 px-5 py-2.5 text-md font-semibold text-white shadow-sm hover:bg-amber-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600 transition ease-in-out duration-75">
                    <ArrowLeftIcon class="h-5 w-5 inline-block mr-1 text-white"/>
                    Back
                </button>

                <button v-if="selectedOptions.length === 0 && question.answerType === 'multipleChoice'"
                        @click="submitAnswer"
                        class="inline-flex items-center gap-x-1.5 rounded-md bg-emerald-500 px-5 py-2.5 text-md font-semibold text-white shadow-sm hover:bg-green-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600 transition ease-in-out duration-75">
                    Skip
                    <ArrowRightIcon class="h-5 w-5 inline-block ml-1 text-white"/>
                </button>
                <button v-if="selectedOptions.length > 0 && question.answerType === 'multipleChoice'"
                        @click="submitAnswer"
                        class="inline-flex items-center gap-x-1.5 rounded-md bg-emerald-500 px-5 py-2.5 text-md font-semibold text-white shadow-sm hover:bg-green-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600 transition ease-in-out duration-75">
                    Next
                    <ArrowRightIcon class="h-5 w-5 inline-block ml-1 text-white"/>
                </button>

                <button v-if="answer === '' && question.answerType === 'text'"
                        @click="submitAnswer"
                        class="inline-flex items-center gap-x-1.5 rounded-md bg-emerald-500 px-5 py-2.5 text-md font-semibold text-white shadow-sm hover:bg-green-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600 transition ease-in-out duration-75">
                    Skip
                    <ArrowRightIcon class="h-5 w-5 inline-block ml-1 text-white"/>
                </button>
                <button v-if="answer && question.answerType === 'text'"
                        @click="submitAnswer"
                        class="inline-flex items-center gap-x-1.5 rounded-md bg-emerald-500 px-5 py-2.5 text-md font-semibold text-white shadow-sm hover:bg-green-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600 transition ease-in-out duration-75">
                    Next
                    <ArrowRightIcon class="h-5 w-5 inline-block ml-1 text-white"/>
                </button>
            </div>
        </div>
    </div>

</template>

<style scoped>
/*----------------------------------------------------------
   Required for background image styling inside of buttons
-----------------------------------------------------------*/
.button-with-bg {
    position: relative;
    overflow: hidden;
}

.quiz {
    min-height: 60vh;
}

.button-with-bg::after {
    background-image: var(--image-url);
    content: '';
    display: block;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    filter: brightness(60%);
    z-index: 1;
}

.button-with-bg span {
    position: relative;
    z-index: 2;
    text-shadow: 0 0 10px rgba(0, 0, 0, 1);
    letter-spacing: 1px;
}

.selected {
    border: #65ece2 2px solid;
    color: #65ece2;
}

.grid-cols-1 {
    grid-template-columns: repeat(1, minmax(0, 1fr)) !important;
}

.grid-cols-2 {
    grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
}

.grid-cols-3 {
    grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
}

.grid-cols-4 {
    grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
}

.grid-cols-5 {
    grid-template-columns: repeat(5, minmax(0, 1fr)) !important;
}

.grid-cols-6 {
    grid-template-columns: repeat(6, minmax(0, 1fr)) !important;
}
</style>

<script setup>
import {ref, watchEffect} from 'vue';
import {ArrowRightIcon, ArrowLeftIcon} from "@heroicons/vue/20/solid";

const props = defineProps({
    question: Object,
});

const answer = ref('');
const selectedOptions = ref([]);

// Resetting field after proceeding to next question
watchEffect(() => {
    if (props.question.answerType === 'text') {
        answer.value = '';
    } else if (props.question.answerType === 'multipleChoice') {
        selectedOptions.value = [];
    }
});

// Check if an option is selected
const isSelected = (option) => {
    return selectedOptions.value.some(o => o.id === option.id);
};

// Select an option
const selectOption = (option) => {
    const index = selectedOptions.value.findIndex(o => o.id === option.id);
    if (index !== -1) {
        // If the option is already selected, remove it from the array
        selectedOptions.value.splice(index, 1);
    } else {
        // If the option is not selected yet, add it to the array
        selectedOptions.value.push(option);
    }
};

// Emitting the answer or going back to previous question to the parent component
const emit = defineEmits(['answer', 'back']);
const submitAnswer = () => {
    if (props.question.answerType === 'text') {
        emit('answer', {question: props.question.id, answer: answer.value});
        console.log(props.question.id, answer.value);
    } else if (props.question.answerType === 'multipleChoice') {
        emit('answer', {question: props.question.id, answer: selectedOptions.value.map(option => option.title)});
        console.log(props.question.id, selectedOptions.value.map(option => option.title));
    }
};
</script>
