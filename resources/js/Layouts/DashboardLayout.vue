<template>
    <!--<div>-->
    <!--    <header class="bg-white shadow">-->
    <!--        <Sidebar/>-->
    <!--    </header>-->
    <!--    <main>-->
    <!--        <slot></slot>-->
    <!--    </main>-->
    <!--</div>-->


    <div>

        <!-- NAVIGATION
    ================================================== -->
        <Sidebar ref="sidebar"/>

        <slot></slot>

        <div class="modal fade" id="modal-notifications" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Новости на публикацию</h4>
                        <button type="button" class="btn btn-default" data-dismiss="modal"
                                ref="close_modal_company">Закрыть
                        </button>
                    </div>
                    <input type="text" name="modal" id="modal" hidden value="1">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Заявка</th>
                                                <th scope="col">Дата</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(article, article_id) in notifications">
                                                <th scope="row">{{ article_id + 1 }}</th>
                                                <td>
                                                    <a :href="route('articles.edit', article.id)"
                                                       title="Редактировать">{{ article.name }}</a>
                                                </td>
                                                <td>{{ article.publish_at }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- /.card-body -->
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

    </div>


</template>


<script>

import Sidebar from './../Components/Sidebar'

export default {
    components: {
        Sidebar
    },
    data() {
        return {
            notifications: []
        }
    },
    mounted() {
        this.getNotfications();
    },
    methods: {
        getNotfications() {
            axios.post(route("notifications.get"))
                .then(
                    (response) => {
                        console.log(response)
                        this.$refs.sidebar.$data.notificationsCount = response.data.articles.length
                        this.notifications = response.data.articles
                    },
                    (error) => {
                        this.$swal('Ошибка', 'Введите корректные данные', 'error')
                    }
                )
        },
    }
}
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
