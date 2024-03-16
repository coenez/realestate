<template>
    <div>Index</div>
        <Link href="/hello">Show page</Link>
    <div>message: {{message}}</div>
</template>

<script setup>
import {Link} from '@inertiajs/vue3'
defineProps({
    message: String
});
</script>
