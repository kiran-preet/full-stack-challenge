<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
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
                                    :href="route('companies.index')"
                                    class="text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium"
                                    :class="{ 'text-indigo-600': $page.url.startsWith('/companies') }"
                                >
                                    Companies
                                </Link>
                                <Link
                                    v-if="$page.props?.auth?.user"
                                    :href="route('jobs.index')"
                                    class="text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium"
                                    :class="{ 'text-indigo-600': $page.url.startsWith('/jobs') }"
                                >
                                    Jobs
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <main>
            <slot />
        </main>
    </div>
</template>