<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    job: Object,
    isAdmin: Boolean
});
</script>

<template>
    <AppLayout :title="job.company?.name ?? 'Job Details'">
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">{{ job.company?.name ?? 'Job Details' }}</h2>
                <div class="space-x-2" v-if="isAdmin">
                    <Link v-if="job.company" :href="route('admin.companies.jobs.create', job.company.id)" 
                          class="px-4 py-2 bg-green-600 text-white rounded-md">
                        Post Job
                    </Link>
                    <Link v-if="job.company" :href="route('admin.companies.edit', job.company.id)" 
                          class="px-4 py-2 bg-indigo-600 text-white rounded-md">
                        Edit
                    </Link>
                </div>
            </div>
        </template>

        <div class="py-6">
            <div v-if="!isAdmin" class="mb-4">
                <Link :href="route('home')" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                    &larr; Back to Job Listings
                </Link>
            </div>
            <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-8">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Company Information</h3>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                    <dl class="sm:divide-y sm:divide-gray-200">
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Company Name</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ job.company?.name ?? '-' }}</dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ job.company?.email ?? '-' }}</dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Website</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <a v-if="job.company?.website" :href="job.company.website" target="_blank" class="text-indigo-600 hover:text-indigo-900">{{ job.company.website }}</a>
                                <span v-else>-</span>
                            </dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Job Title</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ job.title }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <h3 class="text-lg font-medium text-gray-900 mb-4">Job Details</h3>
            <!-- Desktop Table -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg hidden md:block">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title/Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Salary</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase" v-if="isAdmin">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 whitespace-wrap">
                                {{ job.title }} <br/> {{ job.description }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ job.position_type }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                ${{ job.salary_min?.toLocaleString() }} - ${{ job.salary_max?.toLocaleString() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <template v-if="isAdmin">
                                    <Link :href="route('admin.jobs.edit', job.id)" 
                                          class="text-indigo-600 hover:text-indigo-900 mr-3">
                                        Edit
                                    </Link>
                                    <Link method="delete" 
                                          :href="route('admin.jobs.destroy', job.id)" 
                                          class="text-red-600 hover:text-red-900">
                                        Delete
                                    </Link>
                                </template>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Mobile Card -->
            <div class="bg-white shadow rounded-lg block md:hidden p-4">
                <div class="mb-2">
                    <span class="block text-xs font-medium text-gray-500">Title</span>
                    <span class="block text-base text-gray-900">{{ job.title }}</span>
                </div>
                <div class="mb-2">
                    <span class="block text-xs font-medium text-gray-500">Description</span>
                    <span class="block text-base text-gray-900">{{ job.description }}</span>
                </div>
                <div class="mb-2">
                    <span class="block text-xs font-medium text-gray-500">Type</span>
                    <span class="block text-base text-gray-900">{{ job.position_type }}</span>
                </div>
                <div class="mb-2">
                    <span class="block text-xs font-medium text-gray-500">Salary</span>
                    <span class="block text-base text-gray-900">${{ job.salary_min?.toLocaleString() }} - ${{ job.salary_max?.toLocaleString() }}</span>
                </div>
                <div v-if="isAdmin" class="flex space-x-2 mt-4">
                    <Link :href="route('admin.jobs.edit', job.id)" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</Link>
                    <Link method="delete" :href="route('admin.jobs.destroy', job.id)" class="text-red-600 hover:text-red-900">Delete</Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>