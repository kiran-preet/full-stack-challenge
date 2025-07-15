<script setup lang="ts">

// ...existing code...
import AppLayout from '@/Layouts/AppLayout.vue';
import JobCard from '@/Components/JobCard.vue';
import JobFilters from '@/Components/JobFilters.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { Job } from '@/types';

import { watch, onMounted, ref } from 'vue';

const darkMode = ref(false);

onMounted(() => {
    // Always check localStorage on mount
    darkMode.value = localStorage.getItem('darkMode') === 'true';
    updateDarkClass(darkMode.value);
});

function toggleDarkMode() {
    darkMode.value = !darkMode.value;
    localStorage.setItem('darkMode', darkMode.value ? 'true' : 'false');
    updateDarkClass(darkMode.value);
}

function updateDarkClass(isDark: boolean) {
    if (isDark) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
}

const props = defineProps<{
    jobs: {
        data: Job[];
        links: {
            first: string;
            last: string;
            prev: string | null;
            next: string | null;
        };
        next_page_url?: string;
        current_page?: number;
        last_page?: number;
    };
    filters: {
        position_type?: string;
        salary_min?: number;
        salary_max?: number;
        company?: string;
        location?: string;
    };
}>();

const jobsList = ref([...props.jobs.data]);
const nextPageUrl = ref(props.jobs.next_page_url || null);
const loadingMore = ref(false);

function loadMoreJobs() {
    if (!nextPageUrl.value) return;
    loadingMore.value = true;
    router.get(nextPageUrl.value, {}, {
        preserveState: true,
        preserveScroll: true,
        only: ['jobs'],
        onSuccess: (page) => {
            jobsList.value = [...jobsList.value, ...page.props.jobs.data];
            nextPageUrl.value = page.props.jobs.next_page_url;
            loadingMore.value = false;
        },
        onError: () => {
            loadingMore.value = false;
        }
    });
}
</script>

<template>
    <div :class="{ dark: darkMode }">
        <AppLayout>
            <div class="flex justify-end max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <button @click="toggleDarkMode" class="px-4 py-2 rounded bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 border border-gray-300 dark:border-gray-600">
                    <span v-if="darkMode">🌙 Dark</span>
                    <span v-else>☀️ Light</span>
                </button>
            </div>
            <Head title="Job Board" />
            
            <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen transition-colors duration-300">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="mb-8 text-center">
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">Find Your Dream Job</h1>
                        <p class="text-lg text-gray-600 dark:text-gray-300">Browse through our latest job listings</p>
                    </div>
                    
                    <JobFilters :filters="filters" />
                    
                    <div class="space-y-6">
                        <JobCard 
                            v-for="job in jobsList" 
                            :key="job.id" 
                            :job="job" 
                            class="transition-all duration-300 hover:scale-[1.01]"
                        />
                    </div>
                    <div class="mt-8 flex justify-center" v-if="nextPageUrl">
                        <button
                            @click="loadMoreJobs"
                            :disabled="loadingMore"
                            class="px-6 py-2 bg-indigo-600 dark:bg-indigo-500 text-white rounded-md hover:bg-indigo-700 dark:hover:bg-indigo-600 disabled:opacity-50"
                        >
                            <span v-if="loadingMore">Loading...</span>
                            <span v-else>Load More</span>
                        </button>
                    </div>
                    
                    <div v-if="jobs.data.length === 0" class="text-center py-12">
                        <p class="text-gray-500 dark:text-gray-400 text-lg">No jobs found matching your criteria.</p>
                        <Link 
                            :href="route('home')" 
                            class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 dark:bg-indigo-500 hover:bg-indigo-700 dark:hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Clear Filters
                        </Link>
                    </div>
                </div>
            </div>
        </AppLayout>
    </div>
</template>