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
                                                Новость
                                            </h6>
                                            <h1 class="header-title">
                                                Редактирование
                                            </h1></div>
                                    </div>
                                </div>
                            </div>

                            <Fields ref="article" :categories="categories" :suppliers="suppliers"></Fields>

                            <button type="button" class="btn btn-block btn-primary"
                                    @click="update_record(article.id)">
                                Сохранить
                            </button>

                            <a :href="route('articles.index')" class="btn btn-block btn-link text-muted">
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
import Fields from './../../Pages/Articles/Fields'

export default {

    components: {
        DashboardLayout,
        Fields
    },

    props: {
        article: Object,
        categories: Array,
        suppliers: Array,
    },

    name: 'my-component',

    data() {
        return {};
    },
    mounted() {
        this.$refs.article.$data.article = this.article
    },
    methods: {
        update_record: async function (id) {
            this.$swal({
                title: 'Вы уверены?',
                text: "Новость будет изменена!",
                type: 'warning',
                buttons: {
                    confirm: {
                        text: "Да",
                        value: true,
                        visible: true,
                        className: "isConfirm",
                        closeModal: true
                    },
                    cancel: {
                        text: "Нет",
                        value: false,
                        visible: true,
                        className: "",
                        closeModal: true,
                    }
                }
            }).then((isConfirm) => {
                if (isConfirm === true) {
                    axios.put(route("articles.update", id), this.article)
                        .then(
                            (response) => {
                                toast.fire({title: response.data.message})
                                this.$inertia.visit(route('articles.index'));
                            },
                            (error) => {
                                if (error.message === 'Request failed with status code 422') {
                                    this.$swal('Ошибка', 'Заполните все обязательные поля (помечены звёздочкой)', 'error')
                                } else {
                                    this.$swal('Ошибка', error.message, 'error')
                                }
                            }
                        )
                }
            });
        }
    }

};


</script>
