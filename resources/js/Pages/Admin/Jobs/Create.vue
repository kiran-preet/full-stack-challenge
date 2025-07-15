<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    companies: Array,
    company: Object
});

const form = useForm({
    company_id: props.company?.id || '',
    title: '',
    description: '',
    position_type: 'remote',
    location: '',
    salary_min: '',
    salary_max: '',
    salary_currency: 'USD',
    is_published: true
});

const submit = () => {
    form.post(route('admin.jobs.store'));
};
</script>

<template>
    <AppLayout title="Create Job Posting">
        <template #header>
            <h2 class="text-xl font-semibold text-gray-800">
                {{ company ? `Post Job for ${company.name}` : 'Create Job Posting' }}
            </h2>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <form @submit.prevent="submit">
                        <div class="grid grid-cols-1 gap-6">
                            <!-- Company (only show if not creating for specific company) -->
                            <div v-if="!company">
                                <label class="block text-sm font-medium text-gray-700">Company</label>
                                <select v-model="form.company_id" class="mt-1 block w-full rounded-md border-gray-300">
                                    <option value="">Select a company</option>
                                    <option v-for="company in companies" :value="company.id" :key="company.id">
                                        {{ company.name }}
                                    </option>
                                </select>
                                <p v-if="form.errors.company_id" class="mt-2 text-sm text-red-600">{{ form.errors.company_id }}</p>
                            </div>

                            <!-- Title -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Job Title</label>
                                <input v-model="form.title" type="text" class="mt-1 block w-full rounded-md border-gray-300">
                                <p v-if="form.errors.title" class="mt-2 text-sm text-red-600">{{ form.errors.title }}</p>
                            </div>

                            <!-- Description -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea v-model="form.description" rows="4" class="mt-1 block w-full rounded-md border-gray-300"></textarea>
                                <p v-if="form.errors.description" class="mt-2 text-sm text-red-600">{{ form.errors.description }}</p>
                            </div>

                            <!-- Position Type -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Position Type</label>
                                <select v-model="form.position_type" class="mt-1 block w-full rounded-md border-gray-300">
                                    <option value="remote">Remote</option>
                                    <option value="hybrid">Hybrid</option>
                                    <option value="in-person">In-Person</option>
                                </select>
                                <p v-if="form.errors.position_type" class="mt-2 text-sm text-red-600">{{ form.errors.position_type }}</p>
                            </div>

                            <!-- Location -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Location (if not remote)</label>
                                <input v-model="form.location" type="text" class="mt-1 block w-full rounded-md border-gray-300">
                                <p v-if="form.errors.location" class="mt-2 text-sm text-red-600">{{ form.errors.location }}</p>
                            </div>

                            <!-- Salary -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Minimum Salary</label>
                                    <input v-model="form.salary_min" type="number" class="mt-1 block w-full rounded-md border-gray-300">
                                    <p v-if="form.errors.salary_min" class="mt-2 text-sm text-red-600">{{ form.errors.salary_min }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Maximum Salary</label>
                                    <input v-model="form.salary_max" type="number" class="mt-1 block w-full rounded-md border-gray-300">
                                    <p v-if="form.errors.salary_max" class="mt-2 text-sm text-red-600">{{ form.errors.salary_max }}</p>
                                </div>
                            </div>

                            <!-- Published -->
                            <div>
                                <label class="flex items-center">
                                    <input v-model="form.is_published" type="checkbox" class="rounded border-gray-300 text-indigo-600">
                                    <span class="ml-2 text-sm text-gray-600">Publish immediately</span>
                                </label>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" 
                                        class="px-4 py-2 bg-indigo-600 text-white rounded-md"
                                        :disabled="form.processing">
                                    Post Job
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>