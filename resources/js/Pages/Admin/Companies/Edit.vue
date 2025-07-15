<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    company: Object,
});

const form = useForm({
    name: props.company.name,
    email: props.company.email,
    logo: null,
    website: props.company.website,
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
    form.transform(data => ({
        ...data,
        // Preserve the logo only if it's a file object
        logo: data.logo instanceof File ? data.logo : undefined
    })).post(route('admin.companies.update', props.company.id), {
        preserveScroll: true,
        preserveState: true,
        forceFormData: true,
        onSuccess: () => form.reset('logo'),
        onError: (errors) => {
            console.log('Form errors:', errors);
        }
    });
};
</script>

<template>
    <AppLayout title="Edit Company">
        <template #header>
            <h2 class="text-xl font-semibold text-gray-800">Edit Company: {{ company.name }}</h2>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <form @submit.prevent="submit" class="space-y-6" enctype="multipart/form-data">
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
                                <div class="mt-1 flex items-center">
                                    <img v-if="company.logo" :src="`/storage/${company.logo}`" class="h-12 w-12 rounded-full mr-4">
                                    <input type="file" accept="image/*" @change="validateLogo($event)" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                </div>
                                <p v-if="form.errors.logo" class="mt-2 text-sm text-red-600">{{ form.errors.logo }}</p>
                                <p v-if="logoError" class="mt-2 text-sm text-red-600">{{ logoError }}</p>
                            </div>

                            <!-- Website -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Website</label>
                                <input v-model="form.website" type="url" class="mt-1 block w-full rounded-md border-gray-300">
                                <p v-if="form.errors.website" class="mt-2 text-sm text-red-600">{{ form.errors.website }}</p>
                            </div>

                            <div class="flex justify-end space-x-4">
                                <Link :href="route('admin.companies.index')" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md">Cancel</Link>
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md" :disabled="form.processing">Save Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>