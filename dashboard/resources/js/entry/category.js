'use strict';

import { createApp } from 'vue';
import axios from 'axios';
import { get } from 'lodash';

const app = createApp({
    data: function() {
        return {
            collection: _.get(window.app, 'categories'),
            state: {
                isLoading: false,
            },
        }
    },

    mounted() {
        //
    },

    created: function() {
        //
    },

    methods: {
        onDelete: function(model, index) {
            if (confirm(`Вы действительно хотите удалить категорию: ${model.name}?`)) {
                axios({
                    method: 'delete',
                    url: '/dashboard/category/delete',
                    data: {
                        id: model.id,
                    },
                }).then((response) => {
                    if (response.status === 200) {
                        this.collection.splice(index, 1);
                    }
                });
            }
        },
    },

    computed: {
        //
    },
}).mount('#root');
