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
                                                Добавление
                                            </h1></div>
                                    </div>
                                </div>
                            </div>
                            <Fields ref="category"></Fields>

                            <button type="button" class="btn btn-block btn-primary"
                                    @click="create_record()">
                                Сохранить
                            </button>

                            <a :href="route('categories.index')" class="btn btn-block btn-link text-muted">
                                Отмена
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
    },

    name: 'my-component',

    data() {
        return {};
    },
    methods: {
        create_record: async function () {
            axios.post(route("categories.store"), this.$refs.category.$data.category)
                .then(
                    (response) => {
                        toast.fire({title: response.data.message})
                        this.$inertia.visit(route('categories.index'));
                    },
                    (error) => {
                        this.$swal('Ошибка', 'Введите корректные данные', 'error')
                    }
                )

        }
    }

};


</script>
