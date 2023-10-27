<template>
    <Header />
    <div class="container">
        <div class="row">
            <h4 class="text-center mb-3">Favourites</h4>
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div v-if="$page.props.flash.success" class="alert alert-success">
                    {{ $page.props.flash.success }}
                </div>
                <div v-if="$page.props.flash.error" class="alert alert-danger">
                    {{ $page.props.flash.error }}
                </div>
                <ol class="list-group w-100" v-for="favourite in favourites" :key="favourite.id">
                    <li class="list-group-item">{{ favourite.quote }} <button @click="deleteFavourite(favourite.id)" class="btn btn-outline-primary">
                        Delete</button> </li>
                </ol>
            </div>
        </div>
    </div>
</template>

<script>
import Header from "../../Components/Header.vue";
import {InertiaLink, useForm} from '@inertiajs/inertia-vue3';

export default {
    components: {
        Header,
        InertiaLink
    },
    props: {
        favourites: Array
    },

    setup(){
        const form = useForm();
        const deleteFavourite = (id) => {

            form.delete(`delete/favourite/${id}`);

        }

        return {
            deleteFavourite
        }
    }
};
</script>
