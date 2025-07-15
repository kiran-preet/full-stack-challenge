<script setup lang="ts">
import { Job } from '@/types';
import { Link } from '@inertiajs/vue3';

defineProps<{
    job: Job;
}>();
</script>

<template>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg border dark:border-gray-700">
        <div class="p-6">
            <div class="flex items-start justify-between">
                <div>
                    <div class="flex items-center space-x-4">
                        <div class="shrink-0">
                            <img 
                                v-if="job.company.logo" 
                                :src="`/storage/${job.company.logo}`" 
                                :alt="job.company.name" 
                                class="h-12 w-12 rounded-full object-cover"
                                loading="lazy"
                            >
                            <div v-else class="h-12 w-12 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                <span class="text-gray-500 dark:text-gray-300 text-xl">{{ job.company.name.charAt(0) }}</span>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                <Link :href="route('jobs.show', job.id)" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                    {{ job.title }}
                                </Link>
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300">{{ job.company.name }}</p>
                        </div>
                    </div>
                    
                    <div class="mt-4 flex flex-wrap gap-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200">
                            {{ job.position_type }}
                        </span>
                        <span v-if="job.location" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                            {{ job.location }}
                        </span>
                    </div>
                </div>
                
                <div class="text-right">
                    <span class="text-lg font-bold text-gray-900 dark:text-gray-100">
                        {{ job.salary_currency }} {{ job.salary_min.toLocaleString() }} - {{ job.salary_max.toLocaleString() }}
                    </span>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Posted {{ new Date(job.published_at).toLocaleDateString() }}
                    </p>
                </div>
            </div>
            
            <div class="mt-4">
                <p class="text-gray-600 dark:text-gray-300 line-clamp-2">{{ job.description }}</p>
            </div>
            
            <div class="mt-6 flex justify-end">
                <Link 
                    :href="route('jobs.show', job.id)" 
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 dark:bg-indigo-500 hover:bg-indigo-700 dark:hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    View Details
                </Link>
            </div>
        </div>
    </div>
</template>