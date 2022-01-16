<template>
    <nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light" id="sidebar">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidebarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>

            <a class="navbar-brand" :href="route('index')">
                <img src="/images/logo.png" class="navbar-brand-img mx-auto" alt="Logo">
            </a>

            <div class="navbar-user d-md-none">
                <div class="dropdown">
                    <a href="#!" id="sidebarIcon" class="dropdown-toggle" role="button" data-toggle="dropdown">
                        <div class="avatar avatar-sm avatar-online">
                            <img src="/img/avatars/profiles/avatar-1.jpg" class="avatar-img rounded-circle"
                                 alt="Logo">
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="sidebarIcon">
                        <a href="#!" class="dropdown-item">!Профиль</a>
                        <a href="/account-general" class="dropdown-item">Настройки</a>
                        <hr class="dropdown-divider">
                        <a href="/logout" class="dropdown-item">Выйти</a>
                    </div>
                </div>
            </div>

            <div class="collapse navbar-collapse" id="sidebarCollapse">
                <form class="mt-4 mb-3 d-md-none">
                    <div class="input-group input-group-rounded input-group-merge">
                        <input type="search" class="form-control form-control-rounded form-control-prepended"
                               placeholder="Поиск по админке...">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><span class="fe fe-search"></span></div>
                        </div>
                    </div>
                </form>
                <ul class="navbar-nav mb-md-4">
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="modal"
                           data-backdrop="static"
                           data-target="#modal-notifications"><i class="fe fe-mail"></i>На публикацию <span
                            v-if="notificationsCount!==0"
                            class="badge bg-warning ms-auto"><strong>{{ notificationsCount }}</strong></span></a>
                        <!--                        <a :class="`nav-link ${this.$page.url == '/applications/create' ? 'bg-primary-soft' : ''}`"-->
                        <!--                           :href="route('applications.create')">-->
                        <!--                            <i class="fe fe-check"></i> Создание заявки-->
                        <!--                        </a>-->
                    </li>
                </ul>

                <hr class="navbar-divider my-3">
                <div>
                    <hr class="navbar-divider my-3"></hr>
                    <h6 class="navbar-heading">Справочники</h6>
                    <ul class="navbar-nav">
                        <li v-if="$userPermissions.includes('categories-create') || $userPermissions.includes('categories-read')"
                            class="nav-item">
                            <a :class="`nav-link ${this.$page.url == '/categories' ? 'bg-primary-soft' : ''}`"
                               :href="route('categories.index')">
                                <i class="fe fe-grid"></i> Категории
                            </a>
                        </li>
                        <li v-if="$userPermissions.includes('articles-create') || $userPermissions.includes('articles-read')"
                            class="nav-item">
                            <a :class="`nav-link ${this.$page.url == '/articles' ? 'bg-primary-soft' : ''}`"
                               :href="route('articles.index')">
                                <i class="fe fe-list"></i> Новости
                            </a>
                        </li>
                    </ul>
                </div>
                <div v-if="$userRoles.includes('administrator')">
                    <hr class="navbar-divider my-3"></hr>
                    <!--                <h6 class="navbar-heading">Администрирование</h6>-->
                    <ul class="navbar-nav">

                        <li class="nav-item">
                            <a class="nav-link collapsed" href="#humans" data-toggle="collapse" role="button"
                               aria-expanded="false" aria-controls="humans">Администрирование</a>
                            <div class="collapse" id="humans" style="">
                                <ul class="nav nav-sm flex-column">
                                    <li v-if="$userPermissions.includes('users-create') || $userPermissions.includes('users-read')"
                                        class="nav-item">
                                        <a :class="`nav-link ${this.$page.url == '/users' ? 'bg-primary-soft' : ''}`"
                                           :href="route('users.index')">
                                            <i class="fe fe-user-check"></i> Пользователи
                                        </a>
                                    </li>
                                    <li v-if="$userPermissions.includes('roles-create') || $userPermissions.includes('roles-read')"
                                        class="nav-item">
                                        <a :class="`nav-link ${this.$page.url == '/roles' ? 'bg-primary-soft' : ''}`"
                                           :href="route('roles.index')">
                                            <i class="fe fe-airplay"></i> Роли
                                        </a>
                                    </li>
                                    <li v-if="$userPermissions.includes('permissions-create') || $userPermissions.includes('permissions-read')"
                                        class="nav-item">
                                        <a :class="`nav-link ${this.$page.url == '/permissions' ? 'bg-primary-soft' : ''}`"
                                           :href="route('permissions.index')">
                                            <i class="fe fe-alert-circle"></i> Разрешения
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
                <hr class="navbar-divider my-3"></hr>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link"
                           :href="route('logout')">
                            <i class="fe fe-log-in"></i> Выйти
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>
<script>

export default {
    components: {},
    data() {
        return {
            notificationsCount: 0
        }
    },
    mounted() {
    },
    methods: {}
}
</script>
