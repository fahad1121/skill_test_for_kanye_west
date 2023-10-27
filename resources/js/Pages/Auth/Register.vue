<template>
    <div class="container">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <h1 class="mt-5">Register</h1>
                <form @submit.prevent="submitForm" class="mt-3">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" id="name" v-model="formData.name" class="form-control">
                        <span style="color:red">{{ $page.props.errors.name }}</span>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" v-model="formData.email" class="form-control" >

                        <span style="color:red">{{ $page.props.errors.email }}</span>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" v-model="formData.password" class="form-control">
                        <span style="color:red">{{ $page.props.errors.password }}</span>
                    </div>
                    <button type="submit" class="btn btn-primary">Register</button>
                    <InertiaLink :href="route('login')" class="btn btn-link">Already have a account?</InertiaLink>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import {InertiaLink} from "@inertiajs/inertia-vue3";

export default {
    components: {
        InertiaLink
    },
    props: {
        message: String,
        user: Object,
        name: String,
        email: String,
        password: String,
    },
    data() {
        return {
            formData: {
                name: '',
                email: '',
                password: ''
            },
        };
    },
    methods: {
        submitForm() {
            this.$inertia.post('/register', this.formData);
        },
    },
};
</script>
