<script setup>

import ListingSpace from "../../../../Component/ListingSpace.vue";
import Price from "../../../../Component/Price.vue";
import Box from "../../../../Component/UI/Box.vue";
import ListingAddress from "../../../../Component/ListingAddress.vue";
import {Link} from "@inertiajs/vue3";
import {useMonthlyPayment} from "../../../../Composables/useMonthlyPayment.js";

const props = defineProps({
    listing: Object
});

const { monthlyPayment } = useMonthlyPayment(props.listing.price, 2.5, 25);
</script>

<template>
    <Box>
        <Link :href="route('listing.show', {listing: listing.id})">
            <div class="flex items-center gap-1">
                <Price :price="listing.price" class="text-2xl font-bold"/>
                <div class="text-xs text-gray-500">
                    <Price :price="monthlyPayment" /> pm
                </div>
            </div>

            <ListingSpace :listing="listing" class="text-lg" />
            <ListingAddress :listing="listing" class="text-gray-400"/>
        </Link>
    </Box>
</template>
