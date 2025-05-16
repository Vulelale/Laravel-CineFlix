import './bootstrap';
import '../css/app.css';

import Alpine from 'alpinejs'
window.Alpine = Alpine
Alpine.start()

// resources/js/app.js
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay } from 'swiper/modules';

// Иницијализација Swiper-а
document.addEventListener('DOMContentLoaded', function() {
    new Swiper('.swiper-container', {
        modules: [Navigation, Pagination, Autoplay],
        slidesPerView: 1,
        spaceBetween: 0,
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
            renderBullet: (index, className) => {
                return `<span class="${className} !bg-white !opacity-100 !w-2.5 !h-2.5"></span>`;
            },
        },
    });
});


