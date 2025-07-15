<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';

defineProps({
    companies: Object
});

const deleteCompany = (jobId) => {
    if (confirm('Are you sure you want to delete this job posting? This action cannot be undone.')) {
        router.delete(route('admin.companies.destroy', jobId), {
            preserveScroll: true,
            onSuccess: () => {
                // Optional: Show success message
            },
        });
    }
};

</script>

<template>
    <AppLayout title="Companies">
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Companies</h2>
                <Link :href="route('admin.companies.create')" 
                      class="px-4 py-2 bg-indigo-600 text-white rounded-md">
                    Add Company
                </Link>
            </div>
        </template>

        <div v-if="$page.props.flash?.success" class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            {{ $page.props.flash.success }}
        </div>

        <div class="py-6">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jobs</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="company in companies.data" :key="company.id">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <Link :href="route('admin.companies.show', company.id)" 
                                      class="text-indigo-600 hover:text-indigo-900">
                                    {{ company.name }}
                                </Link>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ company.jobs_count }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <Link :href="route('admin.companies.edit', company.id)" 
                                      class="text-indigo-600 hover:text-indigo-900 mr-3">
                                    Edit
                                </Link>
                                <button @click="deleteCompany(company.id)" 
                                        class="text-red-600 hover:text-red-900">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div v-if="companies.links && companies.links.length > 1" class="mt-6 flex justify-center">
                <nav class="inline-flex -space-x-px">
                    <Link v-for="link in companies.links" :key="link.label" :href="link.url || ''" :class="[
                        'px-3 py-2 border text-sm',
                        link.active ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-700 border-gray-300',
                        !link.url ? 'pointer-events-none opacity-50' : 'hover:bg-gray-100'
                    ]" v-html="link.label" />
                </nav>
            </div>
        </div>
    </AppLayout>
</template>