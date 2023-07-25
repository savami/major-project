<template>
    <AnimatedBackgroundLayout title="Generate text">
        <ProgressDots
            :current-question="currentQuestionIndex"
            :questions="questions"
            @change-question="currentQuestionIndex = $event"
        />

        <div class="py-12 w-full">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <FormQuestion
                    v-if="currentQuestion"
                    :question="currentQuestion"
                    @answer="handleAnswer"
                    @back="previousQuestion"
                />
            </div>
    </AnimatedBackgroundLayout>
</template>

<script setup>
import {ref, computed} from 'vue';
import AnimatedBackgroundLayout from "../../Layouts/AnimatedBackgroundLayout.vue";
import ProgressDots from "../../Components/Forms/ProgressDots.vue";
import FormQuestion from "../../Components/Forms/FormQuestion.vue";
import {useForm} from "@inertiajs/vue3";

const questions = [
    {
        id: '1',
        title: 'Give your text a title, so you can find it later in your dashboard',
        example: '',
        answerType: 'text'
    },
    {
        id: '2',
        title: 'What is the subject of the text?',
        example: '',
        answerType: 'text'
    },
    {
        id: '3',
        title: 'How many words should the text be?',
        example: '',
        answerType: 'number',
    },
    {
        id: '4',
        title: 'What is the tone of the text?',
        example: '',
        answerType: 'multipleChoice',
        options: [
            {
                id: '1',
                title: 'Formal',
                background: ''
            },
            {
                id: '2',
                title: 'Informal',
                background: ''
            },
            {
                id: '3',
                title: 'Neutral',
            }
        ]
    },
    {
        id: '5',
        title: 'What is the purpose of the text?',
        example: '',
        answerType: 'multipleChoice',
        options: [
            {
                id: '1',
                title: 'Informational',
                background: ''
            },
            {
                id: '2',
                title: 'Commercial',
                background: ''
            },
            {
                id: '3',
                title: 'Transactional',
            },
            {
                id: '4',
                title: 'Instructional',
                background: ''
            },
            {
                id: '5',
                title: 'Entertainment',
                background: ''
            }
        ]
    },
    {
        id: '6',
        title: 'What is your primary keyword? (Max. 2 words)',
        example: '',
        answerType: 'text'
    },
    {
        id: '7',
        title: 'What are your secondary keywords? (Max. 5 words)',
        example: '',
        answerType: 'text'
    },
    {
        id: '8',
        title: 'What user questions are you targeting to answer? (Frequently searched by users)',
        example: '',
        answerType: 'text'
    },
    {
        id: '9',
        title: 'What is the call to action? (What do you want the user to do after reading the text?)',
        example: '',
        answerType: 'text'
    },
    {
        id: '10',
        title: 'What language should the text be in? (Skip for English)',
    }
]

</script>
