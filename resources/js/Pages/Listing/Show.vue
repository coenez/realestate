<template>
    <ListingAddress :listing="listing"/>
</template>

<script setup>
import ListingAddress from "../../Component/ListingAddress.vue";

defineProps({
    listing: Object
});
</script>
