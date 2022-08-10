'use strict';

import { computed, createApp, reactive, ref } from 'vue';
import { createRouter, createWebHistory, useRouter } from 'vue-router';
import api from '../../core/api.js';
import { get } from 'lodash';
import {
    ElButton,
    ElCheckbox,
    ElDialog,
    ElIcon,
    ElInput,
    ElLink,
    ElMessage,
    ElSelect,
    ElSwitch,
    ElOption,
    ElUpload,
} from 'element-plus';
import { Delete, Plus, ZoomIn } from '@element-plus/icons-vue';

const router = createRouter({
    history: createWebHistory(),
    routes: [],
});

const app = createApp({
    components: {
        ElButton,
        ElCheckbox,
        ElDialog,
        ElIcon,
        ElInput,
        ElLink,
        ElMessage,
        ElSelect,
        ElSwitch,
        ElOption,
        ElUpload,

        ElIconDelete: Delete,
        ElIconPlus: Plus,
        ElIconZoomIn: ZoomIn,
    },

    setup() {
        const router = useRouter();
        const product = reactive(Object.assign({
            category_id: +router.currentRoute.value.query.category || null,
        }, window.app.product));
        const recommendedList = ref(product.related || []);
        const state = ref({
            isLoading: false,
        });
        const dialogImageUrl = ref('');
        const dialogVisible = ref(false);
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
        const handlePictureCardPreview = (file) => {
            dialogImageUrl.value = file.url;
            dialogVisible.value = true;
        };
        const same = ref([]);
        const mediaList = ref(product.gallery.map((media) => ({
            id: media.id,
            name: media.path,
            url: '/' + media.path,
        })));

        return {
            addCategories,
            categories,
            dialogImageUrl,
            dialogVisible,
            handlePictureCardPreview,
            mediaList,
            onSubmit,
            product,
            recommendedList,
            state,
            same,
            route,
            router,
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

        postMediaUploadFile: function(request) {
            const payload = new FormData();
            payload.append('model_id', this.product.id);
            payload.append('model_type', 'product');
            payload.append('file', request.file);
            api.post(route('api.dashboard.postMediaUploadFile'), payload, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            }).then(({data: response}) => {
                console.log('response', response);
            });
        },

        onMediaRemove: function(file) {
            if (!confirm('Вы действительно хотите удалить изображение?')) {
                return Promise.resolve();
            }
            const payload = {id: file.id};
            return api.delete(route('api.dashboard.deleteMedia'), payload).then((response) => {
                const index = this.mediaList.findIndex((media) => media.id === file.id);
                if (index >= 0) {
                    this.mediaList.splice(index, 1);
                    ElMessage({message: 'Media success delete', type: 'success'});
                }
            });
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
}).use(router);

router.isReady().then(() => {
    app.mount('#root')
});
