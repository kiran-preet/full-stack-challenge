<script setup lang="ts">
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import { debounce } from 'lodash';

const props = defineProps<{
    filters: {
        position_type?: string;
        salary?: string;
        company?: string;
        location?: string;
    };
}>();

const positionType = ref(props.filters.position_type || '');
const salaryRange = ref(props.filters.salary || '');
const companyFilter = ref(props.filters.company || '');
const locationFilter = ref(props.filters.location || '');

const emit = defineEmits(['filterChange']);

const applyFilters = debounce(() => {
    router.get(route('home'), {
        position_type: positionType.value,
        salary: salaryRange.value,
        company: companyFilter.value,
        location: locationFilter.value,
    }, {
        preserveState: true,
        replace: true,
    });
}, 300);

watch([positionType, salaryRange, companyFilter, locationFilter], applyFilters);
</script>

<template>
    <div class="bg-white p-6 rounded-lg shadow-md mb-6" x-data="{ open: false }">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Filters</h3>
            <button 
                @click="open = !open" 
                class="sm:hidden text-gray-500 hover:text-gray-700"
                aria-controls="filter-content"
                :aria-expanded="open"
            >
                <span x-text="open ? 'Hide Filters' : 'Show Filters'"></span>
            </button>
        </div>
        
        <div id="filter-content" :class="{ 'hidden sm:block': !open, 'block': open }">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div>
                    <label for="position_type" class="block text-sm font-medium text-gray-700 mb-1">Position Type</label>
                    <select
                        id="position_type"
                        v-model="positionType"
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                    >
                        <option value="">All Types</option>
                        <option value="remote">Remote</option>
                        <option value="in-person">In-Person</option>
                        <option value="hybrid">Hybrid</option>
                    </select>
                </div>
                
                <div>
                    <label for="salary" class="block text-sm font-medium text-gray-700 mb-1">Salary Range</label>
                    <select
                        id="salary"
                        v-model="salaryRange"
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                    >
                        <option value="">All Salaries</option>
                        <option value="0-50000">$0 - $50,000</option>
                        <option value="50000-100000">$50,000 - $100,000</option>
                        <option value="100000-150000">$100,000 - $150,000</option>
                        <option value="150000+">$150,000+</option>
                    </select>
                </div>
                
                <div>
                    <label for="company" class="block text-sm font-medium text-gray-700 mb-1">Company</label>
                    <input
                        id="company"
                        v-model="companyFilter"
                        type="text"
                        placeholder="Filter by company"
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                    />
                </div>
                
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                    <input
                        id="location"
                        v-model="locationFilter"
                        type="text"
                        placeholder="Filter by location"
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                    />
                </div>
            </div>
        </div>
    </div>
</template>