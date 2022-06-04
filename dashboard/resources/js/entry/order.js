'use strict';

import { createApp } from 'vue';
import axios from 'axios';
import { get, keyBy, sumBy } from 'lodash';
import { alert } from '@pnotify/core';

const app = createApp({
    data: function() {
        return {
            order: _.get(window.app, 'order'),
            orderStatuses: _.get(window.app, 'orderStatuses') || [],
            state: {
                isLoading: false,
            },
        }
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
            let param = _.pick(this.order, ['id', 'discount_value', 'order_to_products']);

            axios({
                method: 'put',
                url: '/dashboard/orders/item',
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

        orderProducts() {
            return _.each(this.order.order_to_products, (orderProduct) => {
                // на вес
                if (orderProduct.actual_value) {
                    let price = orderProduct.product.action ? orderProduct.product.action_part_price : orderProduct.product.part_price;
                    let weight = orderProduct.actual_value || orderProduct.part_value;
                    orderProduct.calculate_amount = Math.round(weight / 100 * price)
                } else {
                    orderProduct.calculate_amount = orderProduct.amount;
                }
            });
        },

        /**
         * Сумма заказа (без учета скидки)
         *
         * @return {Number} [description]
         */
        totalAmount() {
            return _.sumBy(this.orderProducts, 'calculate_amount');
        },

        /**
         * Размер скидки в деньгах
         *
         * @return {Number} [description]
         */
        discountAmount() {
            let discountValue = +_.get(this.order, 'discount_value', 0);
            return this.totalAmount * discountValue / 100;
        },

        /**
         * Сумма заказа (с учетом скидки)
         *
         * @return {Number} [description]
         */
        checkoutAmount() {
            return Math.ceil(this.totalAmount - this.discountAmount);
        },
    },
}).mount('#root');
