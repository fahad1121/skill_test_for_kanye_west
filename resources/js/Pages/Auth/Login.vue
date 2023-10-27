<template>
    <div class="container">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">

                <h1 class="mt-5">Login</h1>
                <div v-if="$page.props.flash.success" class="alert alert-success">
                    {{ $page.props.flash.success }}
                </div>
                <form @submit.prevent="login" class="mt-3">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" v-model="form.email" class="form-control">
                        <span style="color:red">{{ $page.props.errors.email }}</span>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" v-model="form.password" class="form-control">
                        <span style="color:red">{{ $page.props.errors.password }}</span>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                    <InertiaLink :href="route('register')" class="btn btn-link">Create an account</InertiaLink>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { onMounted, ref } from 'vue';
import {useForm} from '@inertiajs/inertia-vue3';
import { InertiaLink } from '@inertiajs/inertia-vue3';

export default {
    components: {
        InertiaLink
    },
    setup() {
        const form = useForm({
            email: '',
            password: '',
        });

        const flashMessage = ref('');

        onMounted(() => {
            if (localStorage.getItem('success')) {
                flashMessage.value = localStorage.getItem('success');
                localStorage.removeItem('success');
            }
        });

        const login = () => {
            form.post('/login', {
                preserveState: true,
                onSuccess: function (response) {
                    if(response.props.token){
                        localStorage.setItem('token',response.props.token);
                        window.location = '/dashboard';
                    }

                },
                onError: function (error){
                    console.log(error);
                }
            });
        };

        return {
            form,
            login,
            flashMessage
        };
    },
};
</script>

