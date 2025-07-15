<script setup lang="ts">
import { Link, Head } from '@inertiajs/vue3';
import { route } from 'ziggy-js'; // Explicit import
import { ref, computed } from 'vue';

const showingNavigationDropdown = ref(false);
const props = defineProps({
    title: String
});
</script>

<template>
    <div>
        <Head>
            <title>{{ title || 'Job Board' }}</title>
        </Head>
        <nav class="bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="shrink-0 flex items-center">
                            <Link :href="route('home')">
                                <span class="text-xl font-bold text-indigo-600">JobBoard</span>
                            </Link>
                        </div>
                    </div>

                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <div class="ml-3 relative">
                            <div class="flex space-x-4">
                                <Link
                                    :href="route('home')"
                                    class="text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium"
                                    :class="{ 'text-indigo-600': $page.url === '/' }"
                                >
                                    Browse Jobs
                                </Link>
                                <Link
                                    v-if="$page.props?.auth?.user"
                                    :href="route('admin.companies.index')"
                                    class="text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium"
                                    :class="{ 'text-indigo-600': $page.url.startsWith('/companies') }"
                                >
                                    Companies
                                </Link>
                                <Link
                                    v-if="$page.props?.auth?.user"
                                    :href="route('admin.jobs.index')"
                                    class="text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium"
                                    :class="{ 'text-indigo-600': $page.url.startsWith('/jobs') }"
                                >
                                    Jobs
                                </Link>
                                <Link
                                    v-if="$page.props?.auth?.user"
                                    :href="route('logout')"
                                    method="post"
                                    as="button"
                                    class="text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium"
                                >
                                    Logout
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <slot />
        </main>
    </div>
</template>