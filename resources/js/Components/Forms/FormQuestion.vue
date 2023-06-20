<template>
    <div class="text-white bg-white bg-opacity-20 backdrop-blur-lg rounded drop-shadow-lg py-12 px-8">
        <h2 class="text-3xl font-bold mb-1">{{ question.title }}</h2>
        <p class="mb-6">{{ question.example }}</p>
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
