<template>
    <AnimatedBackgroundLayout>
            <div class="py-12 w-full">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <FormQuestion
                        v-if="currentQuestion"
                        :question="currentQuestion"
                        @answer="handleAnswer"
                    />
                </div>
            </div>
    </AnimatedBackgroundLayout>
</template>

<script setup>
import {ref, computed} from 'vue';
import FormQuestion from "../../Components/Forms/FormQuestion.vue";
import AnimatedBackgroundLayout from "../../Layouts/AnimatedBackgroundLayout.vue";
import {useForm} from "@inertiajs/vue3";

const questions = [
    {
        id: '1',
        title: 'What is the subject of the photos?',
        example: 'Example: A person, a landscape, a city, an object, etc.',
        answerType: 'text'
    },
    {
        id: '2',
        title: 'What mood should the photos be?',
        example: 'Example: Happy, sad, dark, bright, etc.',
        answerType: 'text'
    },
    {
        id: '3',
        title: 'Should the photos be in portrait or landscape orientation?',
        example: '',
        answerType: 'multipleChoice',
        options: [
            {
                id: '1',
                title: 'Portrait',
                background: '/img/portrait-happy-man-showing-blank-signboard-isolated-white-background.jpg'
            },
            {
                id: '2',
                title: 'Landscape',
                background: '/img/sad-guy-holding-black-frame.jpg'
            },
            // { id: '3', title: 'Both' }
        ]
    },
    {
        id: '4',
        title: 'Are there specific elements to be included in the photo?',
        example: 'Example: Certain type of building, a specific color, etc.',
        answerType: 'text'
    },
    {
        id: '5',
        title: 'Do you prefer a minimalist style with lots of empty space, or a more detailed photo with many elements?',
        example: '',
        answerType: 'multipleChoice',
        options: [
            {id: '1', title: 'Minimalist'},
            {id: '2', title: 'Detailed'},
            {id: '3', title: 'Both'}
        ]
    },
    {
        id: '6',
        title: 'Do you prefer a modern or vintage setting?',
        example: '',
        answerType: 'multipleChoice',
        options: [
            {id: '1', title: 'Modern'},
            {id: '2', title: 'Vintage'},
            {id: '3', title: 'Both'}
        ]
    },
    {
        id: '7',
        title: 'What is the purpose of the photo?',
        example: 'Example: Professional style for businesses, while more creative for personal',
        answerType: 'text'
    },
];

let currentQuestionIndex = ref(0);

const {data, post, reset} = useForm({
    q1: '',
    q2: '',
    q3: '',
    q4: '',
    q5: '',
    q6: '',
    q7: '',
})

// let formAnswers = reactive({});

const currentQuestion = computed(() => questions[currentQuestionIndex.value]);

const handleAnswer = ({question, answer}) => {
    data[`q${question}`] = answer;
    nextQuestion();
};

const nextQuestion = () => {
    currentQuestionIndex.value++;
    if (currentQuestionIndex.value >= questions.length) {
        submitForm();
    }
};

const submitForm = () => {
    post('/photo-jobs').then(() => {
        reset('q1', 'q2', 'q3', 'q4', 'q5', 'q6', 'q7');
    });
};
</script>
