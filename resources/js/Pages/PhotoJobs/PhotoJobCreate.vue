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
        example: 'Example: Happy woman, sad man, a city, a plant, etc.',
        answerType: 'text'
    },
    // {
    //     id: '2',
    //     title: 'What mood should the photos be?',
    //     example: 'Example: Happy, sad, dark, bright, etc.',
    //     answerType: 'text'
    // },
    {
        id: '2',
        title: 'Are there specific elements to be included in the photo?',
        example: 'Example: Vintage style, guitar, landscape background, river, skyscrapers, etc.',
        answerType: 'text'
    },
    {
        id: '3',
        title: 'Should the photos be in portrait or landscape orientation?',
        example: 'Select one or skip if you don\'t care',
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
    // {
    //     id: '5',
    //     title: 'Do you prefer a minimalist style with lots of empty space, or a more detailed photo with many elements?',
    //     example: '',
    //     answerType: 'multipleChoice',
    //     options: [
    //         {
    //             id: '1',
    //             title: 'Minimalist',
    //             background: '/img/button-backgrounds/minimalist/minimalist-1.jpg'
    //         },
    //         {
    //             id: '2',
    //             title: 'Detailed',
    //             background: '/img/button-backgrounds/detailed/detailed-4.jpg'
    //         },
    //     ]
    // },
    // {
    //     id: '5',
    //     title: 'Do you prefer a modern or vintage setting?',
    //     example: '',
    //     answerType: 'multipleChoice',
    //     options: [
    //         {
    //             id: '1',
    //             title: 'Modern',
    //             background: '/img/button-backgrounds/modern/modern-1.jpg'
    //         },
    //         {
    //             id: '2',
    //             title: 'Vintage',
    //             background: '/img/button-backgrounds/vintage/vintage-1.jpg'
    //         },
    //     ]
    // },
    {
        id: '4',
        title: 'What should the size of the photo be?',
        example: 'Small (4MP), Medium (12MP), Large (24MP)',
        answerType: 'multipleChoice',
        options: [
            {
                id: '1',
                title: 'Small',
            },
            {
                id: '2',
                title: 'Medium',
            },
            {
                id: '3',
                title: 'Large',
            },
        ]
    },
    {
        id: '5',
        title: 'Which colors should be used in the photo?',
        example: 'Enter hex code or color name (e.g. #ffffff or white), or leave blank for any color',
        answerType: 'text',
    }
];

const questionIdToFormKey = {
    '1': 'subject',
    // '2': 'mood',
    '2': 'elements',
    '3': 'orientation',
    // '5': 'style',
    // '5': 'setting',
    '4': 'size',
    '5': 'color',
};

let currentQuestionIndex = ref(0);

const form = useForm({
    subject: '',
    // mood: '',
    elements: '',
    orientation: '',
    // style: '',
    // setting: '',
    size: '',
    color: '',
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
