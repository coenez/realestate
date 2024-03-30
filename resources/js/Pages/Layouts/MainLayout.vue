<script setup>

import {Link, usePage} from '@inertiajs/vue3'
import {computed} from 'vue'

const flashSuccess = computed(() => usePage().props.flash?.success)
const user = computed(() => usePage().props.user);

</script>

<template>
    <header class="border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 w-full">
        <div class="container mx-auto">
            <nav class="p-4 flex items-center justify-between">
                <div class="text-lg font-medium">
                    <Link :href="route('listing.index')">Listings</Link>&nbsp;
                </div>
                <div class="text-xl text-indigo-600 dark:text-indigo-300 font-bold text-center">
                    <Link :href="route('listing.index')">Real estate course</Link>&nbsp;
                </div>

                <div class="flex items-center gap-4" v-if="user">
                    <div class="text-sm text-gray-500">{{user.name}}</div>
                    <Link :href="route('listing.create')" class="button">+ New Listing</Link>&nbsp;
                    <div>
                        <Link :href="route('logout')" method="delete" as="button" class="button">Logout</Link>&nbsp;
                    </div>
                </div>
                <div v-else class="flex items-center gap-2">
                    <Link :href="route('user-account.create')" class="button">Register</Link>&nbsp;
                    <Link :href="route('login')" class="button">Sign-in</Link>&nbsp;
                </div>
            </nav>
        </div>
    </header>
    <main class="container mx-auto p-4 w-full">
        <div v-if="flashSuccess" class="mb-4 border rounded-md shadow-sm border-green-300 dark:border-green-800 bg-green-100 dark:bg-green-900 p2">
            {{ flashSuccess }}
        </div>
        <slot></slot>
    </main>

</template>


