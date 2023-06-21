<template>
    <div class="flex flex-col justify-between h-full">
        <div
            class="text-white bg-white bg-opacity-20 backdrop-blur-lg rounded drop-shadow-lg py-5 px-8 flex flex-col items-center justify-center">
            <h2 class="text-3xl font-bold mb-10 mt-8">{{ question.title }}</h2>

            <div v-if="question.answerType === 'text'" class="relative z-0 w-1/2 mb-6 group">
                <input
                    v-model="answer"
                    type="text"
                    placeholder=" "
                    class="block py-2.5 px-4 w-full text-sm text-white bg-transparent border-2 rounded-md border-white appearance-none focus:outline-none focus:ring-0 focus:border-2 focus:border-teal-300 transition duration-200 peer"/>
                <label
                    class="peer-focus:font-bold absolute text-sm text-white duration-300 pl-4 transform -translate-y-8 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:pl-0.5 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-90 peer-focus:-translate-y-9">
                    {{ question.example }}
                </label>
            </div>

            <div v-else-if="question.answerType === 'multipleChoice'" class="flex justify-evenly font-bold">
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

            <div class="self-end">
                <button @click="submitAnswer">Next</button>
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
</style>

<script setup>
import {ref} from 'vue';

const props = defineProps({
    question: Object,
});

const answer = ref('');
const selectedOptions = ref([]);

const isSelected = (option) => {
    return selectedOptions.value.some(o => o.id === option.id);
};

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

const emit = defineEmits(['answer']);
const submitAnswer = () => {
    if (props.question.answerType === 'text') {
        emit('answer', {question: props.question.id, answer: answer.value});
    } else if (props.question.answerType === 'multipleChoice') {
        emit('answer', {question: props.question.id, answer: selectedOptions.value.map(option => option.title)});
    }
};
</script>
