<template>
    <AnimatedBackgroundLayout title="Dashboard">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="rounded-md overflow-hidden h-auto py-12 px-6">
                    <div class="mx-auto max-w-2xl text-center">
                        <p class="text-base font-semibold leading-7 text-teal-400">Speed up your workflow</p>
                        <h1 class="text-4xl font-extrabold text-white tracking-tight sm:text-6xl">Content Buddy</h1>
                        <p class="mt-6 text-lg leading-8 text-white">Your AI assistant for SEO optimized texts and stock
                            photos</p>

                        <div class="mt-6 flex justify-center space-x-4">
                            <Link :href="route('textJobs.create')"
                                  class="inline-flex items-center px-5 py-4 border border-transparent text-lg leading-6 font-bold rounded-md text-white bg-emerald-500 hover:bg-green-400 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-green-600 transition duration-150 ease-in-out">
                                <ChatBubbleBottomCenterTextIcon class="mr-2 h-4 w-4" aria-hidden="true"/>
                                Generate SEO text
                            </Link>
                            <Link :href="route('photoJobs.create')"
                                  class="inline-flex items-center px-5 py-4 border border-transparent text-lg leading-6 font-bold rounded-md text-white bg-purple-500 hover:bg-purple-400 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-purple-600 transition duration-150 ease-in-out">
                                Find stock photos
                                <PhotoIcon class="ml-2 h-4 w-4" aria-hidden="true"/>
                            </Link>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AnimatedBackgroundLayout>
</template>

<script setup>
import AnimatedBackgroundLayout from "../Layouts/AnimatedBackgroundLayout.vue";
import { ChatBubbleBottomCenterTextIcon, PhotoIcon } from "@heroicons/vue/20/solid/index.js";
import { Link } from "@inertiajs/vue3";
</script>
