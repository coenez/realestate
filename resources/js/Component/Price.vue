<script setup>
import {computed} from 'vue'

const props = defineProps({
    price: [Number, String]
});

const formattedPrice = computed(
    () => Number(props.price).toLocaleString('nl-NL', {
        style: 'currency',
        currency: 'EUR',
        maximumFractionDigits: 0
    })
);
</script>

<template>
    <span>{{formattedPrice}}</span>
</template>


