<template>
    <div class="text-center">
        <svg class="mx-auto h-12 w-12 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
        </svg>
        <h3 class="mt-2 text-md font-semibold text-green-400">You haven't generated any SEO texts</h3>
        <p class="mt-1 text-sm text-white">Get started by clicking the button below</p>
        <div class="mt-6">
            <button @click="newTextJob"
                    type="button"
                    class="inline-flex items-center rounded-md bg-emerald-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600 transition ease-in-out duration-75">
                <PlusIcon class="-ml-0.5 mr-1.5 h-5 w-5" aria-hidden="true" />
                New SEO Text
            </button>
        </div>
    </div>
</template>

<script setup>
import { PlusIcon } from '@heroicons/vue/20/solid';
import {router} from "@inertiajs/vue3";



function newTextJob() {
    router.visit(`/text-job/create`);
}
</script>
