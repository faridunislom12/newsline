<template>
    <dashboard-layout>


        <div class="main-content">
            <div class="header">
                <div class="container-fluid">
                    <div class="header-body">
                        <div class="row align-items-end">
                            <div class="col">
                                <h6 class="header-pretitle">
                                    Админ панель
                                </h6>
                                <h1 class="header-title">
                                    Пользователи
                                </h1></div>
                        </div>
                    </div>
                </div>
            </div>


<!--                        {{ users }}-->


            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-lg-6 col-xl">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row align-items-center">
                                            <div class="col"><h4 class="card-header-title">
                                                Пользователи
                                            </h4></div>
                                            <div v-if="$userPermissions.includes('users-create')==true"
                                                 class="col-auto"><a
                                                :href="route('users.create')"
                                                class="btn btn-primary lift">
                                                Добавить
                                            </a></div>
                                            <div class="col-auto">
                                                <a type="button" class="float-right" data-toggle="modal"
                                                   data-backdrop="static"
                                                   data-target="#modal-company"><i class="fe fe-settings"></i></a>
                                            </div>
                                        </div>
                                    </div>


                                    <div
                                        data-list="{&quot;valueNames&quot;: [&quot;goal-project&quot;, &quot;goal-status&quot;, &quot;goal-progress&quot;, &quot;goal-date&quot;]}"
                                        class="table-responsive mb-0">
                                        <div v-if="$userPermissions.includes('users-read')==true">
                                            <vue-good-table
                                                :columns="columns"
                                                :rows="rows"
                                                :fixed-header="false"
                                                :line-numbers="true"
                                                @on-row-dblclick="function (params) {$inertia.visit(route('users.edit', params.row.id));}"
                                                :search-options="{
                                                    enabled: true,
                                                    skipDiacritics: true,
                                                    placeholder: 'Поиск',
                                                }"
                                                :pagination-options="{
                                                    enabled: true,
                                                    mode: 'pages',
                                                    perPage: 50,
                                                    perPageDropdown: [10, 20, 30, 50],
                                                    position: 'bottom',
                                                    dropdownAllowAll: true,
                                                    setCurrentPage: 1,
                                                    nextLabel: 'след',
                                                    prevLabel: 'пред',
                                                    rowsPerPageLabel: 'Строк на странице',
                                                    ofLabel: 'из',
                                                    pageLabel: 'страница', // for 'pages' mode
                                                    allLabel: 'Все',
                                                  }"
                                            >
                                                <div slot="emptystate">
                                                    Нет записей
                                                </div>
                                                <template slot="table-row" slot-scope="props">
                                                    <span v-if="props.column.field == 'actions'">

                                                     <a v-if="$userPermissions.includes('users-update')==true"
                                                        :href="route('users.access', props.row.id)"
                                                        title="Управление доступом" class="badge badge-soft-secondary">
                                                         <i class="fe fe-unlock"></i>
                                                     </a>

                                                     <a v-if="$userPermissions.includes('users-update')==true"
                                                        :href="route('users.edit', props.row.id)"
                                                        title="Редактировать" class="badge badge-warning">
                                                         <i class="fe fe-edit"></i>
                                                     </a>

                                                     <button v-if="$userPermissions.includes('users-delete')==true"
                                                             title="Удалить" class="btn badge badge-danger"
                                                             @click="delete_record(props.row.id)">
                                                            <i class="fe fe-trash"></i>
                                                    </button>
                                                    </span>
                                                    <span v-else-if="props.column.field == 'is_active'">
                                                         <span class="badge badge-danger" v-if="props.row.is_active==0">не активен</span>
                                                         <span class="badge badge-success"
                                                               v-else-if="props.row.is_active==1">активен</span>
                                                    </span>
                                                    <span v-else-if="props.column.field == 'gender'">
                                                         {{ props.row.gender==0 ? 'женский' : props.row.gender==1 ? 'мужской' : '' }}
                                                    </span>
                                                </template>

                                            </vue-good-table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal-company" style="display: none;" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Настройки</h4>
                            <button type="button" class="btn btn-default" data-dismiss="modal"
                                    ref="close_modal_company" @click="saveColumns()">Закрыть
                            </button>
                        </div>
                        <input type="text" name="modal" id="modal" hidden value="1">
                        <div class="modal-body">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-lg-12">
                                        <div class="form-group"><label>Колонки</label>
                                            <multiselect v-model="columns"
                                                         :options="all_columns" :multiple="true"
                                                         :close-on-select="false" :clear-on-select="false"
                                                         :preserve-search="true" placeholder="Выберите колонку"
                                                         label="label" track-by="label" :preselect-first="false">
                                                <template slot="selection" slot-scope="{ values, search, isOpen }">
                                                        <span class="multiselect__single"
                                                              v-if="values.length &amp;&amp; !isOpen">Выбрано колонок: {{
                                                                values.length
                                                            }}</span>
                                                </template>
                                            </multiselect>
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


    </dashboard-layout>
</template>

<script>
import DashboardLayout from './../../Layouts/DashboardLayout'
import axios from "axios";

export default {
    components: {
        DashboardLayout
    },

    props: {
        users: Array,
        columns: Array,
        all_columns: Array
    },

    name: 'my-component',

    data() {
        return {
            rows: this.users
        };
    },

    mounted() {
    },

    methods: {
        delete_record: function (id) {
            this.$swal({
                title: 'Вы уверены?',
                text: "Пользователь будет удален!",
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
                    axios.delete(route("users.destroy", id))
                        .then(
                            (response) => {
                                const index = this.users.map(user => user.id).indexOf(id);
                                this.users.splice(index, 1);
                                toast.fire({title: response.data.message})
                            },
                            (error) => {
                                console.log(error)
                            }
                        )
                }
            });
        },
        saveColumns() {
            axios.put(route("users.update", this.$page.props.user.id), {component_columns: {user: this.columns}})
                .then(
                    (response) => {
                        console.log(response)
                    },
                    (error) => {
                        this.$swal('Ошибка', 'Введите корректные данные', 'error')
                    }
                )
        },
    }

};


</script>
