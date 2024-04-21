<script setup>
import {Link} from "@inertiajs/vue3";
</script>

<template>
    <div>You need to be verified first to see this page.</div>
    <div>
        <Link :href="route('verification.send')" method="post" class="text-indigo-600">Resend my verification e-mail please</Link>
    </div>
</template>


