import { createApp } from 'vue';
import axios from 'axios';
import HoneyGallery from './components/HoneyGallery.vue';
import { initGalleryLightbox } from './gallery-lightbox';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const menuToggle = document.querySelector('[data-menu-toggle]');
const menu = document.querySelector('[data-menu]');
if (menuToggle && menu) {
    menuToggle.addEventListener('click', () => menu.classList.toggle('is-open'));
}

const galleryRoot = document.querySelector('[data-gallery-app]');
if (galleryRoot) {
    createApp(HoneyGallery, {
        items: JSON.parse(galleryRoot.dataset.items || '[]'),
    }).mount(galleryRoot);
}

initGalleryLightbox();
