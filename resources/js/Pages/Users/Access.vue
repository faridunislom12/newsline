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
                                                Пользователи
                                            </h6>
                                            <h1 class="header-title">
                                                Управление доступом пользователя
                                            </h1></div>
                                    </div>
                                </div>
                            </div>
                            <!--                            {{ permissions }}-->
<!--                            {{ user }}-->
                            <form class="mb-4">

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Пользователь <span
                                                class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {{user.name}}<br/>
                                            {{user.phone}}<br/>
                                            {{user.email}}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <ul class="nav nav-tabs nav-tabs-sm nav-overflow">
                                                <li class="nav-item">
                                                    <a href="#" @click="state='permissions'"
                                                       :class="'nav-link '+(state==='permissions' ? 'active' : '')">
                                                        Разрешения
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#" @click="state='roles'"
                                                       :class="'nav-link '+(state==='roles' ? 'active' : '')">
                                                        Роли
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="state==='permissions'" class="row">
                                    <div class="col-12">

                                        <table class="table table-sm table-nowrap">
                                            <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Компонент</th>
                                                <th scope="col">Создание</th>
                                                <th scope="col">Чтение</th>
                                                <th scope="col">Изменение</th>
                                                <th scope="col">Удаление</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(permission, key) in permissions">
                                                <th scope="row">{{key+1}}</th>
                                                <td>{{permission.component}}</td>
                                                <td><input v-if="permission.create!==null" type="checkbox"
                                                           true-value="1" false-value="0"
                                                           v-model="permission.create"/></td>
                                                <td><input v-if="permission.read!==null" type="checkbox"
                                                           true-value="1" false-value="0"
                                                           v-model="permission.read"/></td>
                                                <td><input v-if="permission.update!==null" type="checkbox"
                                                           true-value="1" false-value="0"
                                                           v-model="permission.update"/></td>
                                                <td><input v-if="permission.delete!==null" type="checkbox"
                                                           true-value="1" false-value="0"
                                                           v-model="permission.delete"/></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <button type="button" class="btn btn-block btn-primary"
                                            @click="change_permissions()">
                                        Сохранить разрешения
                                    </button>

                                </div>


                                <div v-if="state==='roles'" class="row">

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <multiselect v-model="user.roles"
                                                         :options="roles" :multiple="true"
                                                         :close-on-select="false" :clear-on-select="false"
                                                         :preserve-search="true" placeholder="Выберите роли"
                                                         label="display_name" track-by="name" :preselect-first="false">
                                                <template slot="selection" slot-scope="{ values, search, isOpen }">
                                                        <span class="multiselect__single"
                                                              v-if="values.length &amp;&amp; !isOpen">Выбрано: {{
                                                                values.length
                                                            }}</span>
                                                </template>
                                            </multiselect>
                                            <br/>
                                            <table class="table table-responsive-sm">
                                                <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Название</th>
                                                    <th scope="col">Описание</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="(role, index) in user.roles" :key="index">
                                                    <th scope="row">{{ index + 1 }}</th>
                                                    <td>{{ role.name }}</td>
                                                    <td>{{ role.display_name }}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-block btn-primary"
                                            @click="change_roles()">
                                        Сохранить роли
                                    </button>

                                </div>


                                <a :href="route('users.index')" class="btn btn-block btn-link text-muted">
                                    Отмена
                                </a>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </dashboard-layout>
</template>

<script>
    import DashboardLayout from '../../Layouts/DashboardLayout'
    import axios from "axios";

    export default {
        components: {
            DashboardLayout,
        },

        props: {
            user: Object,
            roles: Array,
            permissions: Array,
        },

        name: 'my-component',

        data() {
            return {
                state: 'permissions',
            };
        },
        methods: {
            change_permissions: function (id) {
                axios.post(route("users.permissions.change", this.user.id), this.permissions)
                    .then(
                        (response) => {
                            console.log(response)
                            this.$swal({title: response.data.message, timer: 3000})
                            // this.$inertia.visit('/dashboard/permissions');
                        },
                        (error) => {
                            console.log(error)
                            this.$swal('Ошибка', 'Введите корректные данные', 'error')
                        }
                    )
            },
            change_roles: function (id) {
                axios.post(route("users.roles.change", this.user.id), this.user.roles)
                    .then(
                        (response) => {
                            console.log(response)
                            this.$swal({title: response.data.message, timer: 3000})
                            // this.$inertia.visit('/dashboard/permissions');
                        },
                        (error) => {
                            console.log(error)
                            this.$swal('Ошибка', 'Введите корректные данные', 'error')
                        }
                    )
            }
        }

    };


</script>
<style>

    .style-chooser .vs__dropdown-toggle {
        width: 100%;
        height: calc(1.5em + 1rem + 2px);
        padding: 0.5rem 0.75rem;
        font-size: 0.9375rem;
        font-weight: 400;
        line-height: 1.5;
        color: #12263F;
        background-clip: padding-box;
        border: 1px solid #d2ddec;
        border-radius: 0.375rem;
        transition: border-color 0.15s;
        background: #FFFFFF;
        /*background-clip: padding-box;*/
        text-transform: lowercase;
        font-variant: small-caps;
    }

    .style-chooser .vs__search::placeholder {
        color: #666565;
        font-size: small;
    }
</style>
<style src="../../../../node_modules/vue-multiselect/dist/vue-multiselect.min.css"></style>
<style>
    .tree-selec-allow {
        margin-top: 7px;
    }
</style>


