<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    companies: Object,
    recentJobs: Object,
    stats: Object
});
</script>

<template>
    <AppLayout title="Admin Dashboard">
        <template #header>
            <h2 class="text-xl font-semibold text-gray-800">Admin Dashboard</h2>
        </template>

        <div class="py-6">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-gray-500">Total Companies</h3>
                    <p class="text-3xl font-bold">{{ stats.companies }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-gray-500">Total Jobs</h3>
                    <p class="text-3xl font-bold">{{ stats.jobs }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-gray-500">Active Users</h3>
                    <p class="text-3xl font-bold">{{ stats.users }}</p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mb-8 flex space-x-4">
                <Link :href="route('admin.companies.create')" 
                      class="px-4 py-2 bg-indigo-600 text-white rounded-md">
                    Create New Company
                </Link>
                <Link :href="route('admin.jobs.create')" 
                      class="px-4 py-2 bg-green-600 text-white rounded-md">
                    Post New Job
                </Link>
            </div>

            <!-- Recent Companies -->
            <div class="bg-white shadow rounded-lg mb-8">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium">Recent Companies</h3>
                </div>
                <div class="divide-y divide-gray-200">
                    <div v-for="company in companies.data" :key="company.id" class="p-6 flex justify-between items-center">
                        <div>
                            <Link :href="route('admin.companies.show', company.id)" 
                                  class="text-lg font-medium text-indigo-600 hover:text-indigo-800">
                                {{ company.name }}
                            </Link>
                            <p class="text-gray-600">{{ company.jobs_count }} job postings</p>
                        </div>
                        <div class="flex space-x-2">
                            <Link :href="route('admin.companies.edit', company.id)" 
                                  class="text-sm text-gray-500 hover:text-gray-700">
                                Edit
                            </Link>
                            <Link method="delete" 
                                  :href="route('admin.companies.destroy', company.id)" 
                                  class="text-sm text-red-500 hover:text-red-700">
                                Delete
                            </Link>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Jobs -->
            <div class="bg-white shadow rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium">Recent Job Postings</h3>
                </div>
                <div class="divide-y divide-gray-200">
                    <div v-for="job in recentJobs.data" :key="job.id" class="p-6">
                        <div class="flex justify-between">
                            <div>
                                <Link :href="route('admin.jobs.show', job.id)" 
                                      class="text-lg font-medium text-indigo-600 hover:text-indigo-800">
                                    {{ job.title }}
                                </Link>
                                <p class="text-gray-600">{{ job.company.name }}</p>
                            </div>
                            <div class="flex space-x-2">
                                <Link :href="route('admin.jobs.edit', job.id)" 
                                      class="text-sm text-gray-500 hover:text-gray-700">
                                    Edit
                                </Link>
                                <Link method="delete" 
                                      :href="route('admin.jobs.destroy', job.id)" 
                                      class="text-sm text-red-500 hover:text-red-700">
                                    Delete
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>