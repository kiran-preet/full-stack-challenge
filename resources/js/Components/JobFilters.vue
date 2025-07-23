<script setup lang="ts">
import { ref, watch, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import { debounce } from 'lodash';
import { route } from 'ziggy-js';

const emit = defineEmits(['loading']);

const props = defineProps<{
    filters: {
        position_type?: string;
        salary_min?: number;
        salary_max?: number;
        company?: string;
        location?: string;
    };
}>();

// Reactive state
const open = ref(false);
const positionType = ref(props.filters.position_type || '');
const salaryMin = ref(props.filters.salary_min ?? 0);
const salaryMax = ref(props.filters.salary_max ?? 200000);
const companyFilter = ref(props.filters.company || '');
const locationFilter = ref(props.filters.location || '');
const isFiltering = ref(false);

// Computed properties
const salaryRangeText = computed(() => {
    return `$${salaryMin.value.toLocaleString()} - $${salaryMax.value.toLocaleString()}`;
});

const hasActiveFilters = computed(() => {
    return positionType.value !== '' || 
           companyFilter.value !== '' || 
           locationFilter.value !== '' ||
           salaryMin.value !== 0 || 
           salaryMax.value !== 200000;
});

// Debounced filter application
const applyFilters = debounce(() => {
    isFiltering.value = true;
    emit('loading', true);
    
    router.get(route('home'), {
        position_type: positionType.value,
        salary_min: salaryMin.value,
        salary_max: salaryMax.value,
        company: companyFilter.value,
        location: locationFilter.value,
    }, {
        preserveState: true,
        replace: true,
        preserveScroll: true,
        onFinish: () => {
            isFiltering.value = false;
            emit('loading', false);
        }
    });
}, 500);

// Watch for filter changes
watch([positionType, salaryMin, salaryMax, companyFilter, locationFilter], () => {
    applyFilters();
});

// Clear all filters
function clearFilters() {
    positionType.value = '';
    salaryMin.value = 0;
    salaryMax.value = 200000;
    companyFilter.value = '';
    locationFilter.value = '';
}
</script>

<template>
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md mb-6 transition-colors duration-300">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Filters</h3>
            
            <div class="flex items-center space-x-4">
                <!-- Active filters badge -->
                <span 
                    v-if="hasActiveFilters" 
                    class="px-2 py-1 text-xs font-medium rounded-full bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-100"
                >
                    Active Filters
                </span>
                
                <!-- Clear filters button -->
                <button
                    v-if="hasActiveFilters"
                    @click="clearFilters"
                    class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline"
                    :disabled="isFiltering"
                >
                    Clear all
                </button>
                
                <!-- Mobile toggle button -->
                <button 
                    @click="open = !open" 
                    class="sm:hidden text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-100 transition-colors duration-200"
                    aria-controls="filter-content"
                    :aria-expanded="open"
                >
                    <span class="sr-only">{{ open ? 'Hide' : 'Show' }} filters</span>
                    <svg 
                        xmlns="http://www.w3.org/2000/svg" 
                        class="h-5 w-5" 
                        viewBox="0 0 20 20" 
                        fill="currentColor"
                    >
                        <path 
                            v-if="!open"
                            fill-rule="evenodd" 
                            d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" 
                            clip-rule="evenodd" 
                        />
                        <path 
                            v-else
                            fill-rule="evenodd" 
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" 
                            clip-rule="evenodd" 
                        />
                    </svg>
                </button>
            </div>
        </div>

        <div 
            id="filter-content" 
            :class="{ 
                'hidden sm:block': !open, 
                'block': open 
            }"
        >
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Position Type Filter -->
                <div>
                    <label for="position_type" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                        Position Type
                    </label>
                    <select
                        id="position_type"
                        v-model="positionType"
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md transition-colors duration-200"
                        :disabled="isFiltering"
                    >
                        <option value="">All Types</option>
                        <option value="remote">Remote</option>
                        <option value="in-person">In-Person</option>
                        <option value="hybrid">Hybrid</option>
                    </select>
                </div>
                
                <!-- Salary Range Filter -->
                <div>
                    <label for="salary" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                        Salary Range
                    </label>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-500 dark:text-gray-400">$0</span>
                            <span class="text-xs font-medium text-indigo-600 dark:text-indigo-400">
                                {{ salaryRangeText }}
                            </span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">$200K+</span>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="salary_min" class="sr-only">Minimum salary</label>
                                <input
                                    id="salary_min"
                                    type="range"
                                    min="0"
                                    max="200000"
                                    step="5000"
                                    v-model="salaryMin"
                                    class="w-full h-2 bg-gray-200 dark:bg-gray-600 rounded-lg appearance-none cursor-pointer"
                                    :disabled="isFiltering"
                                />
                            </div>
                            <div>
                                <label for="salary_max" class="sr-only">Maximum salary</label>
                                <input
                                    id="salary_max"
                                    type="range"
                                    min="0"
                                    max="200000"
                                    step="5000"
                                    v-model="salaryMax"
                                    class="w-full h-2 bg-gray-200 dark:bg-gray-600 rounded-lg appearance-none cursor-pointer"
                                    :disabled="isFiltering"
                                />
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Company Filter -->
                <div>
                    <label for="company" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                        Company
                    </label>
                    <input
                        id="company"
                        v-model="companyFilter"
                        type="text"
                        placeholder="Filter by company"
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md transition-colors duration-200"
                        :disabled="isFiltering"
                    />
                </div>
                
                <!-- Location Filter -->
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                        Location
                    </label>
                    <input
                        id="location"
                        v-model="locationFilter"
                        type="text"
                        placeholder="Filter by location"
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md transition-colors duration-200"
                        :disabled="isFiltering"
                    />
                </div>
            </div>
            
            <!-- Loading Indicator -->
            <div v-if="isFiltering" class="mt-4 flex justify-center">
                <div class="animate-spin rounded-full h-5 w-5 border-t-2 border-b-2 border-indigo-500"></div>
            </div>
        </div>
    </div>
</template>