<script setup>
import {Head, Link} from '@inertiajs/vue3';
import {ref} from "vue";

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});

const clickedLogin = ref(false);
const clickedRegister = ref(false);
const clickedDashboard = ref(false);

const onClickLogin = () => {
    clickedLogin.value = true;
    setTimeout(() => clickedLogin.value = false, 1000); // Remove the class after 1 second

}

const onClickRegister = () => {
    clickedRegister.value = true;
    setTimeout(() => clickedRegister.value = false, 1000); // Remove the class after 1 second
}

const onClickDashboard = () => {
    clickedDashboard.value = true;
    setTimeout(() => clickedDashboard.value = false, 1000); // Remove the class after 1 second
}
</script>

<template>
    <Head title="Welcome"/>

    <div
        class="flex flex-col justify-center items-center h-screen background bg-center selection:bg-red-500 selection:text-white">
        <div class="mb-10 text-center">
            <h1 class="text-4xl font-bold text-white mb-2">Content Buddy</h1>
            <p v-if="!$page.props.auth.user" class="text-md text-white">Sign in or register to continue</p>
            <p v-if="$page.props.auth.user" class="text-md text-white">Proceed to the dashboard to start</p>
        </div>

        <div v-if="canLogin" class="flex space-x-4">
            <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                  @click="onClickDashboard"
                  :class="{'animate-ping' : clickedDashboard}"
                  class="font-semibold bg-white text-indigo-500 py-2 px-4 rounded-md hover:scale-110 transition-all duration-300 focus:outline-none">
                Go to dashboard
            </Link>
            <template v-else>
                <Link :href="route('login')"
                      @click="onClickLogin"
                      :class="{'animate-ping' : clickedLogin}"
                      class="font-semibold bg-white text-indigo-500 py-2 px-4 rounded-md hover:scale-110 transition-all duration-300 focus:outline-none">
                    Sign in
                </Link>
                <Link v-if="canRegister" :href="route('register')"
                      @click="onClickRegister"
                      :class="{'animate-ping' : clickedRegister}"
                      class="font-semibold bg-white text-indigo-500 py-2 px-4 rounded-md hover:scale-110 transition-all duration-300 focus:outline-none">
                    Register
                </Link>
            </template>
        </div>

        <div class="fixed bottom-5 justify-center mt-16 px-6 sm:items-center sm:justify-between">

            <div class="text-center text-sm text-gray-700 sm:text-left">
                <div class="flex items-center gap-4">
                    <a href="https://github.com/savami"
                       class="group inline-flex items-center transition-all focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                        <svg class="fill-gray-700" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                             viewBox="0 0 24 24">
                            <path
                                d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                        </svg>
                        <span class="pl-2 text-lg">Sava Miljkovic</span>
                    </a>
                </div>
            </div>
            <div class="wave"></div>
            <div class="wave"></div>
            <div class="wave"></div>
        </div>

    </div>
</template>

<style scoped>
.background {
    margin: auto;
    font-family: -apple-system, BlinkMacSystemFont, sans-serif;
    overflow: auto;
    background: linear-gradient(315deg, rgba(101, 0, 94, 1) 3%, rgba(60, 132, 206, 1) 38%, rgb(33, 133, 126) 68%, rgba(255, 25, 25, 1) 98%);
    background-size: 400% 400%;
    background-attachment: fixed;
    animation: gradient 15s ease infinite, fadeIn 1 1s ease-out;
    -webkit-animation: gradient 15s ease infinite, fadeIn 1 1s ease-out;
    -moz-animation: gradient 15s ease infinite, fadeIn 1 1s ease-out;
    -o-animation: gradient 15s ease infinite, fadeIn 1 1s ease-out;
}

@keyframes gradient {
    0% {
        background-position: 0% 0%;
    }
    50% {
        background-position: 100% 100%;
    }
    100% {
        background-position: 0% 0%;
    }
}

.wave {
    background: rgb(255 255 255 / 25%);
    border-radius: 1000% 1000% 0 0;
    position: fixed;
    width: 200%;
    height: 12em;
    animation: wave 10s -3s linear infinite;
    transform: translate3d(0, 0, 0);
    opacity: 0.8;
    bottom: 0;
    left: 0;
    z-index: -1;
}

.wave:nth-of-type(2) {
    bottom: -1.25em;
    animation: wave 18s linear reverse infinite;
    opacity: 0.8;
}

.wave:nth-of-type(3) {
    bottom: -2.5em;
    animation: wave 20s -1s reverse infinite;
    opacity: 0.9;
}

@keyframes wave {
    2% {
        transform: translateX(1);
    }

    25% {
        transform: translateX(-25%);
    }

    50% {
        transform: translateX(-50%);
    }

    75% {
        transform: translateX(-25%);
    }

    100% {
        transform: translateX(1);
    }
}

/* Switch Page Animations */
@-webkit-keyframes fadeIn{
    from{opacity: 0;}
    to{opacity: 1;}
}

@-moz-keyframes fadeIn{
    from{opacity: 0;}
    to{opacity: 1;}
}

@-o-keyframes fadeIn{
    from{opacity: 0;}
    to{opacity: 1;}
}

@keyframes fadeIn{
    from{opacity: 0;}
    to{opacity: 1;}
}
</style>
