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
                                                Пользователь
                                            </h6>
                                            <h1 class="header-title">
                                                Добавление
                                            </h1></div>
                                    </div>
                                </div>
                            </div>
                            <form class="mb-4">
                                <div class="row">
                                    <div class="col-4 col-lg-4">
                                        <div class="form-group"><label>Фамилия <span
                                            class="text-danger">*</span></label>
                                            <input type="text" class="form-control" v-model="user.last_name">
                                        </div>
                                    </div>
                                    <div class="col-4 col-lg-4">
                                        <div class="form-group"><label>Имя <span
                                            class="text-danger">*</span></label>
                                            <input type="text" class="form-control" v-model="user.name">
                                        </div>
                                    </div>
                                    <div class="col-4 col-lg-4">
                                        <div class="form-group">
                                            <label>Отчество</label>
                                            <input type="text" class="form-control" v-model="user.middle_name">
                                        </div>
                                    </div>
                                    <div class="col-4 col-lg-4">
                                        <div class="form-group">
                                            <label>Дата рождения</label>
                                            <input type="date" class="form-control" v-model="user.birthdate">
                                        </div>
                                    </div>
                                    <div class="col-4 col-lg-4">
                                        <div class="form-group">
                                            <label>Должность</label>
                                            <input type="text" class="form-control" v-model="user.job">
                                        </div>
                                    </div>
                                    <div class="col-4 col-lg-4">
                                        <div class="form-group">
                                            <label>E-mail (логин в систему)</label>
                                            <input type="text" class="form-control" v-model="user.email">
                                        </div>
                                    </div>
                                    <div class="col-4 col-lg-4">
                                        <div class="form-group">
                                            <label>Телефон</label>
                                            <input type="text" class="form-control" v-model="user.phone"
                                                   v-mask="'+7 (###) ###-##-##'">
                                        </div>
                                    </div>
                                    <div class="col-4 col-lg-4">
                                        <div class="form-group">
                                            <label>Роль</label>
                                            <select v-model="user.role_id" class="custom-select">
                                                <option disabled selected value>Выберите статус</option>
                                                <option :value="role.id" v-for="role in roles"
                                                        v-bind:key="role.id">
                                                    {{ role.name }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4 pl-0">
                                        <div class="form-group float-right">
                                            <label>Активен</label>
                                            <div class="input-group" style="cursor: pointer">
                                                <div class="input-group-prepend">
                                                    <span @click="user.is_active=1"
                                                          :class="`input-group-text ${ user.is_active ? 'bg-primary text-white' : '' }`">Да</span>
                                                </div>
                                                <div class="input-group-append">
                                                    <span @click="user.is_active=0"
                                                          :class="`input-group-text ${ !user.is_active ? 'bg-primary text-white' : '' }`">Нет</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-12">
                                        <div class="form-group">
                                            <label>Заметки</label>
                                            <textarea class="form-control" v-model="user.note"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Пароль <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" v-model="user.password">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Повторите пароль <span class="text-danger">*</span>
                                                <span class="text-danger"
                                                      v-if="passwordConfirm!='' && passwordConfirm!=user.password">(пароли не совпадают)</span>
                                                <span class="text-success"
                                                      v-if="passwordConfirm!='' && passwordConfirm==user.password">(пароли совпадают)</span>
                                            </label>
                                            <input type="password" class="form-control" v-model="passwordConfirm">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <button type="button" class="btn btn-block btn-primary" @click="create_record()">
                                Сохранить
                            </button>

                            <a :href="route('users.index')" class="btn btn-block btn-link text-muted">
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

export default {
    components: {
        DashboardLayout
    },

    props: {
        cities: Array,
        roles: Array,
        legals: Array
    },

    name: 'my-component',

    data() {
        return {
            showDocuments: false,
            legals_order: {name: 1},
            upload_file: {id: null},
            user: {
                is_active: 1,
            },
            passwordConfirm: '',
        };
    },
    mounted() {
        this.legals.forEach(legal => this.user.documents.push({file_name: ''}, {file_name: ''}, {file_name: ''}, {file_name: ''}, {file_name: ''}))
    },
    methods: {
        updateFile(files) {
            let file = files.target.files[0];
            let reader = new FileReader();
            reader.onloadend = () => {
                this.user.documents.splice(this.upload_file.id, 1, {
                    file_name: file.name,
                    data: reader.result
                });
            }

            reader.readAsDataURL(file);
        },
        create_record: function () {
            axios.post(route("users.store"), this.user)
                .then(
                    (response) => {
                        // console.log(response)
                        toast.fire({title: response.data.message})
                        this.$inertia.visit(route('users.index'));
                    },
                    (error) => {
                        this.$swal('Ошибка', 'Введите корректные данные', 'error')
                    }
                )

        }
    }

};


</script>
