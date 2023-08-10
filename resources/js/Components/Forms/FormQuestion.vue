<template>
    <div class="flex flex-col justify-between min-h-fit">
        <div
            class="text-white bg-white bg-opacity-20 backdrop-blur-lg rounded drop-shadow-lg py-10 px-8 flex flex-col items-center justify-between quiz">
            <div class="">
                <h2 class="text-3xl font-bold mb-2.5 text-center">{{ question.title }}</h2>
                <p v-if="question.explanation" class="text-md text-center max-w-4xl">
                    {{ question.explanation }}</p>
                <p v-if="!question.explanation" class="text-md text-center max-w-4xl hidden"></p>
            </div>

            <div v-if="question.guidelines && question.answerType === 'text' && question.form === 'textJob'" class="-mt-10">
                <a :href="question.guidelines" target="_blank"
                   class="text-sm font-bold text-center max-w-4xl underline text-lime-300 hover:text-teal-300 transition duration-200">
                    Please refer to this link for guidelines and more information</a>
            </div>

            <div v-if="question.guidelines && question.answerType === 'text' && question.form === 'photoJob'" class="-mt-20">
                <p class="text-sm font-bold text-center max-w-4xl text-lime-300 transition duration-200">
                    {{ question.guidelines }}
                </p>
            </div>

            <div v-if="question.guidelines && question.answerType === 'multipleChoice'">
                <p class="text-sm font-bold text-center max-w-4xl text-lime-300">{{ question.guidelines }}</p>
            </div>

            <div v-if="question.answerType === 'text'" class="relative z-0 w-2/3 group">
                <input
                    @keyup.enter="submitAnswer"
                    @keydown="resetError"
                    v-model="answer"
                    type="text"
                    placeholder=" "
                    :class="{'block py-2.5 px-4 w-full text-sm text-white bg-transparent border-2 rounded-md border-white appearance-none focus:outline-none focus:ring-0 focus:border-2 focus:border-teal-300 transition duration-200 peer' : true, 'border-red-500 focus:border-red-500' : error}"/>
                <label
                    class="peer-focus:font-bold absolute text-sm text-white duration-300 pl-4 transform -translate-y-8 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:pl-0.5 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-90 peer-focus:-translate-y-9">
                    {{ question.example }}
                </label>
                <div v-if="error"
                     class="text-red-500 text-sm font-bold mt-1 ml-0.5 transition-all ease-in-out duration-75 h-2">
                    {{ error }}
                </div>
                <div v-else class="text-red-500 text-sm font-bold mt-1 ml-0.5 transition-all ease-in-out duration-75 h-2"></div>
            </div>

            <div v-if="question.answerType === 'number'" class="relative z-0 w-2/3 group">
                <input
                    @keyup.enter="submitAnswer"
                    @keydown="resetError"
                    v-model.number="answer"
                    type="number"
                    min="1"
                    max="500"
                    placeholder=" "
                    :class="{'block py-2.5 px-4 w-full text-sm text-white bg-transparent border-2 rounded-md border-white appearance-none focus:outline-none focus:ring-0 focus:border-2 focus:border-teal-300 transition duration-200 peer' : true, 'border-red-500 focus:border-red-500' : error}"/>
                <label
                    class="peer-focus:font-bold absolute text-sm text-white duration-300 pl-4 transform -translate-y-8 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:pl-0.5 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-90 peer-focus:-translate-y-9">
                    {{ question.example }}
                </label>
                <div v-if="error"
                     class="text-red-500 text-sm font-bold mt-1 ml-0.5 transition-all ease-in-out duration-75 h-2">
                    {{ error }}
                </div>
                <div v-else class="text-red-500 text-sm font-bold mt-1 ml-0.5 transition-all ease-in-out duration-75 h-2"></div>
            </div>


<!--            <div v-else-if="question.answerType === 'multipleChoice'"-->
<!--                 :class="`grid gap-10 my-10 justify-items-center font-bold grid-cols-${question.options.length}`">-->
<!--                <button-->
<!--                    class="py-2.5 px-4 w-48 h-36 text-center text-lg my-6 text-white bg-transparent border-2 rounded-md border-white appearance-none focus:outline-none focus:ring-0 focus:border-2 transition duration-200 bg-cover button-with-bg hover:scale-105"-->
<!--                    :class="{ 'selected': isSelected(option) }"-->
<!--                    @click="selectOption(option)"-->
<!--                    v-for="(option, index) in question.options"-->
<!--                    :key="index"-->
<!--                    :style="{ '&#45;&#45;image-url': `url(${option.background})`}">-->
<!--                    <span>{{ option.title }}</span>-->
<!--                </button>-->
<!--                <div v-if="error"-->
<!--                     class="text-red-500 text-sm font-bold mt-1 ml-0.5 transition-all ease-in-out duration-75 h-2">-->
<!--                    {{ error }}-->
<!--                </div>-->
<!--                <div v-else class="text-red-500 text-center text-sm font-bold mt-1 ml-0.5 transition-all ease-in-out duration-75 h-2"></div>-->
<!--            </div>-->

            <div v-else-if="question.answerType === 'multipleChoice'"
                 :class="`flex flex-wrap justify-center items-center mt-6 mb-10 font-bold`">
                <button
                    class="py-2.5 px-4 w-48 h-36 text-center text-lg my-6 mx-5 text-white bg-transparent border-2 rounded-md border-white appearance-none focus:outline-none focus:ring-0 focus:border-2 transition duration-200 bg-cover button-with-bg hover:scale-105"
                    :class="{ 'selected': isSelected(option) }"
                    @click="selectOption(option)"
                    v-for="(option, index) in question.options"
                    :key="index"
                    :style="{ '--image-url': `url(${option.background})`}">
                    <span>{{ option.title }}</span>
                </button>
                <div v-if="error"
                     class="text-red-500 text-sm font-bold mt-1 ml-0.5 transition-all ease-in-out duration-75 h-2 w-full text-center">
                    {{ error }}
                </div>
                <div v-else class="text-red-500 text-center text-sm font-bold mt-1 ml-0.5 transition-all ease-in-out duration-75 h-2 w-full"></div>
            </div>

            <div class="flex w-full justify-between items-center px-3">
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

                <button v-if="answer === '' && question.answerType === 'number'"
                        @click="submitAnswer"
                        class="inline-flex items-center gap-x-1.5 rounded-md bg-emerald-500 px-5 py-2.5 text-md font-semibold text-white shadow-sm hover:bg-green-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600 transition ease-in-out duration-75">
                    Skip
                    <ArrowRightIcon class="h-5 w-5 inline-block ml-1 text-white"/>
                </button>
                <button v-if="answer && question.answerType === 'number'"
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
    min-height: 50vh;
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

/*.grid-cols-1 {
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
}*/
</style>

<script setup>
import {ref, watchEffect} from 'vue';
import {ArrowRightIcon, ArrowLeftIcon} from "@heroicons/vue/20/solid";

const props = defineProps({
    question: Object,
    currentQuestionIndex: Number,
});

const answer = ref('');
const selectedOptions = ref([]);

// Resetting field after proceeding to next question
watchEffect(() => {
    if (props.question.answerType === 'text' || props.question.answerType === 'number') {
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
    resetError();

    const index = selectedOptions.value.findIndex(o => o.id === option.id);

    if (index !== -1) {
        // If the option is already selected, remove it from the array
        selectedOptions.value = [];
    } else {
        // If the option is not selected yet, deselect all other options and select this one
        selectedOptions.value = [option];
    }
};

// Emitting the answer or going back to previous question to the parent component
const emit = defineEmits(['answer', 'back']);

const error = ref('');

function resetError() {
    error.value = '';
}

const submitAnswer = () => {
    resetError();
    const currentQuestion = props.question

    if (currentQuestion.validation === true) {
        if (currentQuestion.answerType === 'text' && answer.value.trim() === '') {
            error.value = currentQuestion.error;
            return;
        } else if (currentQuestion.answerType === 'number' && (answer.value === '' || isNaN(answer.value))) {
            error.value = currentQuestion.error;
            return
        } else if (currentQuestion.validation && currentQuestion.answerType === 'multipleChoice' && selectedOptions.value.length === 0) {
            error.value = currentQuestion.error;
            return;
        }

    }

    if (props.question.answerType === 'text' || props.question.answerType === 'number') {
        // If the answer type is text or number, emit the answer
        emit('answer', {question: props.question.id, answer: answer.value});
        console.log(props.question.id, answer.value);
    } else if (props.question.answerType === 'multipleChoice') {
        // If the answer type is multiple choice, emit the selected options
        emit('answer', {question: props.question.id, answer: selectedOptions.value.map(option => option.title)});
        console.log(props.question.id, selectedOptions.value.map(option => option.title));
    }
};
</script>
