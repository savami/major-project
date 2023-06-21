<template>
    <div class="text-white bg-white bg-opacity-20 backdrop-blur-lg rounded drop-shadow-lg py-12 px-8">
        <h2 class="text-3xl font-bold mb-10">{{ question.title }}</h2>
        <p class="mb-6"></p>
        <div class="relative z-0 w-full mb-6 group">
            <input
                v-model="answer"
                type="text"
                placeholder=" "
                class="block py-2.5 px-4 w-full text-sm text-white bg-transparent border-1 rounded-md border-white appearance-none focus:outline-none focus:ring-0 focus:border-2 focus:border-teal-300 transition duration-200 peer"
            />
            <label class="peer-focus:font-medium absolute text-sm text-white duration-300 pl-4 transform -translate-y-8 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:pl-0.5 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-90 peer-focus:-translate-y-9">{{ question.example }}</label>
        </div>
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
