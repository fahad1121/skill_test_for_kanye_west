<template>
    <div class="container">
        <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
            <div class="col-md-3 mb-2 mb-md-0">
                <a href="/" class="d-inline-flex link-body-emphasis text-decoration-none">
                    Kanye Quotes
                </a>
            </div>

            <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
                <li><InertiaLink :href="route('dashboard')" class="nav-link px-2 link-secondary">Home</InertiaLink></li>
                <li><InertiaLink :href="route('favourites')" class="nav-link px-2">Favourites</InertiaLink></li>
            </ul>

            <div class="col-md-3 text-end">
                <button type="button" @click="logout()" class="btn btn-outline-primary me-2">Logout</button>
            </div>
        </header>
    </div>
</template>

<script>
import { InertiaLink } from '@inertiajs/inertia-vue3';
import { useForm} from "@inertiajs/inertia-vue3";

export default {

    components: {
        InertiaLink
    },

    setup(){

        const form = useForm();

        const logout = () => {
            localStorage.clear();
            form.post('/logout',{})
        }

        return {
            logout,
            form
        }
    }

}
</script>
