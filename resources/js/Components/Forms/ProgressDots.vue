<template>
    <div class="max-w-5xl mx-auto mt-10 pb-4">
        <div class="flex pb-3">
            <div
                class="flex-1"
                v-for="(question, index) in questions"
                :key="index"
                @click="emit('change-question', index)"
            >
                <div class="w-5 h-5 mx-auto rounded-full text-lg text-white flex items-center">
                    <span
                        class="text-center w-full flex justify-center items-center"
                        :class="{
                            'text-white': index < currentQuestion,
                            'text-grey-darker': index >= currentQuestion
                        }"
                    >
                        <span class="material-icons-outlined text-teal-300" v-if="index < currentQuestion">check_circle</span>
                        <span class="material-icons-outlined" v-else>radio_button_unchecked</span>
                    </span>
                </div>
            </div>
        </div>
        <div class="flex text-xs content-center text-center">
            <div class="w-1/4 text-white" v-for="(question, index) in questions" :key="index">
                Question: {{ question.id }}
            </div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    currentQuestion: Number,
    questions: Array,
});
</script>
