<script setup lang="ts">
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import { debounce } from 'lodash';
import { route } from 'ziggy-js';


const props = defineProps<{
    filters: {
        position_type?: string;
        salary_min?: number;
        salary_max?: number;
        company?: string;
        location?: string;
    };
}>();

const open = ref(false);

const positionType = ref(props.filters.position_type || '');
const salaryMin = ref(props.filters.salary_min ?? 0);
const salaryMax = ref(props.filters.salary_max ?? 200000);
const companyFilter = ref(props.filters.company || '');
const locationFilter = ref(props.filters.location || '');


const applyFilters = debounce(() => {
    router.get(route('home'), {
        position_type: positionType.value,
        salary_min: salaryMin.value,
        salary_max: salaryMax.value,
        company: companyFilter.value,
        location: locationFilter.value,
    }, {
        preserveState: true,
        replace: true,
    });
}, 300);

watch([positionType, salaryMin, salaryMax, companyFilter, locationFilter], applyFilters);
</script>

<template>
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md mb-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Filters</h3>
            <button 
                @click="open = !open" 
                class="sm:hidden text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-100"
                aria-controls="filter-content"
                :aria-expanded="open"
            >
                <span>{{ open ? 'Hide Filters' : 'Show Filters' }}</span>
            </button>
        </div>

        <div id="filter-content" :class="{ 'hidden sm:block': !open, 'block': open }">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div>
                    <label for="position_type" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Position Type</label>
                    <select
                        id="position_type"
                        v-model="positionType"
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                    >
                        <option value="">All Types</option>
                        <option value="remote">Remote</option>
                        <option value="in-person">In-Person</option>
                        <option value="hybrid">Hybrid</option>
                    </select>
                </div>
                
                <div>
                    <label for="salary" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Salary Range</label>
                    <div class="flex items-center space-x-2">
                        <span class="text-xs text-gray-500 dark:text-gray-300">${{ salaryMin.toLocaleString() }}</span>
                        <input
                            id="salary-slider-min"
                            type="range"
                            min="0"
                            max="200000"
                            step="5000"
                            v-model="salaryMin"
                            @input="salarySlider = [Number(salaryMin), Number(salaryMax)]"
                            class="w-1/2"
                        />
                        <span class="text-xs text-gray-500 dark:text-gray-300">${{ salaryMax.toLocaleString() }}</span>
                        <input
                            id="salary-slider-max"
                            type="range"
                            min="0"
                            max="200000"
                            step="5000"
                            v-model="salaryMax"
                            @input="salarySlider = [Number(salaryMin), Number(salaryMax)]"
                            class="w-1/2"
                        />
                    </div>
                    <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">Selected: ${{ salaryMin.toLocaleString() }} - ${{ salaryMax.toLocaleString() }}</div>
                </div>
                
                <div>
                    <label for="company" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Company</label>
                    <input
                        id="company"
                        v-model="companyFilter"
                        type="text"
                        placeholder="Filter by company"
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                    />
                </div>
                
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Location</label>
                    <input
                        id="location"
                        v-model="locationFilter"
                        type="text"
                        placeholder="Filter by location"
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                    />
                </div>
            </div>
        </div>
    </div>
</template>