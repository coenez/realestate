<script setup>
import ListingSpace from "../../Component/ListingSpace.vue";
import Price from "../../Component/Price.vue";
import ListingAddress from "../../Component/ListingAddress.vue";
import Box from "../../Component/UI/Box.vue";
import {computed, ref} from 'vue';
import {useMonthlyPayment} from "../../Composables/useMonthlyPayment.js";
import MakeOffer from "./Show/Components/MakeOffer.vue";
import {usePage} from "@inertiajs/vue3";
import OfferMade from "./Show/Components/OfferMade.vue";

const interestRate = ref(2.5);
const duration = ref(25);

const props = defineProps({
    listing: Object,
    offerMade: Object
});

const user = computed(() => usePage().props.user);
const offer = ref(props.listing.price);
const { monthlyPayment, totalPaid, totalInterest } = useMonthlyPayment(offer, interestRate, duration);

</script>

<template>
    <div class="flex flex-col-reverse md:grid md:grid-cols-12 gap-4">
        <Box class="md:col-span-7 flex items-center w-full">
            <div v-if="listing.images.length" class="grid grid-cols-2 gap-1">
                <img v-for="image in listing.images" :key="image.id" :src="image.src" />
            </div>
            <div v-else class="w-full text-center font-medium text-gray-500">No images</div>
        </Box>
        <div class="md:col-span-5 flex flex-col gap-4">
            <Box>
                <template #header>Basic info</template>
                <Price :price="listing.price" class="text-2xl font-bold"/>
                <ListingSpace :listing="listing" class="text-lg" />
                <ListingAddress :listing="listing" class="text-gray-400"/>
            </Box>
            <Box>
                <template #header>Monthly Payment</template>
                <div>
                    <label class="label">Interest rate ({{ interestRate }}%)</label>
                    <input v-model.number="interestRate" type="range" min="0.1" max="30" step="0.1" class="slider" />

                    <label class="label">Duration ({{ duration }} years)</label>
                    <input v-model.number="duration" type="range" min="3" max="35" step="1" class="slider" />

                    <div class="text-gray-600 dark:text-gray-300 mt-2">
                        <div class="text-gray-400">Your monthly payment</div>
                        <Price :price="monthlyPayment" class="text-3xl" />
                    </div>
                    <div class="mt-2 text-gray-500">
                        <div class="flex justify-between">
                            <div>Total paid</div>
                            <div>
                                <Price class="font-medium" :price="totalPaid"/>
                            </div>
                        </div>
                        <div class="flex justify-between">
                            <div>Principal paid</div>
                            <div>
                                <Price class="font-medium" :price="listing.price"/>
                            </div>
                        </div>
                        <div class="flex justify-between">
                            <div>interest paid</div>
                            <div>
                                <Price class="font-medium" :price="totalInterest"/>
                            </div>
                        </div>
                    </div>
                </div>
            </Box>
            <MakeOffer v-if="user && !offerMade" @offer-updated="offer = $event" :listing-id="listing.id" :price="listing.price"/>
            <OfferMade v-if="user && offerMade" :offer="offerMade" />
        </div>
    </div>
</template>
