<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm, Link } from '@inertiajs/vue3';

const props = defineProps({
    job: Object,
    companies: Array,
});

const form = useForm({
    company_id: props.job.company_id,
    title: props.job.title,
    description: props.job.description,
    position_type: props.job.position_type,
    location: props.job.location,
    salary_min: props.job.salary_min,
    salary_max: props.job.salary_max,
    salary_currency: props.job.salary_currency,
    is_published: props.job.is_published,
});

const submit = () => {
    form.put(route('admin.jobs.update', props.job.id), {
        preserveScroll: true,
    });
};
</script>

<template>
    <AppLayout title="Edit Job Posting">
        <template #header>
            <h2 class="text-xl font-semibold text-gray-800">Edit Job: {{ job.title }}</h2>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <form @submit.prevent="submit" class="space-y-6">
                        <div class="grid grid-cols-1 gap-6">
                            <!-- Company -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Company</label>
                                <select v-model="form.company_id" class="mt-1 block w-full rounded-md border-gray-300">
                                    <option v-for="company in companies" :key="company.id" :value="company.id">
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
                                <textarea v-model="form.description" rows="5" class="mt-1 block w-full rounded-md border-gray-300"></textarea>
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
                                <label class="block text-sm font-medium text-gray-700">Location</label>
                                <input v-model="form.location" type="text" class="mt-1 block w-full rounded-md border-gray-300">
                                <p v-if="form.errors.location" class="mt-2 text-sm text-red-600">{{ form.errors.location }}</p>
                            </div>

                            <!-- Salary -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Currency</label>
                                    <select v-model="form.salary_currency" class="mt-1 block w-full rounded-md border-gray-300">
                                        <option value="USD">USD</option>
                                        <option value="EUR">EUR</option>
                                        <option value="GBP">GBP</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Published Status -->
                            <div>
                                <label class="flex items-center">
                                    <input v-model="form.is_published" type="checkbox" class="rounded border-gray-300 text-indigo-600">
                                    <span class="ml-2 text-sm text-gray-600">Published</span>
                                </label>
                            </div>

                            <div class="flex justify-end space-x-4">
                                <Link :href="route('admin.jobs.index')" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md">Cancel</Link>
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md" :disabled="form.processing">Update Job</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>