<template>
    <Link href="/">Main page</Link>&nbsp;
    <Link href="/hello">Show page</Link>&nbsp;
    <div>time: {{timer}}</div>
        <slot></slot>
</template>

<script setup>
import {Link} from '@inertiajs/vue3'
import {ref} from 'vue'
const timer = ref(0);
setInterval(() => timer.value++, 1000)
</script>
