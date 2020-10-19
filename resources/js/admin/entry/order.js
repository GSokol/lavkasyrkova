import Vue from 'vue';
import axios from 'axios';
import { get, keyBy, sumBy } from 'lodash';

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
        // onDelete: function(model, index) {
        //     if (confirm(`Вы действительно хотите удалить категорию: ${model.name}?`)) {
        //         axios({
        //             method: 'delete',
        //             url: '/admin/category/delete',
        //             data: {
        //                 id: model.id,
        //             },
        //         }).then((response) => {
        //             if (response.status === 200) {
        //                 this.collection.splice(index, 1);
        //             }
        //         });
        //     }
        // },
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
