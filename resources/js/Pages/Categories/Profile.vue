<template>
    <dashboard-layout>


        <div class="main-content">
            <div class="card">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-12 col-lg-10 col-xl-8">
                            <div class="header mt-md-5">
                                <div class="header-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="header-pretitle">
                                                Категория
                                            </h6>
                                            <h1 class="header-title">
                                                Просмотр
                                            </h1>
                                        </div>
                                        <div v-if="$userPermissions.includes('categories-update')==true"
                                             class="col-auto"><a
                                            :href="route('categories.edit', category.id)"
                                            class="btn btn-primary lift">
                                            Редактировать
                                        </a></div>
                                    </div>
                                </div>
                            </div>

                            <Fields ref="category" page="profile"></Fields>

                            <a :href="route('categories.index')" class="btn btn-block btn-link text-muted">
                                Назад
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </dashboard-layout>
</template>

<script>
import DashboardLayout from './../../Layouts/DashboardLayout'
import axios from "axios";
import Fields from './../../Pages/Categories/Fields'

export default {

    components: {
        DashboardLayout,
        Fields
    },

    props: {
        category: Object,
    },

    name: 'my-component',

    data() {
        return {};
    },
    mounted() {
        this.$refs.category.$data.category = this.category
    },
    methods: {
    }

};


</script>
