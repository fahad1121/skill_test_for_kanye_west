<template>
    <Header />
    <div class="container">
        <div class="row">
            <h4 class="text-center mb-3">Kanye Random 5 Quotes</h4>
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div v-if="$page.props.flash.success" class="alert alert-success">
                    {{ $page.props.flash.success }}
                </div>
                <div v-if="$page.props.flash.error" class="alert alert-danger">
                    {{ $page.props.flash.error }}
                </div>
                <InertiaLink :href="route('refreshQuote')" class="text-decoration-none float-end font-monospace mb-2 btn btn-outline-primary"> Refresh</InertiaLink>
                <ol class="list-group w-100" v-for="quote in quotes" :key="quote.id">
                    <li class="list-group-item">{{ quote }} <InertiaLink :href="route('saveToFavourite',{stringParam:quote})" class="btn btn-outline-primary">
                        Mark as Favourite</InertiaLink> </li>
                </ol>
            </div>
        </div>
    </div>
</template>

<script>
import Header from "../../Components/Header.vue";
import { InertiaLink } from '@inertiajs/inertia-vue3';
export default {
    components: {
        Header,
        InertiaLink
    },
    props: {
        quotes: Array
    },
};
</script>
