<template>
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        <Box v-for="listing in listings" :key="listing.id">
            <Link :href="route('listing.show', {listing: listing.id})">
                <Price :price="listing.price" class="text-2xl font-bold"/>
                <ListingSpace :listing="listing" class="text-lg" />
                <ListingAddress :listing="listing" class="text-gray-400"/>
            </Link>
            <div>
                <Link :href="route('listing.edit', {listing: listing.id})" as="button">Edit</Link>
            </div>
            <div>
                <Link :href="route('listing.destroy', {listing: listing.id})" method="delete" as="button">Delete</Link>
            </div>
        </Box>
    </div>

</template>

<script setup>
import {Link} from '@inertiajs/vue3'
import ListingAddress from "../../Component/ListingAddress.vue";
import Box from "../../Component/UI/Box.vue";
import ListingSpace from "../../Component/ListingSpace.vue";
import Price from "../../Component/Price.vue";
defineProps({
    listings: Array
});
</script>
