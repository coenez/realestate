<template>
    <div v-for="listing in listings" :key="listing.id">
        <Link :href="`listing/${listing.id}`">
            <div><ListingAddress :listing="listing"/></div>
        </Link>
    </div>
</template>

<script setup>
import {Link} from '@inertiajs/vue3'
import ListingAddress from "../../Component/ListingAddress.vue";
defineProps({
    listings: Array
});
</script>
