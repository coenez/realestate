<script setup>
import Box from "../../Component/UI/Box.vue";
import Price from "../../Component/Price.vue";
import ListingSpace from "../../Component/ListingSpace.vue";
import ListingAddress from "../../Component/ListingAddress.vue";
import {Link} from "@inertiajs/vue3";
import RealtorFilters from "./Index/Components/RealtorFilters.vue";
import Pagination from "../../Component/UI/Pagination.vue";
import EmptyState from "../../Component/UI/EmptyState.vue";

defineProps({
    listings: Object,
    filters: Object,
    sorter: Object
});
</script>

<template>
    <h1 class="text-3xl mb-4">Your listings</h1>
    <section>
        <RealtorFilters :filters="filters" :sorter="sorter"/>
    </section>
    <section v-if="listings.data.length" class="grid grid-cols-1 lg: grid-cols-2 gap-2">
        <Box v-for="listing in listings.data" :key="listing.id" :class="{'border-dashed': listing.deleted_at}">
            <div class="flex flex-col md:flex-row gap-2 md:items-center justify-between">
                <div :class="{'opacity-25': listing.deleted_at}">
                    <div v-if="listing.sold_at" class="soldMarker">sold</div>
                    <div class="xl:flex items-center gap-2">
                        <Price :price="listing.price" class="text-2xl font-medium"/>
                        <ListingSpace :listing="listing" />
                    </div>
                    <ListingAddress :listing="listing" class="text-gray-500" />
                </div>
                <section>
                    <div class="flex items-center gap-1 text-gray-600 dark:text-gray-300">
                        <a :href="route('listing.show', {listing: listing.id})" target="_blank" class="btn-outline text-xs font-medium">Preview</a>
                        <Link v-if="!listing.sold_at" :href="route('realtor.listing.edit', {listing: listing.id})" class="btn-outline text-xs font-medium">Edit</Link>

                        <Link v-if="!listing.deleted_at" :href="route('realtor.listing.destroy', {listing: listing.id})" as="button" method="delete" class="btn-outline text-xs font-medium">Delete</Link>
                        <Link v-else :href="route('realtor.listing.restore', {listing: listing.id})" as="button" method="put" class="btn-outline text-xs font-medium">Restore</Link>
                    </div>
                    <div class="mt-2">
                        <Link v-if="!listing.deleted_at && !listing.sold_at" :href="route('realtor.listing.image.create', {listing: listing.id})" class="block w-full btn-outline text-xs font-medium text-center">Images ({{listing.images_count}})</Link>
                        <Link :href="route('realtor.listing.show', {listing: listing.id})" class="mt-2 block w-full btn-outline text-xs font-medium text-center">Offers ({{listing.offers_count}})</Link>
                    </div>
                </section>
            </div>
        </Box>
    </section>
    <EmptyState v-else>No listings yet</EmptyState>
    <section v-if="listings.data.length" class="w-full flex justify-center mt-4 mb-4">
        <Pagination :links="listings.links" />
    </section>
</template>
