<script setup>
import {Head, Link} from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});
</script>

<template>
    <Head title="Welcome"/>

    <div
        class="flex flex-col justify-center items-center h-screen bg-animated-gradient bg-center selection:bg-red-500 selection:text-white">
        <h1 class="text-4xl font-bold text-white">Content Buddy</h1>
        <p class="text-lg text-white mb-10">Sign in or register to continue</p>

        <div v-if="canLogin" class="flex space-x-4">
            <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                  class="bg-white py-2 px-4 rounded-md text-indigo-500 hover:text-indigo-900 focus:outline-none">
                Dashboard
            </Link>
            <template v-else>
                <Link :href="route('login')"
                      class="font-semibold bg-indigo-500 py-2 px-4 rounded-md text-white hover:bg-white hover:text-indigo-500 transition-all focus:outline-none">Log
                    in
                </Link>
                <Link v-if="canRegister" :href="route('register')"
                      class="font-semibold bg-indigo-500 py-2 px-4 rounded-md text-white hover:bg-white hover:text-indigo-500 transition-all focus:outline-none">
                    Register
                </Link>
            </template>
        </div>

        <div class="fixed bottom-5 justify-center mt-16 px-6 sm:items-center sm:justify-between">

            <div class="text-center text-sm text-white sm:text-left">
                <div class="flex items-center gap-4">
                    <a href="https://github.com/savami"
                       class="group inline-flex items-center transition-all focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                        <svg class="fill-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                             viewBox="0 0 24 24">
                            <path
                                d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                        </svg>
                        <span class="pl-2 text-lg">Sava Miljkovic</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
.bg-animated-gradient {
    background: linear-gradient(207deg, #e6c304, #e69b04, #e66a04, #33e370, #5ed9d5, #cb86ea);
    background-size: 1200% 1200%;

    -webkit-animation: AnimationName 14s ease infinite;
    -moz-animation: AnimationName 14s ease infinite;
    animation: AnimationName 14s ease infinite;
}

@-webkit-keyframes AnimationName {
    0% {
        background-position: 0% 77%
    }
    50% {
        background-position: 100% 24%
    }
    100% {
        background-position: 0% 77%
    }
}

@-moz-keyframes AnimationName {
    0% {
        background-position: 0% 77%
    }
    50% {
        background-position: 100% 24%
    }
    100% {
        background-position: 0% 77%
    }
}

@keyframes AnimationName {
    0% {
        background-position: 0% 77%
    }
    50% {
        background-position: 100% 24%
    }
    100% {
        background-position: 0% 77%
    }
}
</style>
