<template>
    <AnimatedBackgroundLayout title="Generate text">
        <ProgressDots
            :current-question="currentQuestionIndex"
            :questions="questions"
            @change-question="currentQuestionIndex = $event"
        />

        <div class="py-12">
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
import AnimatedBackgroundLayout from "../../Layouts/AnimatedBackgroundLayout.vue";
import ProgressDots from "../../Components/Forms/ProgressDots.vue";
import FormQuestion from "../../Components/Forms/FormQuestion.vue";
import {useForm} from "@inertiajs/vue3";

const questions = [
    {
        id: '1',
        title: 'Give your text a title, so you can find it later in your dashboard',
        example: 'Example: Solar panel text, electric scooter text, porsche car text, etc.',
        explanation: 'This is purely for you to be able to find your text later in your dashboard',
        answerType: 'text',
        required: true
    },
    {
        id: '2',
        title: 'What is the subject of the text?',
        example: 'Example: Marketing agency, electric scooter rentals, plumber company, etc.',
        explanation: 'Choose this carefully, because this is what the text will mainly be about. Keep this as short and concise as possible.',
        answerType: 'text',
        required: true
    },
    {
        id: '3',
        title: 'How many words should the text be?',
        example: 'Enter how many words you want the text to be (max. 500)',
        explanation: 'It will not work if any other characters than numbers are entered',
        answerType: 'number',
        required: true
    },
    {
        id: '4',
        title: 'What is the tone of the text?',
        example: '',
        explanation: 'This is not important for SEO ratings, but important for the goal of the text and what kind of audience you want to reach. If unsure, leave this blank and skip the question.',
        answerType: 'multipleChoice',
        required: false,
        options: [
            {
                id: '1',
                title: 'Professional',
                background: ''
            },
            {
                id: '2',
                title: 'Casual',
                background: ''
            },
            {
                id: '3',
                title: 'Straightforward',
                background: ''
            },
            {
                id: '4',
                title: 'Confident',
                background: '',
            },
            {
                id: '5',
                title: 'Friendly',
                background: ''
            }
        ]
    },
    {
        id: '5',
        title: 'What is the purpose of the text?',
        example: '',
        answerType: 'multipleChoice',
        explanation: 'Informational for a text that informs the reader. Commercial for a text that sells a product or service. transactional for a text that guides the reader to take action to buy a product, instructional for a text that teaches the reader how to do something, and entertainment for a text that entertains the reader. If in doubt, skip this question.',
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
                background: ''
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
        title: 'What is your primary keyword?',
        example: 'Example: Solar panel, electric scooter, porsche car, etc.',
        answerType: 'text',
        explanation: 'This is the main keyword you want the text to rank for in Google. Only enter your main keyword here. If you add more here, the tool will be confused and inconsistent.',
        required: true,
    },
    {
        id: '7',
        title: 'What are your secondary keywords?',
        example: 'Example: How to install solar panels, best electric scooter 2023, porsche car engine, etc.',
        explanation: 'These are the secondary keywords you want the text to rank for in Google. Separate each keyword with a comma.',
        answerType: 'text',
        required: false,
    },
    // {
    //     id: '8',
    //     title: 'What user questions are you targeting to answer?',
    //     example: 'Example: What is the best e-scooter?',
    //     explanation: 'These are the frequent questions users have regarding your text subject that you want the text to answer. Separate each question with a comma.',
    //     answerType: 'text',
    //     required: false,
    // },
    {
        id: '8',
        title: 'What is the call to action?',
        example: '',
        explanation: 'Having a call to action is very important. No text is simply random, it has a purpose. The purpose of the text is to get the user to do something. What do you want the user to do after reading the text?',
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
        id: '9',
        title: 'What language should the text be in?',
        example: 'Example: German, French, Spanish, etc.',
        explanation: 'If you want the text to be in English, skip this question. If you want the text to be in another language, enter the language here. Keep in mind that results will be better for English texts',
        answerType: 'text',
        required: false,
    }
];

const questionIdToFormKey = {
    '1': 'name',
    '2': 'subject',
    '3': 'word_amount',
    '4': 'text_tone',
    '5': 'audience_intent',
    '6': 'primary_keyword',
    '7': 'secondary_keywords',
    // '8': 'frequently_asked_questions',
    '8': 'call_to_action',
    '9': 'text_language'
};

const currentQuestionIndex = ref(0);

const form = useForm({
    name: '',
    subject: '',
    word_amount: '',
    text_tone: '',
    audience_intent: '',
    primary_keyword: '',
    secondary_keywords: '',
    // frequently_asked_questions: '',
    call_to_action: '',
    text_language: '',
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
