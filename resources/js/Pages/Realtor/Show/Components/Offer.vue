<script setup>
    import Box from "../../../../Component/UI/Box.vue";
    import Price from "../../../../Component/Price.vue";
    import {computed} from "vue";
    import {Link} from "@inertiajs/vue3";

    const props = defineProps({
        offer: Object,
        price: Number
    });

    const difference = computed(() => props.offer.amount - props.price);

    const madeOn = computed(() => new Date(props.offer.created_at).toDateString());

    const sold = computed(() => !props.offer.accepted_at && !props.offer.rejected_at);
</script>

<template>
    <Box>
        <template #header>
            Offer #{{ offer.id }}
            <span v-if="offer.accepted_at" class="dark:bg-green-900 dark:text-green-200 bg-green-200 text-green-900 p-1 rounded-md uppercase ml-1">accepted</span>
        </template>
        <section class="flex items-center justify-between">
            <div>
                <Price :price="offer.amount" class="text-xl" />
                <div class="text-gray-500">Difference <Price :price="difference" /></div>
                <div class="text-gray-500 text-sm">Made by {{offer.user.name}}</div>
                <div class="text-gray-500 text-sm">Made on {{ madeOn }}</div>
            </div>
            <div>
                <Link v-if="sold" :href="route('realtor.offer.accept', {offer: offer.id})" method="put" class="btn-outline text-xs font-medium" as="button">Accept</Link>
            </div>
        </section>
    </Box>
</template>
