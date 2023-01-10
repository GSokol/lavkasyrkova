'use strict';

import { createApp } from 'vue';
import api from '../../core/api.js';
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

    created() {
        this.route = window.route;
    },

    methods: {
        /**
         * Отправка формы редактирования заказа
         *
         * @param {Object} event [EventSubmit]
         * @return {void}
         */
        onOrderSubmit: function(event) {
            this.state.isLoading = true;
            let param = _.pick(this.order, ['id', 'discount_value', 'payment_link', 'order_to_products']);

            return api.put(window.route('api.dashboard.putOrder'), param).then((response) => {
                this.state.isLoading = false;
                alert({
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
         * Сумма доставки
         * если итоговая сумма > 3К то доставка 0 руб. иначе 300 руб.
         *
         * @see feature-20
         * @return {Number} [сумма в рублях]
         */
        deliveryAmount() {
            return this.totalAmount > 3000 ? 0 : 300;
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
         * Сумма заказа (с учетом скидки + доставка)
         *
         * @return {Number} [итоговая сумма в рублях]
         */
        checkoutAmount() {
            return Math.ceil(this.totalAmount - this.discountAmount + this.deliveryAmount);
        },
    },
}).mount('#root');
