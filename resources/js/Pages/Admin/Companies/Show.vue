<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    company: Object,
    jobs: Object
});
</script>

<template>
    <AppLayout :title="company.name">
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">{{ company.name }}</h2>
                <div class="space-x-2">
                    <Link :href="route('admin.companies.jobs.create', company.id)" 
                          class="px-4 py-2 bg-green-600 text-white rounded-md">
                        Post Job
                    </Link>
                    <Link :href="route('admin.companies.edit', company.id)" 
                          class="px-4 py-2 bg-indigo-600 text-white rounded-md">
                        Edit
                    </Link>
                </div>
            </div>
        </template>

        <div class="py-6">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-8">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Company Information</h3>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                    <dl class="sm:divide-y sm:divide-gray-200">
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ company.email }}</dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Website</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <a :href="company.website" target="_blank" class="text-indigo-600 hover:text-indigo-900">{{ company.website }}</a>
                            </dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Total Jobs</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ jobs.total }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <h3 class="text-lg font-medium text-gray-900 mb-4">Job Postings</h3>
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Salary</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="job in jobs.data" :key="job.id">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <Link :href="route('admin.jobs.show', job.id)" 
                                      class="text-indigo-600 hover:text-indigo-900">
                                    {{ job.title }}
                                </Link>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ job.position_type }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                ${{ job.salary_min.toLocaleString() }} - ${{ job.salary_max.toLocaleString() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <Link :href="route('admin.jobs.edit', job.id)" 
                                      class="text-indigo-600 hover:text-indigo-900 mr-3">
                                    Edit
                                </Link>
                                <Link method="delete" 
                                      :href="route('admin.jobs.destroy', job.id)" 
                                      class="text-red-600 hover:text-red-900">
                                    Delete
                                </Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>