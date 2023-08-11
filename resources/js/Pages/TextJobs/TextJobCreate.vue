<template>
    <AnimatedBackgroundLayout title="Generate text">
        <ProgressDots
            :current-question="currentQuestionIndex"
            :questions="questions"
            @change-question="currentQuestionIndex = $event"
        />

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
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
        form: 'textJob',
        validation: true,
        error: 'A reference to your text is required',
        title: 'Give your text a title, so you can find it later in your dashboard',
        example: 'Example: Solar panel text, electric scooter text, porsche car text, etc.',
        explanation: 'This is purely for you to be able to find your text later in your dashboard',
        answerType: 'text',
    },
    {
        id: '2',
        validation: true,
        form: 'textJob',
        error: 'A subject is required',
        title: 'What is the subject of the text?',
        example: 'Example: How to clean an air purifier, electric scooter rentals, plumber company, etc.',
        explanation: 'Choose this carefully, because this is what the text will mainly be about. A good practice is to enter what the main title of the text would be.',
        answerType: 'text',
    },
    {
        id: '3',
        validation: true,
        form: 'textJob',
        error: 'A word count is required',
        title: 'How many words should the text be?',
        example: 'Enter the number of words you want the text to be approximately',
        explanation: '',
        answerType: 'number',
    },
    {
        id: '4',
        validation: true,
        form: 'textJob',
        error: 'A tone is required',
        title: 'What should the tone of the text be?',
        example: '',
        explanation: 'This is not important for SEO ratings, but it is important for the goal of the text and what kind of audience you want to reach. If in doubt, select straight forward.',
        answerType: 'multipleChoice',
        options: [
            {
                id: '1',
                title: 'Professional',
                background: '/img/button-backgrounds/text-tone/professional-bg-1.jpg'
            },
            {
                id: '2',
                title: 'Casual',
                background: '/img/button-backgrounds/text-tone/casual-bg-1.jpg'
            },
            {
                id: '3',
                title: 'Straightforward',
                background: '/img/button-backgrounds/text-tone/straightforward-bg-1.jpg'
            },
            {
                id: '4',
                title: 'Confident',
                background: '/img/button-backgrounds/text-tone/confident-bg-1.jpg'
            },
            {
                id: '5',
                title: 'Friendly',
                background: '/img/button-backgrounds/text-tone/friendly-bg-1.jpg'
            }
        ]
    },
    {
        id: '5',
        validation: true,
        form: 'textJob',
        error: 'A purpose is required',
        title: 'What is the purpose of the text?',
        example: '',
        answerType: 'multipleChoice',
        explanation: 'Select informational for a text that informs the reader. Select commercial for a text that promotes a product or service. Select transactional for a text that guides the reader to take action to buy a product. Select instructional for a text that teaches the reader how to do something, and entertainment for a text that entertains the reader.',
        options: [
            {
                id: '1',
                title: 'Informational',
                background: '/img/button-backgrounds/text-purpose/informational-bg-1.jpg'
            },
            {
                id: '2',
                title: 'Commercial',
                background: '/img/button-backgrounds/text-purpose/commercial-bg-1.jpg'
            },
            {
                id: '3',
                title: 'Transactional',
                background: '/img/button-backgrounds/text-purpose/transactional-bg-1.jpg'
            },
            {
                id: '4',
                title: 'Instructional',
                background: '/img/button-backgrounds/text-purpose/instructional-bg-1.jpg'
            },
            {
                id: '5',
                title: 'Entertainment',
                background: '/img/button-backgrounds/text-purpose/entertainment-bg-1.jpg'
            }
        ]
    },
    {
        id: '6',
        validation: true,
        form: 'textJob',
        error: 'A primary keyword is required',
        title: 'What is your primary keyword?',
        example: 'Example: Solar panel, electric scooter, porsche car, etc.',
        answerType: 'text',
        explanation: 'This is the main keyword you want the text to rank for in Google. Only enter your main keyword here. If you add more here, the tool will be confused and inconsistent.',
        guidelines: 'https://dotknowledge.uk/articles/view-article/how-to-find-secondary-keywords-to-enhance-your-seo',
    },
    {
        id: '7',
        validation: true,
        form: 'textJob',
        error: 'At least one secondary keyword is required',
        title: 'What are your secondary keywords?',
        example: 'Example: How to install solar panels, best electric scooter 2023, porsche car engine, etc.',
        explanation: 'These are the secondary keywords you want the text to rank for in Google. Separate each keyword with a comma.',
        answerType: 'text',
        guidelines: 'https://dotknowledge.uk/articles/view-article/how-to-find-secondary-keywords-to-enhance-your-seo',
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
        validation: true,
        form: 'textJob',
        error: 'A call to action is required',
        title: 'What is the call to action?',
        example: '',
        explanation: 'Having a call to action is very important. No text is simply random, it has a purpose. The purpose of the text is to get the user to do something. What do you want the user to do after reading the text?',
        answerType: 'multipleChoice',
        options: [
            {
                id: '1',
                title: 'Buy now',
                background: '/img/button-backgrounds/text-cta/buynow-bg-1.jpg'
            },
            {
                id: '2',
                title: 'Sign up',
                background: '/img/button-backgrounds/text-cta/signup-bg-1.jpg'
            },
            {
                id: '3',
                title: 'Contact us',
                background: '/img/button-backgrounds/text-cta/contactus-bg-1.jpg'
            },
            {
                id: '4',
                title: 'Learn more',
                background: '/img/button-backgrounds/text-cta/learnmore-bg-1.jpg'
            }
        ]
    },
    {
        id: '9',
        validation: false,
        form: 'textJob',
        title: 'What language should the text be in?',
        example: 'Example: German, French, Spanish, etc.',
        explanation: 'If you want the text to be in English, skip this question. If you want the text to be in another language, enter the language here. Keep in mind that results will be better for English texts',
        answerType: 'text',
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

// Compute the current question based on the current question index
const currentQuestion = computed(() => questions[currentQuestionIndex.value]);

const nextQuestion = () => {
    currentQuestionIndex.value++; // Increment the current question index
    if (currentQuestionIndex.value >= questions.length) {
        // If the current question index is greater than the total number of questions, submit the form
        submitForm();
    }
};

const previousQuestion = () => {
    if (currentQuestionIndex.value > 0) {
        // If the current question index is greater than 0, decrement the current question index
        currentQuestionIndex.value--;
    }
};

// Handle the answer to a question
const handleAnswer = (payload) => { // Payload is an object containing the question id and the answer
    const formKey = questionIdToFormKey[payload.question]; // Get the form key from the question id
    form[formKey] = payload.answer; // Set the form value
    nextQuestion(); // Go to the next question
};


const submitForm = async () => { // Submit the form
    await form.post('/text-jobs'); // Post the form to the server
    form.reset(); // Reset the form
};
</script>
