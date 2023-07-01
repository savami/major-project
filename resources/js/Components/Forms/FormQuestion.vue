<template>
    <div class="flex flex-col justify-between h-full">
        <div
            class="text-white bg-white bg-opacity-20 backdrop-blur-lg rounded drop-shadow-lg py-5 px-8 flex flex-col items-center justify-between h-96">
            <h2 class="text-3xl font-bold mt-4 text-center">{{ question.title }}</h2>
            <div v-if="question.answerType === 'text'" class="relative z-0 w-1/2 mb-6 group">
                <input
                    @keyup.enter="submitAnswer"
                    v-model="answer"
                    type="text"
                    placeholder=" "
                    class="block py-2.5 px-4 w-full text-sm text-white bg-transparent border-2 rounded-md border-white appearance-none focus:outline-none focus:ring-0 focus:border-2 focus:border-teal-300 transition duration-200 peer"/>
                <label
                    class="peer-focus:font-bold absolute text-sm text-white duration-300 pl-4 transform -translate-y-8 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:pl-0.5 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-90 peer-focus:-translate-y-9">
                    {{ question.example }}
                </label>
            </div>

            <div v-else-if="question.answerType === 'multipleChoice'"
                 :class="`grid gap-10 justify-items-center font-bold grid-cols-${question.options.length}`">
                <button
                    class="py-2.5 px-4 w-48 h-36 text-center text-lg text-white bg-transparent border-2 rounded-md border-white appearance-none focus:outline-none focus:ring-0 focus:border-2 transition duration-200 bg-cover button-with-bg hover:scale-105"
                    :class="{ 'selected': isSelected(option) }"
                    @click="selectOption(option)"
                    v-for="(option, index) in question.options"
                    :key="index"
                    :style="{ '--image-url': `url(${option.background})`}">
                    <span>{{ option.title }}</span>
                </button>
            </div>

            <div class="flex w-full justify-between items-center">
                <button @click="$emit('back')">Back</button>
                <button v-if="selectedOptions.length === 0 && question.answerType === 'multipleChoice'" @click="submitAnswer">Skip</button>
                <button v-else @click="submitAnswer">Next</button>
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
</style>

<script setup>
import {ref, watchEffect} from 'vue';

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
