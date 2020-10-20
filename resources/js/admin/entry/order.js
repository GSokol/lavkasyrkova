import Vue from 'vue';
import axios from 'axios';
import { get, keyBy, sumBy } from 'lodash';
import { alert } from '@pnotify/core';

new Vue({
    el: '#root',

    data: function() {
        return {
            order: _.get(window.app, 'order'),
            orderStatuses: _.get(window.app, 'orderStatuses') || [],
            state: {
                isLoading: false,
            },
        }
    },

    mounted() {
        //
    },

    created: function() {
        console.log('order');
    },

    methods: {
        /**
         * Отправка формы редактирования заказа
         *
         * @param  {Object} event [EventSubmit]
         * @return {void}
         */
        onOrderSubmit: function(event) {
            this.state.isLoading = true;
            let param = _.pick(this.order, ['id', 'discount_value']);

            axios({
                method: 'put',
                url: '/admin/orders/item',
                data: param,
            }).then((response) => {
                this.state.isLoading = false;
                alert({
                    // title: "I'm an alert.",
                    text: response.data.message,
                    type: 'success',
                });
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

    computed: {
        orderStatusById() {
            return _.keyBy(this.orderStatuses, 'id');
        },

        statusClassName() {
            let currentStatus = _.get(this.order, 'status_id');
            let className =_.get(this.orderStatusById, [currentStatus, 'class_name'], 'default');
            return 'bg-' + className + '-400';
        },

        orderAmount() {
            return _.sumBy(this.order.order_to_products, 'amount');
        },

        discountAmount() {
            let discountValue = +_.get(this.order, 'discount_value', 0);
            return this.orderAmount * discountValue / 100;
        },

        totalAmount() {
            return Math.round(this.orderAmount - this.discountAmount);
        },
    },
});
