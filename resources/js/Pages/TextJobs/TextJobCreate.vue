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
        example: 'This is purely for you to be able to find your text later in your dashboard',
        answerType: 'text',
        required: true
    },
    {
        id: '2',
        title: 'What is the subject of the text?',
        example: 'Example: Marketing agency, electric scooter rentals, plumber company, etc.',
        answerType: 'text',
        required: true
    },
    {
        id: '3',
        title: 'How many words should the text be?',
        example: 'Enter how many words you want the text to be (max. 500 words)',
        answerType: 'text',
        required: true
    },
    {
        id: '4',
        title: 'What is the tone of the text?',
        example: '',
        answerType: 'multipleChoice',
        required: false,
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
        required: false,
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
        example: 'Example: Solar panel, electric scooter, porsche car, etc.',
        answerType: 'text',
        required: true,
    },
    {
        id: '7',
        title: 'What are your secondary keywords?',
        example: 'Separate each keyword with a comma',
        answerType: 'text',
        required: false,
    },
    {
        id: '8',
        title: 'What user questions are you targeting to answer? (Frequently searched by users)',
        example: 'Example: What is the best e-scooter?',
        answerType: 'text',
        required: false,
    },
    {
        id: '9',
        title: 'What is the call to action? (What do you want the user to do after reading the text?)',
        example: '',
        answerType: 'multipleChoice',
        required: false,
        options: [
            {
                id: '1',
                title: 'Buy now',
                background: ''
            },
            {
                id: '2',
                title: 'Sign up',
                background: ''
            },
            {
                id: '3',
                title: 'Contact us',
                background: ''
            },
            {
                id: '4',
                title: 'Learn more',
                background: ''
            }
        ]
    },
    {
        id: '10',
        title: 'What language should the text be in? (Skip for English)',
        example: 'Example: German, French, Spanish, etc.',
        answerType: 'text',
        required: false,
    }
];

const questionIdToFormKey = {
    '1': 'name',
    '2': 'subject',
    '3': 'word_count',
    '4': 'text_tone',
    '5': 'audience_intent',
    '6': 'primary_keyword',
    '7': 'secondary_keywords',
    '8': 'frequently_asked_questions',
    '9': 'call_to_action',
    '10': 'text_language'
};

const currentQuestionIndex = ref(0);

const form = useForm({
    title: '',
    subject: '',
    wordCount: '',
    tone: '',
    purpose: '',
    primaryKeyword: '',
    secondaryKeywords: '',
    userQuestions: '',
    callToAction: '',
    language: '',
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
    await form.post('/text-jobs');
    form.reset();
};
</script>
