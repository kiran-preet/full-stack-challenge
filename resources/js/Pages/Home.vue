<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import JobCard from '@/Components/JobCard.vue';
import JobFilters from '@/Components/JobFilters.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { Job } from '@/types';
import { ref, onMounted, watch } from 'vue';

// Dark mode handling
const darkMode = ref(false);

onMounted(() => {
  darkMode.value = localStorage.getItem('darkMode') === 'true';
  updateDarkClass(darkMode.value);
});

function toggleDarkMode() {
  darkMode.value = !darkMode.value;
  localStorage.setItem('darkMode', darkMode.value.toString());
  updateDarkClass(darkMode.value);
}

function updateDarkClass(isDark: boolean) {
  document.documentElement.classList.toggle('dark', isDark);
}

// Props definition
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

// Reactive state
const jobsList = ref<Job[]>([]);
const nextPageUrl = ref<string | null>(null);
const loadingMore = ref(false);
const filtersLoading = ref(false);

// Initialize state from props
const initializeFromProps = () => {
  jobsList.value = [...props.jobs.data];
  nextPageUrl.value = props.jobs.next_page_url || null;
};

// Initialize on component mount
onMounted(initializeFromProps);

// Watch for prop changes (happens when filters change)
watch(() => props.jobs, (newJobs) => {
  jobsList.value = [...newJobs.data];
  nextPageUrl.value = newJobs.next_page_url || null;
}, { deep: true });

const handleLoading = (isLoading: boolean) => {
  filtersLoading.value = isLoading;
};

// Load more jobs handler
async function loadMoreJobs() {
  if (!nextPageUrl.value || loadingMore.value) return;
  
  loadingMore.value = true;
  
  // Ensure the URL uses HTTPS if we're on HTTPS
  let nextUrl = nextPageUrl.value;
  if (window.location.protocol === 'https:' && nextUrl.startsWith('http:')) {
    nextUrl = nextUrl.replace('http:', 'https:');
  }

  try {
    const response = await router.get(nextUrl, {}, {
      preserveState: true,
      preserveScroll: true,
      only: ['jobs'],
      onSuccess: (page) => {
        // Append new jobs to existing list
        jobsList.value = [...jobsList.value, ...page.props.jobs.data];
        nextPageUrl.value = page.props.jobs.next_page_url || null;

        // Smooth scroll to the newly loaded content
        /*setTimeout(() => {
          const lastJobCard = document.querySelector('.job-card:last-child');
          if (lastJobCard) {
            lastJobCard.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
          }
        }, 100);*/
      }
    });
  } catch (error) {
    console.error('Error loading more jobs:', error);
  } finally {
    loadingMore.value = false;
  }
}
</script>

<template>
  <div :class="{ dark: darkMode }">
    <AppLayout>
      <!-- Dark Mode Toggle -->
      <div class="flex justify-end max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <button 
          @click="toggleDarkMode" 
          class="px-4 py-2 rounded bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 border border-gray-300 dark:border-gray-600 transition-colors duration-200"
        >
          <span v-if="darkMode">🌙 Dark Mode</span>
          <span v-else>☀️ Light Mode</span>
        </button>
      </div>

      <Head title="Job Board" />
      
      <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <!-- Header -->
          <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">Find Your Dream Job</h1>
            <p class="text-lg text-gray-600 dark:text-gray-300">Browse through our latest job listings</p>
          </div>
          
          <!-- Filters -->
          <JobFilters 
            :filters="filters" 
            @loading="handleLoading"
          />
          
          <!-- Loading State -->
          <div v-if="filtersLoading" class="flex justify-center py-8">
            <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-indigo-500"></div>
          </div>
          
          <!-- Jobs List -->
          <div v-else class="space-y-6">
            <JobCard 
              v-for="job in jobsList" 
              :key="job.id" 
              :job="job" 
              class="job-card transition-all duration-300 hover:scale-[1.01]"
            />
          </div>
          
          <!-- Load More Button -->
          <div class="mt-8 flex justify-center" v-if="nextPageUrl && !filtersLoading">
            <button
              @click="loadMoreJobs"
              :disabled="loadingMore"
              class="px-6 py-2 bg-indigo-600 dark:bg-indigo-500 text-white rounded-md hover:bg-indigo-700 dark:hover:bg-indigo-600 disabled:opacity-50 transition-colors duration-200 flex items-center"
            >
              <span v-if="loadingMore" class="flex items-center">
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Loading...
              </span>
              <span v-else>Load More Jobs</span>
            </button>
          </div>
          
          <!-- End of results message -->
          <div v-if="!nextPageUrl && jobsList.length > 0 && !filtersLoading" class="text-center py-4">
            <p class="text-gray-500 dark:text-gray-400 italic">You've reached the end of the results</p>
          </div>
          
          <!-- Empty State -->
          <div v-if="!filtersLoading && jobsList.length === 0" class="text-center py-12">
            <p class="text-gray-500 dark:text-gray-400 text-lg">No jobs found matching your criteria.</p>
            <Link 
              :href="route('home')" 
              class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 dark:bg-indigo-500 hover:bg-indigo-700 dark:hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200"
            >
              Clear Filters
            </Link>
          </div>
        </div>
      </div>
    </AppLayout>
  </div>
</template>