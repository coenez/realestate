<script setup>
    import Box from "../../../Component/UI/Box.vue";
    import {useForm} from '@inertiajs/vue3'
    import {computed} from "vue";

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
        <template #header>Upload images</template>
        <form @submit.prevent="upload">
            <section class="flex items-center gap-2 my-4">
                <input type="file" multiple @input="addFiles" name="images" class="border rounded-md border-gray-200 file:hover:cursor-pointer file:hover:bg-gray-200 file:px-4 file:py-2 file:text-gray-500 file:border-0 file:font-medium"/>
                <button :disabled="!uploadAvailable" type="submit" class="btn-outline disabled:opacity-25 disabled:cursor-not-allowed">Upload</button>
                <button type="reset" class="btn-outline" @click="reset">Reset</button>
            </section>
        </form>
    </Box>
</template>
