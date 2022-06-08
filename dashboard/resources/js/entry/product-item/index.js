'use strict';

import { computed, createApp, reactive, ref } from 'vue';
import axios from 'axios';
import api from '../../core/api.js';
import { get } from 'lodash';
import {
    ElButton,
    ElCheckbox,
    ElInput,
    ElSelect,
    ElOption,
} from 'element-plus';

const app = createApp({
    components: {
        ElButton,
        ElCheckbox,
        ElInput,
        ElSelect,
        ElOption,
    },

    setup() {
        const product = reactive(window.app.product || {});
        const recommendedList = ref([]);
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
            console.log('submit', product);

            postProduct(product).then((response) => {
                console.log('response sss', response);
            });
        };
        const postProduct = (model) => {
            return api.post(route('api.dashboard.postProduct'), model, {
                notify: true,
            }).then(({response}) => {

            });

            // return axios({
            //     method: 'post',
            //     url: route('api.dashboard.postProduct'),
            //     data: model,
            // }).then((response) => {
            //     console.log('response', response);
            // });
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
        };
    },

    mounted() {
        //
    },

    created: function() {
        // console.log('created product item', this);
    },

    methods: {
        fetchProducts: function() {
            this.state.isLoading = true;
            axios({
                method: 'get',
                url: '/api/dashboard/product/fetch',
                params: {
                    q: 'бел',
                },
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.head.querySelector('[name=csrf]') ? document.head.querySelector('[name=csrf]').content : (window.app ? window.app.csrf : null),
                },
            }).then((response) => {
                this.state.isLoading = false;
                if (response.status === 200) {
                    this.recommendedList = response.data;
                }
            });
        },

        getProducts: function() {
            //
        },
    },

    computed: {
        //
    },
}).mount('#root');
