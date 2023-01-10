import { createApp, h, ref } from 'vue';
import ModalCheckout from '../../components/modal/modal.checkout.vue';
import { ElButton, ElMessageBox } from 'element-plus';

const app = createApp({
    components: {
        ElButton,
    },

    setup() {
        const state = ref({
            isLoading: false,
        });

        // console.log('setup');

        return {
            state,
        };
    },

    data: function() {
        return {
            //
        }
    },

    methods: {
        /**
         * Показать окно оформление заказа
         *
         * @return {void}
         */
        showBasket: function() {
            ElMessageBox({
                title: 'Оформление заказа',
                message: h(ModalCheckout, {
                    props: {
                        stores: window.app.stores,
                    },
                }),
                showConfirmButton: false,
            }).catch((error) => {
                console.log(error);
            });
        },
    },
}).mount('#root');
