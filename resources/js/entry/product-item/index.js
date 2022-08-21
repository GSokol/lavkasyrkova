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

        const mainCarousel = ref(null);
        const thumbnailSettings = {
            itemsToShow: 4,
            wrapAround: true,
        };
        const thumbnailBreakpoints = {
            320: {
                itemsToShow: 2,
                snapAlign: 'start',
            },
            640: {
                itemsToShow: 3,
                snapAlign: 'center',
            },
            1024: {
                itemsToShow: 4,
                snapAlign: 'center',
            },
        };

        return {
            mainCarousel,
            product,
            slides,
            thumbnailBreakpoints,
            thumbnailSettings,
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

    methods: {
        onThumbnailClick: function(index) {
            this.mainCarousel.slideTo(index);
        },
    },
}).mount('#root');
