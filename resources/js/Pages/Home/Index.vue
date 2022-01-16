<template>
    <app-layout>
        <div class="main-content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-10 col-xl-8">
                        <!-- Header -->
                        <div class="header mt-md-5">
                            <div class="header-body">

                                <!-- Title -->
                                <h1 class="header-title">
                                    Новости
                                </h1>

                                <!-- Subtitle -->
                                <p class="header-subtitle">
                                    Последние новости ...
                                </p>

                            </div>
                        </div>

                        <!-- Card -->
                        <div class="card">
                            <div class="card-body">

                                <!-- Table -->
                                <div class="table-responsive">
                                    <table class="table table-sm table-striped">
                                        <thead>
                                        <tr>
                                            <th scope="col">дата</th>
                                            <th scope="col">заголовок</th>
                                            <th scope="col">текст</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="article in articles">
                                            <td>{{article.publish_at}}</td>
                                            <th scope="row">{{article.name}}</th>
                                            <td>{{article.text}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from './../../Layouts/AppLayout'

export default {
    components: {
        AppLayout
    },
    data() {
        return {
            articles: []
        }
    },
    created() {
        this.getArticles()
    },
    methods: {
        getArticles() {
            axios.post(route("articles.get"))
                .then(
                    (response) => {
                        console.log('response')
                        console.log(response)
                        this.articles = response.data.articles
                    },
                    (error) => {
                        console.log('error')
                        console.log(error)
                        this.$swal('Ошибка2', error.message, 'error')
                    }
                )
        },
    }
}
</script>
