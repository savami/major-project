<template>
    <AnimatedBackgroundLayout>
        <ProgressDots
            :current-question="currentQuestionIndex"
            :questions="questions"
            @change-question="currentQuestionIndex = $event"
        />

<!--        <div class="text-white text-center mt-10">-->
<!--            <h2 class="text-xl font-bold">Guidelines</h2>-->
<!--            <p>You can select multiple answers on the multiple choice questions</p>-->
<!--            <p>You can skip any question by clicking the next button without providing an answer</p>-->
<!--        </div>-->

        <div class="py-12 w-full">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <FormQuestion
                        v-if="currentQuestion"
                        :question="currentQuestion"
                        @answer="handleAnswer"
                        @back="previousQuestion"
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
import ProgressDots from "../../Components/Forms/ProgressDots.vue";

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
                background: '/img/button-backgrounds/img-orientation/portrait-orientation-bg-1.jpg'
            },
            {
                id: '2',
                title: 'Landscape',
                background: '/img/button-backgrounds/img-orientation/landscape-orientation-bg-1.jpg'
            },
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
            {
                id: '1',
                title: 'Minimalist',
                background: '/img/button-backgrounds/minimalist/minimalist-1.jpg'
            },
            {
                id: '2',
                title: 'Detailed',
                background: '/img/button-backgrounds/detailed/detailed-4.jpg'
            },
        ]
    },
    {
        id: '6',
        title: 'Do you prefer a modern or vintage setting?',
        example: '',
        answerType: 'multipleChoice',
        options: [
            {
                id: '1',
                title: 'Modern',
                background: '/img/button-backgrounds/modern/modern-1.jpg'
            },
            {
                id: '2',
                title: 'Vintage',
                background: '/img/button-backgrounds/vintage/vintage-1.jpg'
            },
        ]
    },
    {
        id: '7',
        title: 'What is the purpose of the photo?',
        example: 'Example: Professional style for businesses, while more creative for personal',
        answerType: 'text'
    },
];

const questionIdToFormKey = {
    '1': 'subject',
    '2': 'mood',
    '3': 'orientation',
    '4': 'elements',
    '5': 'style',
    '6': 'setting',
    '7': 'purpose',
};

let currentQuestionIndex = ref(0);

const form = useForm({
    subject: '',
    mood: '',
    orientation: '',
    elements: '',
    style: '',
    setting: '',
    purpose: '',
});


const currentQuestion = computed(() => questions[currentQuestionIndex.value]);

let answers = ref([]);

const nextQuestion = () => {
    currentQuestionIndex.value++;
    if (currentQuestionIndex.value >= questions.length) {
        submitForm();
    }
};
const previousQuestion = () => {
    if (currentQuestionIndex.value > 0) {
        currentQuestionIndex.value--;
    }
};

const handleAnswer = (payload) => {
    const formKey = questionIdToFormKey[payload.question];
    form[formKey] = payload.answer;
    nextQuestion();
};

const submitForm = async () => {
    await form.post('/photo-jobs');
    form.reset();
};
</script>
