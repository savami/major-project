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

                        <!-- Add the two buttons -->
                        <div class="mt-6 space-x-4">
                            <Link :href="route('textJobs.create')"
                                  class="inline-block px-5 py-3 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                                Generate SEO text
                            </Link>
                            <Link :href="route('photoJobs.create')"
                                  class="inline-block px-5 py-3 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                                Find stock photos
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
import { Link } from "@inertiajs/vue3";
</script>
