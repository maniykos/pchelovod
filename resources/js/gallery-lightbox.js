export function initGalleryLightbox() {
    const photos = [...document.querySelectorAll('[data-gallery-photo]')];
    if (!photos.length || typeof HTMLDialogElement === 'undefined') return;

    const labels = document.documentElement.lang === 'en' ? {
        photo: 'Photograph', close: 'Close (Esc)', previous: 'Previous photo', next: 'Next photo',
        original: 'Show at 100%', fit: 'Fit to window', loading: 'Loading photograph…',
        error: 'The photograph could not be loaded. Try another photo.', viewer: 'Photograph viewer',
    } : {
        photo: 'Фотография', close: 'Закрыть (Esc)', previous: 'Предыдущее фото', next: 'Следующее фото',
        original: 'Показать в масштабе 100%', fit: 'Вписать в окно', loading: 'Загрузка фотографии…',
        error: 'Не удалось загрузить фотографию. Попробуйте открыть другую.', viewer: 'Просмотр фотографии',
    };
    const dialog = document.createElement('dialog');
    dialog.className = 'gallery-lightbox';
    dialog.setAttribute('aria-labelledby', 'gallery-lightbox-title');
    dialog.innerHTML = `
        <header class="gallery-lightbox__toolbar">
            <p class="gallery-lightbox__caption" id="gallery-lightbox-title"></p>
            <div class="gallery-lightbox__actions">
                <button class="gallery-lightbox__button" type="button" data-gallery-zoom aria-pressed="false">100%</button>
                <button class="gallery-lightbox__button gallery-lightbox__close" type="button" data-gallery-close aria-label="${labels.close}" title="${labels.close}">×</button>
            </div>
        </header>
        <div class="gallery-lightbox__stage" tabindex="0" role="region" aria-label="${labels.viewer}">
            <p class="gallery-lightbox__status" role="status"></p>
            <img class="gallery-lightbox__image" alt="" draggable="false" hidden>
        </div>
        <footer class="gallery-lightbox__footer">
            <button class="gallery-lightbox__button" type="button" data-gallery-previous aria-label="${labels.previous}" title="${labels.previous}">←</button>
            <span class="gallery-lightbox__counter" aria-live="polite"></span>
            <button class="gallery-lightbox__button" type="button" data-gallery-next aria-label="${labels.next}" title="${labels.next}">→</button>
        </footer>`;
    document.body.append(dialog);

    const image = dialog.querySelector('.gallery-lightbox__image');
    const stage = dialog.querySelector('.gallery-lightbox__stage');
    const caption = dialog.querySelector('.gallery-lightbox__caption');
    const counter = dialog.querySelector('.gallery-lightbox__counter');
    const status = dialog.querySelector('.gallery-lightbox__status');
    const zoomButton = dialog.querySelector('[data-gallery-zoom]');
    const closeButton = dialog.querySelector('[data-gallery-close]');
    const previousButton = dialog.querySelector('[data-gallery-previous]');
    const nextButton = dialog.querySelector('[data-gallery-next]');
    let active = 0;
    let zoomed = false;
    let opener;

    function setZoom(actualSize) {
        if (actualSize && (!image.naturalWidth || zoomButton.disabled)) return;
        zoomed = actualSize;
        dialog.classList.toggle('is-actual-size', actualSize);
        image.style.width = actualSize ? `${image.naturalWidth}px` : '';
        image.style.height = actualSize ? `${image.naturalHeight}px` : '';
        zoomButton.textContent = actualSize ? labels.fit : '100%';
        zoomButton.setAttribute('aria-label', actualSize ? labels.fit : labels.original);
        zoomButton.setAttribute('aria-pressed', String(actualSize));
        if (actualSize) {
            stage.scrollTo((stage.scrollWidth - stage.clientWidth) / 2, (stage.scrollHeight - stage.clientHeight) / 2);
            stage.focus({ preventScroll: true });
        } else {
            stage.scrollTo(0, 0);
        }
    }

    function show(index) {
        active = (index + photos.length) % photos.length;
        setZoom(false);
        zoomButton.disabled = true;
        image.hidden = true;
        status.hidden = false;
        status.textContent = labels.loading;
        const thumbnail = photos[active].querySelector('img');
        caption.textContent = photos[active].dataset.title || thumbnail?.alt || labels.photo;
        image.alt = thumbnail?.alt || caption.textContent;
        image.src = photos[active].href;
        counter.textContent = `${String(active + 1).padStart(2, '0')} / ${String(photos.length).padStart(2, '0')}`;
    }

    image.addEventListener('load', () => {
        image.hidden = false;
        status.hidden = true;
        zoomButton.disabled = false;
    });
    image.addEventListener('error', () => {
        image.hidden = true;
        status.hidden = false;
        status.textContent = labels.error;
        zoomButton.disabled = true;
    });
    photos.forEach((link, index) => link.addEventListener('click', event => {
        if (event.button !== 0 || event.ctrlKey || event.metaKey || event.shiftKey || event.altKey) return;
        event.preventDefault();
        opener = link;
        show(index);
        document.documentElement.classList.add('gallery-lightbox-open');
        dialog.showModal();
        closeButton.focus({ preventScroll: true });
    }));
    closeButton.addEventListener('click', () => dialog.close());
    dialog.addEventListener('close', () => {
        document.documentElement.classList.remove('gallery-lightbox-open');
        opener?.focus({ preventScroll: true });
    });
    dialog.addEventListener('keydown', event => {
        if (zoomed) return;
        if (event.key === 'ArrowRight' || event.key === 'ArrowLeft') {
            event.preventDefault();
            show(active + (event.key === 'ArrowRight' ? 1 : -1));
        }
    });
    previousButton.hidden = nextButton.hidden = photos.length < 2;
    previousButton.addEventListener('click', () => show(active - 1));
    nextButton.addEventListener('click', () => show(active + 1));
    zoomButton.addEventListener('click', () => setZoom(!zoomed));
    image.addEventListener('click', () => setZoom(!zoomed));
    stage.addEventListener('click', event => {
        if (event.target === stage && !zoomed) dialog.close();
    });
}
