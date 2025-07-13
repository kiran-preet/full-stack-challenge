<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Job } from '@/types';

defineProps<{
    job: Job;
}>();
</script>

<template>
    <AppLayout>
        <Head :title="job.title" />
        
        <div class="py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-8">
                        <div class="flex items-start justify-between">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ job.title }}</h1>
                                <div class="flex items-center space-x-4 mb-6">
                                    <div class="shrink-0">
                                        <img 
                                            v-if="job.company.logo" 
                                            :src="`/storage/${job.company.logo}`" 
                                            :alt="job.company.name" 
                                            class="h-16 w-16 rounded-full object-cover"
                                        >
                                        <div v-else class="h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center">
                                            <span class="text-gray-500 text-2xl">{{ job.company.name.charAt(0) }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <h2 class="text-xl font-semibold text-gray-900">{{ job.company.name }}</h2>
                                        <p v-if="job.company.website" class="text-indigo-600 hover:text-indigo-500">
                                            <a :href="job.company.website" target="_blank" rel="noopener noreferrer">
                                                {{ job.company.website.replace(/^https?:\/\//, '') }}
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-right">
                                <span class="text-2xl font-bold text-gray-900">
                                    {{ job.salary_currency }} {{ job.salary_min.toLocaleString() }} - {{ job.salary_max.toLocaleString() }}
                                </span>
                                <p class="text-sm text-gray-500 mt-2">
                                    Posted {{ new Date(job.published_at).toLocaleDateString() }}
                                </p>
                                
                                <div class="mt-4 flex flex-wrap gap-2 justify-end">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                        {{ job.position_type }}
                                    </span>
                                    <span v-if="job.location" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                        {{ job.location }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-8 border-t border-gray-200 pt-8">
                            <h3 class="text-xl font-semibold text-gray-900 mb-4">Job Description</h3>
                            <div class="prose max-w-none text-gray-600" v-html="job.description"></div>
                        </div>
                        
                        <div class="mt-8 border-t border-gray-200 pt-8">
                            <h3 class="text-xl font-semibold text-gray-900 mb-4">How to Apply</h3>
                            <p class="text-gray-600">
                                Please send your resume and cover letter to 
                                <a :href="`mailto:${job.company.email}`" class="text-indigo-600 hover:text-indigo-500">
                                    {{ job.company.email }}
                                </a>
                                with the job title in the subject line.
                            </p>
                        </div>
                        
                        <div class="mt-8 flex justify-end space-x-4">
                            <Link 
                                :href="route('home')" 
                                class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                Back to Jobs
                            </Link>
                            <a 
                                :href="`mailto:${job.company.email}?subject=Application for ${job.title}`" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                Apply Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>