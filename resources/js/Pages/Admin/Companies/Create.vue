<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({
    name: '',
    email: '',
    logo: null,
    website: ''
});

const logoError = ref('');

function validateLogo(event) {
    logoError.value = '';
    const file = event.target.files[0];
    if (!file) {
        form.logo = null;
        return;
    }
    const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'];
    if (!validTypes.includes(file.type)) {
        logoError.value = 'Please upload a valid image file (jpg, png, gif, webp, svg).';
        form.logo = null;
        return;
    }
    form.logo = file;
}

const submit = () => {
    if (logoError.value) return;
    form.post(route('admin.companies.store'));
};
</script>

<template>
    <AppLayout title="Create Company">
        <template #header>
            <h2 class="text-xl font-semibold text-gray-800">Create Company</h2>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <form @submit.prevent="submit">
                        <div class="grid grid-cols-1 gap-6">
                            <!-- Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Company Name</label>
                                <input v-model="form.name" type="text" class="mt-1 block w-full rounded-md border-gray-300">
                                <p v-if="form.errors.name" class="mt-2 text-sm text-red-600">{{ form.errors.name }}</p>
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <input v-model="form.email" type="email" class="mt-1 block w-full rounded-md border-gray-300">
                                <p v-if="form.errors.email" class="mt-2 text-sm text-red-600">{{ form.errors.email }}</p>
                            </div>

                            <!-- Logo -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Logo</label>
                                <input type="file" accept="image/*" @change="validateLogo($event)" class="mt-1 block w-full">
                                <p v-if="form.errors.logo" class="mt-2 text-sm text-red-600">{{ form.errors.logo }}</p>
                                <p v-if="logoError" class="mt-2 text-sm text-red-600">{{ logoError }}</p>
                            </div>

                            <!-- Website -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Website</label>
                                <input v-model="form.website" type="url" class="mt-1 block w-full rounded-md border-gray-300">
                                <p v-if="form.errors.website" class="mt-2 text-sm text-red-600">{{ form.errors.website }}</p>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" 
                                        class="px-4 py-2 bg-indigo-600 text-white rounded-md"
                                        :disabled="form.processing">
                                    Create Company
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>