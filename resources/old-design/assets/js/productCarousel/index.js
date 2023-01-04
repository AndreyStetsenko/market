import Swiper from 'swiper';

export default function productCarousel() {
    const galleryThumbs = new Swiper('.product-carousel', {
        direction: 'horizontal',
        loop: false,
        spaceBetween: 10,
        slidesPerView: 4,
        slideToClickedSlide: true,
        watchSlidesProgress: true,
        freeMode: true
    });

    new Swiper('.product-main-image', {
        direction: 'horizontal',
        loop: false,
        spaceBetween: 10,
        slidesPerView: 1,
        thumbs: {
            swiper: galleryThumbs
        }
    });
}
