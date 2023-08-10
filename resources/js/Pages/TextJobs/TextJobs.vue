<template>
    <AnimatedBackgroundLayout>
        <div class="mx-auto min-w-fit sm:px-6 lg:px-8">
            <div class="px-4 sm:px-6 lg:px-8">
                <div v-if="textJobs.length > 0"
                     class="flex flex-col justify-center items-center sm:flex-row sm:items-center px-0.5">
                    <div class="sm:flex-auto mt-8 mb-6">
                        <h1 class="text-base font-semibold leading-6 text-white">Text Jobs</h1>
                        <p class="mt-2 text-sm text-white">A list of all the generated SEO text you have created in your
                            account including their date, name, subject, tone, intent, main keyword, and CTA.
                        </p>
                        <p class="text-sm text-emerald-400 font-bold">Click on either of them to view the results and
                            the secondary keywords.</p>
                    </div>
                    <div class="sm:ml-16 sm:mt-0 sm:flex-none">
                        <button type="button"
                                @click="newTextJob"
                                class="block rounded-md bg-emerald-600 px-3 py-3 text-center text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600 transition ease-in-out duration-150">
                            Generate new text
                        </button>
                    </div>
                </div>
                <div class="mt-8 flow-root bg-white rounded bg-opacity-20 backdrop-blur-lg drop-shadow-lg">
                    <div class="flex justify-center w-full">
                        <div v-if="textJobs.length > 0" class="w-full py-4 align-middle sm:px-6 lg:px-8">
                            <table class="min-w-full divide-y divide-white divide-opacity-20 w-full">
                                <thead>
                                <tr>
                                    <th scope="col"
                                        class="py-4 pl-4 pr-3 text-left text-sm text-green-400 font-bold sm:pl-0">
                                        Name
                                    </th>
                                    <th scope="col" class="px-3 py-4 text-left text-sm text-green-400 font-bold">
                                        Date
                                    </th>
                                    <th scope="col" class="px-3 py-4 text-left text-sm text-green-400 font-bold">
                                        Subject
                                    </th>
                                    <!--                                    <th scope="col" class="px-3 py-4 text-left text-sm text-green-400 font-bold">-->
                                    <!--                                        Words-->
                                    <!--                                    </th>-->
                                    <th scope="col" class="px-3 py-4 text-left text-sm text-green-400 font-bold">
                                        Tone
                                    </th>
                                    <th scope="col" class="px-3 py-4 text-left text-sm text-green-400 font-bold">
                                        Intent
                                    </th>
                                    <th scope="col" class="px-3 py-4 text-left text-sm text-green-400 font-bold">
                                        Primary keyword
                                    </th>
                                    <!--                                    <th scope="col" class="px-3 py-4 text-left text-sm text-green-400 font-bold">-->
                                    <!--                                        Secondary keywords-->
                                    <!--                                    </th>-->
                                    <th scope="col" class="px-3 py-4 text-left text-sm text-green-400 font-bold">
                                        CTA
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-white divide-opacity-20">
                                <tr v-for="job in textJobs" :key="job.id" @click="openTextJob(job.user_id, job.id)"
                                    class="cursor-pointer transition-all ease-in-out duration-150"
                                    id="list-item"
                                >
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-white sm:pl-0">
                                        {{ job.name }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-white">
                                        {{ formatDate(job.created_at) }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-white">
                                        {{ job.subject }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-white">
                                        {{ job.text_tone }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-white">
                                        {{ job.audience_intent }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-white">
                                        {{ job.primary_keyword }}
                                    </td>
                                    <!--                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-white">-->
                                    <!--                                        {{ job.secondary_keywords }}-->
                                    <!--                                    </td>-->
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-white">
                                        {{ job.call_to_action }}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <EmptyState v-if="textJobs.length === 0"/>
        </div>
    </AnimatedBackgroundLayout>
</template>

<style scoped>
#list-item:hover {
    background-color: rgba(255, 255, 255, 0.2) !important;
}
</style>

<script setup>
import EmptyState from "../../Components/EmptyState.vue";
import AnimatedBackgroundLayout from "../../Layouts/AnimatedBackgroundLayout.vue";
import {defineProps} from "vue";
import {usePage, router} from "@inertiajs/vue3";

const page = usePage();

const props = defineProps({
    textJobs: {
        type: Array,
        required: true
    }
});

function openTextJob(userId, jobId) {
    router.visit(`/text-job/${userId}/${jobId}`);
}

function newTextJob() {
    router.visit(`/text-job/create`);
}

function formatDate(date) {
    let d = new Date(date);
    let day = ('0' + d.getDate()).slice(-2);
    let month = ('0' + (d.getMonth() + 1)).slice(-2);
    let year = d.getFullYear();

    return `${day}-${month}-${year}`;
}

</script>
