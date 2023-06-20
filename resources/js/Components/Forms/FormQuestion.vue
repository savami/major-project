<template>
    <div class="text-white bg-white bg-opacity-20 backdrop-blur-lg rounded drop-shadow-lg py-12 px-8">
        <h2 class="text-3xl font-bold mb-1">{{ question.title }}</h2>
        <p class="mb-6">{{ question.example }}</p>
        <div class="relative z-0 w-full mb-6 group">
            <input
                required
                type="email"
                name="floating_email"
                id="floating_email"
                placeholder=" "
                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
            />
            <label for="floating_email" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email address</label>
        </div>
        <input
            class="bg-transparent w-full py-2 px-4 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
            v-model="answer"
            @input="emitAnswer"
            placeholder="Type your answer here..."
        />
    </div>


</template>

<script setup>
import { ref } from 'vue';

defineProps({
    question: Object,
});

const answer = ref('');

const emit = defineEmits(['answer']);
const emitAnswer = () => {
    emit('answer', { question: props.question.id, answer: answer.value });
};
</script>
