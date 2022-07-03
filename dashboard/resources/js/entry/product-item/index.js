'use strict';

import { computed, createApp, reactive, ref } from 'vue';
import axios from 'axios';
import api from '../../core/api.js';
import { get } from 'lodash';
import {
    ElButton,
    ElCheckbox,
    ElIcon,
    ElInput,
    ElLink,
    ElSelect,
    ElSwitch,
    ElOption,
    ElUpload,
} from 'element-plus';

const app = createApp({
    components: {
        ElButton,
        ElCheckbox,
        ElIcon,
        ElInput,
        ElLink,
        ElSelect,
        ElSwitch,
        ElOption,
        ElUpload,
    },

    setup() {
        const product = reactive(window.app.product || {});
        const recommendedList = ref(product.related || []);
        const state = ref({
            isLoading: false,
        });
        const categories = computed(() => {
            return window.app.categories;
        });
        const addCategories = computed(() => {
            return window.app.addCategories;
        });
        const onSubmit = () => {
            return api.post(route('api.dashboard.postProduct'), product, {
                notify: true,
            }).then(({data: response}) => {
                console.log('response', response);
                if (response.error == 201) {
                    window.location.href = route('dashboard.product', {id: response.data});
                }
            }).catch((error) => {
                console.log('error', error);
            })
        };
        const same = ref([]);

        return {
            addCategories,
            categories,
            onSubmit,
            product,
            recommendedList,
            state,
            same,
            route,
        };
    },

    methods: {
        suggestProducts: function(query) {
            const payload = {
                q: query,
            };
            this.state.isSuggestLoading = true;
            api.get(route('api.dashboard.getProductSuggest'), payload, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            }).then(({data: response}) => {
                this.state.isSuggestLoading = false;
                this.recommendedList = response.data;
            });
        },

        postImageUpload: function(request) {
            const payload = new FormData();
            payload.append('id', this.product.id);
            payload.append('file', request.file);
            api.post(route('api.dashboard.postProductImageUpload'), payload, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            }).then(({data: response}) => {
                this.product.image = '/' + response.data.path;
            });
        },

        handleImageRemove: function(model) {
            console.log('delete', model);
        },

        /**
         * Удаление товара
         *
         * @return {Promise} [description]
         */
        removeProduct() {
            if (!confirm('Вы действительно хотите удалить товар?')) {
                return Promise.resolve();
            }
            const payload = {id: this.product.id};
            return api.delete(route('api.dashboard.deleteProduct'), payload).then((response) => {
                window.location.href = route('dashboard.products');
            });
        },
    },

    computed: {
        //
    },
}).mount('#root');
