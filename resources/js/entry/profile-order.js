import { createApp } from 'vue';
import axios from 'axios';
import { get } from 'lodash';
import { alert } from '@pnotify/core';

const app = createApp({
    data: function() {
        return {
            collection: _.get(window.app, 'collection') || [],
            state: {
                isLoading: false,
            },
        }
    },

    methods: {
        /**
         * Повторить заказ
         *
         * @param  {Object} order [App\Models\Order]
         * @return {void}
         */
        onRepeatOrder: function(order) {
            if (!confirm('Вы действительно хотите повторить заказ №' + order.id + ' ?')) {
                return false;
            }
            this.state.isLoading = true;
            let param = _.pick(order, ['id']);

            axios({
                method: 'post',
                url: '/profile/orders/repeat',
                data: param,
            }).then((response) => {
                this.state.isLoading = false;
                alert({
                    // title: "I'm an alert.",
                    text: response.data.message,
                    type: 'success',
                });
                if (response.data.error === 201) {
                    let clone = response.data.data;
                    clone.isNew = true;
                    this.collection.unshift(clone);
                    window.scrollTo(0, 0);
                }
            }).catch((error) => {
                this.state.isLoading = false;
                _.flatMap(_.get(error, ['response', 'data', 'data'], []), (n) => n).map((msg) => {
                    alert({
                        title: error.response.data.message,
                        text: msg.message,
                        type: 'error',
                    });
                });

            });
        },

        /**
         * Удалить заказ
         *
         * @param  {Object} order [App\Models\Order]
         * @param  {Number} index [collection index]
         * @return {void}
         */
        onDeleteOrder: function(order, index) {
            if (!confirm('Вы действительно хотите удалить заказ №' + order.id + ' ?')) {
                return false;
            }
            this.state.isLoading = true;
            axios({
                method: 'delete',
                url: '/profile/orders/item',
                data: {id: order.id},
            }).then((response) => {
                this.state.isLoading = false;
                alert({
                    // title: "I'm an alert.",
                    text: response.data.message,
                    type: 'success',
                });
                if (response.data.error === 200) {
                    this.collection.splice(index, 1);
                }
            }).catch((error) => {
                this.state.isLoading = false
                alert({
                    title: error.response.data.message,
                    text: error.response.data.description,
                    type: 'error',
                });
            });
        },
    },
}).mount('#root');
