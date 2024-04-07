<script setup>
    import Box from "../../../Component/UI/Box.vue";
    import {useForm} from '@inertiajs/vue3'

    const props = defineProps({listing: Object});

    const form = useForm({
        images: []
    });

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
        <template #header>Upload images</template>
        <form @submit.prevent="upload">
            <input type="file" multiple @input="addFiles" />
            <button type="submit" class="btn-outline">Upload</button>
            <button type="reset" class="btn-outline" @click="reset">Reset</button>
        </form>
    </Box>
</template>
