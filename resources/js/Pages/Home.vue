<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import JobCard from '@/Components/JobCard.vue';
import JobFilters from '@/Components/JobFilters.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Job } from '@/types';

defineProps<{
    jobs: {
        data: Job[];
        links: {
            first: string;
            last: string;
            prev: string | null;
            next: string | null;
        };
    };
    filters: {
        position_type?: string;
        salary?: string;
        company?: string;
        location?: string;
    };
}>();
</script>

<template>
    <AppLayout>
        <Head title="Job Board" />
        
        <div class="py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mb-8 text-center">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Find Your Dream Job</h1>
                    <p class="text-lg text-gray-600">Browse through our latest job listings</p>
                </div>
                
                <JobFilters :filters="filters" />
                
                <div class="space-y-6">
                    <JobCard 
                        v-for="job in jobs.data" 
                        :key="job.id" 
                        :job="job" 
                        class="transition-all duration-300 hover:scale-[1.01]"
                    />
                </div>
                
                <div class="mt-8 flex justify-center" v-if="jobs.data.length > 0">
                    <nav class="flex items-center space-x-4">
                        <Link 
                            v-for="(link, index) in jobs.links" 
                            :key="index"
                            :href="link.url || '#'"
                            :class="{
                                'text-gray-500': !link.url,
                                'font-medium text-indigo-600': link.active,
                                'text-gray-700 hover:text-indigo-500': link.url && !link.active,
                            }"
                            class="px-4 py-2 rounded-md"
                            v-html="link.label"
                        />
                    </nav>
                </div>
                
                <div v-if="jobs.data.length === 0" class="text-center py-12">
                    <p class="text-gray-500 text-lg">No jobs found matching your criteria.</p>
                    <Link 
                        :href="route('home')" 
                        class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Clear Filters
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>