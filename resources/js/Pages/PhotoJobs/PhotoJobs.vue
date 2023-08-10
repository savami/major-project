<template>
    <AnimatedBackgroundLayout>
        <div class="mx-auto max-w-fit sm:px-6 lg:px-8">
            <div class="px-4 sm:px-6 lg:px-8">
                <div v-if="photoJobs.length > 0"
                     class="flex flex-col justify-center items-center sm:flex-row sm:items-center px-0.5">
                    <div class="sm:flex-auto mt-8 mb-6">
                        <h1 class="text-base font-semibold leading-6 text-white">Photo Jobs</h1>
                        <p class="mt-2 text-sm text-white">A list of all the photo jobs you have created in your
                            account
                            including their date, title, style, size, and color.
                        </p>
                        <p class="text-sm text-emerald-400 font-bold">Click on either of them to view the results.</p>
                    </div>
                    <div class="sm:ml-16 sm:mt-0 sm:flex-none">
                        <button type="button"
                                @click="newPhotoJob"
                                class="block rounded-md bg-emerald-600 px-3 py-3 text-center text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600 transition ease-in-out duration-150">
                            New search
                        </button>
                    </div>
                </div>
                <div class="mt-8 flow-root bg-white rounded bg-opacity-20 backdrop-blur-lg drop-shadow-lg">
                    <div class="flex justify-center w-full">
                        <div v-if="photoJobs.length > 0" class="w-full py-4 align-middle sm:px-6 lg:px-8">
                            <table class="min-w-full divide-y divide-white divide-opacity-20 w-full">
                                <thead>
                                <tr>
                                    <th scope="col"
                                        class="py-4 pl-4 pr-3 text-left text-sm text-green-400 font-bold sm:pl-0">
                                        Title
                                    </th>
                                    <th scope="col" class="px-3 py-4 text-left text-sm text-green-400 font-bold">
                                        Date
                                    </th>
                                    <th scope="col" class="px-3 py-4 text-left text-sm text-green-400 font-bold">
                                        Style
                                    </th>
                                    <th scope="col" class="px-3 py-4 text-left text-sm text-green-400 font-bold">
                                        Size
                                    </th>
                                    <th scope="col" class="px-3 py-4 text-left text-sm text-green-400 font-bold">
                                        Color
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-white divide-opacity-20">
                                <tr v-for="job in photoJobs" :key="job.id" @click="openPhotoJob(job.user_id, job.id)"
                                    class="cursor-pointer transition-all ease-in-out duration-150"
                                    id="list-item"
                                >
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-white sm:pl-0">
                                        {{ job.subject + ' ' + job.elements }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-white">
                                        {{ formatDate(job.created_at) }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-white">
                                        {{ job.style ? job.style : '-' }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-white">
                                        {{ job.size ? job.size : '-' }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-white">
                                        {{ job.color ? job.color : '-' }}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <EmptyState v-if="photoJobs.length === 0"/>
        </div>
    </AnimatedBackgroundLayout>
</template>

<style scoped>
#list-item:hover {
    background-color: rgba(255, 255, 255, 0.2) !important;
}
</style>

<script setup>
import AnimatedBackgroundLayout from "../../Layouts/AnimatedBackgroundLayout.vue";
import {defineProps} from "vue";
import {usePage, router} from "@inertiajs/vue3";
import EmptyState from "../../Components/EmptyState.vue";

const page = usePage();

const props = defineProps({
    photoJobs: {
        type: Array,
        required: true
    }
});

function openPhotoJob(userId, jobId) {
    router.visit(`/photo-jobs/${userId}/${jobId}`);
}

function newPhotoJob() {
    router.visit(`/photo-jobs/create`);
}

function formatDate(date) {
    let d = new Date(date);
    let day = ('0' + d.getDate()).slice(-2);
    let month = ('0' + (d.getMonth() + 1)).slice(-2);
    let year = d.getFullYear();

    return `${day}-${month}-${year}`;
}

</script>
