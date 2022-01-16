<template>
    <form class="mb-4">
        <div class="row">
            <div class="col-10 col-lg-10">
                <div class="form-group">
                    <label>Название <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" v-model="category.name" :disabled="page==='profile'">
                </div>
            </div>
            <div class="col-2 pl-0">
                <div class="form-group float-right">
                    <label>Активно</label>
                    <div class="input-group" style="cursor: pointer">
                        <div class="input-group-prepend">
                                                    <span @click="page!=='profile' ? category.is_active=1 : ''"
                                                          :class="`input-group-text ${ category.is_active ? 'bg-primary text-white' : '' }`">Да</span>
                        </div>
                        <div class="input-group-append">
                                                    <span @click="page!=='profile' ? category.is_active=0 : ''"
                                                          :class="`input-group-text ${ !category.is_active ? 'bg-primary text-white' : '' }`">Нет</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-12">
                <div class="form-group">
                    <label>Описание</label>
                    <textarea class="form-control" v-model="category.description" :disabled="page==='profile'"></textarea>
                </div>
            </div>
        </div>

    </form>
</template>

<script>
import axios from "axios";

export default {
    components: {},

    props: {
        page: String
    },

    name: 'my-component',

    data() {
        return {
            category: {
                is_active: 1
            }
        };
    },
    created() {
    },
    mounted() {
    },
    methods: {}

};


</script>
