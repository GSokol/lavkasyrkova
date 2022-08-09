import { createApp, ref } from 'vue';
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel';
import 'vue3-carousel/dist/carousel.css';

createApp({
    setup() {
        const product = ref(window.app.product);
        const slides = _.chain(window.app.product)
            .get('gallery')
            .map((row) => {
                row.path = '/' + row.path;
                return row;
            })
            .tap((rows) => {
                rows.unshift({path: product.value.image});
            })
            .value();

        return {
            product,
            slides,
        };
    },

    components: {
        InCarousel: Carousel,
        InSlide: Slide,
        InPagination: Pagination,
        InNavigation: Navigation,
    },

    data: function() {
        return {
            //
        }
    },

    created() {
        console.log('created');
    },

    methods: {
        //
    },
}).mount('#root');
