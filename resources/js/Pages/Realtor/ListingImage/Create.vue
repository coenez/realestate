<script setup>
    import Box from "../../../Component/UI/Box.vue";
    import {useForm} from '@inertiajs/vue3'
    import {computed} from "vue";
    import {Link} from "@inertiajs/vue3";
    import ListingAddress from "../../../Component/ListingAddress.vue";

    const props = defineProps({listing: Object});

    const form = useForm({
        images: []
    });

    const uploadAvailable = computed(() => form.images.length);

    const reset = () => form.reset('images');

    const upload = () => {
        form.post(
            route('realtor.listing.image.store', {listing: props.listing.id}),
            {
                onSuccess: reset
            }
        );
    }

    const addFiles = (event) => {
        for (const image of event.target.files) {
            form.images.push(image);
        }
    }

</script>

<template>
    <Box>
        <template #header>Upload images for: <ListingAddress :listing="listing" class="italic" /></template>
        <form @submit.prevent="upload">
            <section class="flex items-center gap-2 my-4">
                <input type="file" multiple @input="addFiles" name="images" class="border rounded-md border-gray-200 file:hover:cursor-pointer file:hover:bg-gray-200 file:px-4 file:py-2 file:text-gray-500 file:border-0 file:font-medium"/>
                <button :disabled="!uploadAvailable" type="submit" class="btn-outline disabled:opacity-25 disabled:cursor-not-allowed">Upload</button>
                <button type="reset" class="btn-outline" @click="reset">Reset</button>
            </section>
        </form>
    </Box>
    <Box v-if="listing.images.length" class="mt-4">
        <template #header>Current images</template>
        <section class="mt-4 grid grid-cols-3 gap-4">
            <div class="flex flex-col justify-between" v-for="image in listing.images" :key="image.id">
                <img :alt="image.filename" :src="image.src" class="rounded-md"/>
                <Link method="delete" as="button" :href="route('realtor.listing.image.destroy', {listing: listing.id, image: image.id})" class="mt-2 btn-outline text-xs">Delete</Link>
            </div>
        </section>

    </Box>
</template>
