'use strict';

import { computed, createApp, reactive, ref } from 'vue';
import api from '../../core/api.js';
import {
    // ElButton,
} from 'element-plus';

const app = createApp({
    components: {
        //
    },

    setup() {
        const collection = reactive(window.app.tastings);
        const state = ref({
            isLoading: false,
        });

        /**
         * Удаление дегустрации
         *
         * @param {Object} [Tasting model]
         * @return {Promise}
         */
        const removeTasting = (model, index) => {
            if (!confirm('Вы действительно хотите удалить дегустацию?')) {
                return Promise.resolve();
            }
            const payload = {id: model.id};
            return api.delete(route('api.dashboard.deleteTasting'), payload).then((response) => {
                collection.splice(index, 1);
            });
        };

        return {
            collection,
            removeTasting,
            route,
            state,
        };
    },
}).mount('#root');
