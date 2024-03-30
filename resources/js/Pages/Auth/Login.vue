<script setup>
import {useForm} from '@inertiajs/vue3'

const form = useForm({
    email: null,
    password: null
});

const login = () => form.post(route('login.store'));
</script>

<template>
    <form @submit.prevent="login">
        <div class="w-1/2 mx-auto">
            <div>
                <label for="email" class="label">E-mail</label>
                <input id="email" class="inputField" type="text" v-model="form.email"/>
                <div class="inputError" v-if="form.errors.email">{{form.errors.email}}</div>
            </div>
            <div class="mt-4">
                <label for="password" class="label">Password</label>
                <input id="password" class="inputField" type="password" v-model="form.password"/>
                <div class="inputError" v-if="form.errors.password">{{form.errors.password}}</div>
            </div>
            <div class="mt-4">
                <button class="button w-full" type="submit">Login</button>
            </div>
        </div>
    </form>
</template>
