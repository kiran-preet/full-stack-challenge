<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link,router } from '@inertiajs/vue3';

defineProps({
    jobs: Object
});
defineOptions({
    title: 'Admin - Jobs'
});
const deleteJob = (jobId) => {
    if (confirm('Are you sure you want to delete this job posting? This action cannot be undone.')) {
        router.delete(route('admin.jobs.destroy', jobId), {
            preserveScroll: true,
            onSuccess: () => {
                // Optional: Show success message
            },
        });
    }
};
</script>

<template>
    <AppLayout title="Jobs">
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Jobs</h2>
                <Link :href="route('admin.jobs.create')" 
                      class="px-4 py-2 bg-green-600 text-white rounded-md">
                    Add Job
                </Link>
            </div>
        </template>

        <div class="py-6">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Company</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Salary</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="job in jobs.data" :key="job.id">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <Link :href="route('admin.jobs.show', job.id)" 
                                      class="text-indigo-600 hover:text-indigo-900">
                                    {{ job.title }}
                                </Link>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ job.company?.name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ job.position_type }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                ${{ job.salary_min?.toLocaleString() }} - ${{ job.salary_max?.toLocaleString() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <Link :href="route('admin.jobs.edit', job.id)" 
                                      class="text-indigo-600 hover:text-indigo-900 mr-3">
                                    Edit
                                </Link>
                                <button @click="deleteJob(job.id)" 
                                        class="text-red-600 hover:text-red-900">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div v-if="jobs.links && jobs.links.length > 1" class="mt-6 flex justify-center">
                <nav class="inline-flex -space-x-px">
                    <Link v-for="link in jobs.links" :key="link.label" :href="link.url || ''" :class="[
                        'px-3 py-2 border text-sm',
                        link.active ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-700 border-gray-300',
                        !link.url ? 'pointer-events-none opacity-50' : 'hover:bg-gray-100'
                    ]" v-html="link.label" />
                </nav>
            </div>
        </div>
    </AppLayout>
</template>