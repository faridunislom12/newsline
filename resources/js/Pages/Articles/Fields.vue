<template>
    <form class="mb-4">
        <div class="row">
            <div class="col-10 col-lg-10">
                <div class="form-group">
                    <label>Название <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" v-model="article.name" :disabled="page==='profile'">
                </div>
            </div>
            <div class="col-2 pl-0">
                <div class="form-group float-right">
                    <label>Активно</label>
                    <div class="input-group" style="cursor: pointer">
                        <div class="input-group-prepend">
                                                    <span @click="page!=='profile' ? article.is_active=1 : ''"
                                                          :class="`input-group-text ${ article.is_active ? 'bg-primary text-white' : '' }`">Да</span>
                        </div>
                        <div class="input-group-append">
                                                    <span @click="page!=='profile' ? article.is_active=0 : ''"
                                                          :class="`input-group-text ${ !article.is_active ? 'bg-primary text-white' : '' }`">Нет</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-6">
                <div class="form-group">
                    <label>Категория <span class="text-danger">*</span></label>
                    <input v-if="page==='profile'" type="text" class="form-control" v-model="article.category.name" disabled>
                    <v-select v-else
                        placeholder="Выберите категорию"
                        class="style-chooser"
                        :options="categories"
                        :reduce="categories => categories.id"
                        label="name"
                        v-model="article.category_id"><span
                        slot="no-options">список пуст</span>
                    </v-select>
                </div>
            </div>
            <div class="col-6 col-lg-6">
                <div class="form-group">
                    <label>Дата публикации</label>
                    <input type="date" class="form-control" v-model="article.publish_at" :disabled="page==='profile'">
                </div>
            </div>
            <div class="col-12 col-lg-12">
                <div class="form-group">
                    <label>Текст <span class="text-danger">*</span></label>
                    <textarea class="form-control" v-model="article.text" :disabled="page==='profile'"></textarea>
                </div>
            </div>
            <div class="col-12 col-lg-12">
                <div class="form-group">
                    <label>
                        <input type="file" hidden @change="updateOrderFile"
                               class="form-control">
                        <span v-if="article.image.file_name">{{ article.image.file_name }}</span>
                        <span v-else title="Загрузите файл" class="fe fe-plus"
                              style="cursor: pointer"></span>
                    </label>
                    <img style="display:block; width:100px;height:100px;" :src="article.image.data || article.image.path" />
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
        categories: Array,
        suppliers: Array,
        page: String
    },

    name: 'my-component',

    data() {
        return {
            article: {
                is_active: 1,
                image: {}
            }
        };
    },
    created() {
    },
    mounted() {
    },
    methods: {
        updateOrderFile(files) {
            let file = files.target.files[0];
            let reader = new FileReader();
            reader.onloadend = () => {
                // this.order.tour_days[this.upload_data.tourDayId].services[this.upload_data.serviceId].files[this.upload_data.fileId].data
                this.article.image = {
                    file_name: file.name,
                    data: reader.result
                };
            }
            reader.readAsDataURL(file);
        },
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
