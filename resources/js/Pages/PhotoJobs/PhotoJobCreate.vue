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
                <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
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
        validation: true,
        form: 'photoJob',
        error: 'This field is required',
        title: 'What is the subject of the photos?',
        example: 'Example: Happy woman, sad man, New York, palm tree, etc.',
        explanation: 'Choose this carefully. This is the main subject of the photos. Keep this as short and concise as possible.',
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
        validation: true,
        form: 'photoJob',
        error: 'This field is required',
        title: 'Are there specific elements or styles to be included in the photo?',
        example: 'Example: Vintage, birds, bicycle, car, river, skyscrapers, etc.',
        explanation: 'This is the secondary parameter, which will be used to further specify the desired result. Specify anything that should be included in the photo.',
        answerType: 'text'
    },
    {
        id: '3',
        validation: false,
        form: 'photoJob',
        title: 'Do you wish to have a specific orientation?',
        example: '',
        explanation: 'Selecting one of these might limit the amount of results.',
        guidelines: 'It is recommended to skip this question if you are unsure.',
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
            {
                id: '3',
                title: 'Square',
                background: '/img/button-backgrounds/img-orientation/square-orientation-bg-1.jpg'
            }
        ]
    },
    {
        id: '4',
        validation: false,
        form: 'photoJob',
        title: 'Which style of photo do you prefer?',
        example: '',
        explanation: 'Specify a specific style of photo that you prefer. Keep in mind that this might limit the amount of results.',
        guidelines: 'It is recommended to skip this question if you are unsure.',
        answerType: 'multipleChoice',
        options: [
            {
                id: '1',
                title: 'Regular',
                background: '/img/button-backgrounds/regular/regular-bg-1.jpg'
            },
            {
                id: '2',
                title: 'Monochrome',
                background: '/img/button-backgrounds/monochrome/monochrome.jpg'
            },
        ]
    },
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
        id: '5',
        validation: false,
        form: 'photoJob',
        title: 'What should the size of the photo be?',
        example: '',
        explanation: 'These options affect the resolution of the photos. Small (4MP), Medium (12MP), Large (24MP).',
        answerType: 'multipleChoice',
        guidelines: 'It is recommended to skip this question if you are unsure.',
        options: [
            {
                id: '1',
                title: 'Small',
                background: '/img/button-backgrounds/general-bg.jpg',
            },
            {
                id: '2',
                title: 'Medium',
                background: '/img/button-backgrounds/general-bg.jpg',
            },
            {
                id: '3',
                title: 'Large',
                background: '/img/button-backgrounds/general-bg.jpg',
            },
        ]
    },
    {
        id: '6',
        validation: false,
        form: 'photoJob',
        title: 'Which color should be included in the photo?',
        explanation: 'This field specifies what color should be included in the photo. It is recommended to skip this question if you are unsure.',
        guidelines: 'Supported colors: red, orange, yellow, green, turquoise, blue, violet, pink, brown, black, gray, white or any hexadecimal color code.',
        example: 'Enter hex code or color name (e.g. #ffffff or white), or leave blank for any color',
        answerType: 'text',
    }
];

const questionIdToFormKey = {
    '1': 'subject',
    // '2': 'mood',
    '2': 'elements',
    '3': 'orientation',
    '4': 'style',
    // '5': 'setting',
    '5': 'size',
    '6': 'color',
};

let currentQuestionIndex = ref(0);

const form = useForm({
    subject: '',
    // mood: '',
    elements: '',
    orientation: '',
    style: '',
    // setting: '',
    size: '',
    color: '',
});

const currentQuestion = computed(() => questions[currentQuestionIndex.value]);

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
