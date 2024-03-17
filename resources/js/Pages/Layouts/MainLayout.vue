<template>
    <Link href="/">Main page</Link>&nbsp;
    <Link href="/hello">Show page</Link>&nbsp;
    <div v-if="flashSuccess" class="success">
        {{flashSuccess}}
    </div>
    <slot></slot>
</template>

<script setup>

import {Link, usePage} from '@inertiajs/vue3'
import {computed} from 'vue'

console.log(usePage().props.flash);

const flashSuccess = computed(() => usePage().props.flash?.success)
</script>

<style scoped>
.success {
    background-color: green;
    color: white;
}
</style>
