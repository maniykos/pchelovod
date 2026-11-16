// Browser integration check. Pass a Playwright Page and the running site's URL.
export default async function checkGalleryLightbox(page, baseURL = 'http://127.0.0.1:8000') {
    const checks = [];
    const check = (condition, description) => {
        if (!condition) throw new Error(description);
        checks.push(description);
    };

    await page.setViewportSize({ width: 1280, height: 900 });
    await page.goto(`${baseURL}/gallery`);
    const photos = page.locator('.gallery-item img');
    const count = await photos.count();
    check(count > 0, 'Gallery contains a photograph to open');
    const firstSource = await photos.first().getAttribute('src');
    await photos.first().scrollIntoViewIfNeeded();
    const scrollBefore = await page.evaluate(() => window.scrollY);
    await photos.first().click();
    const dialog = page.locator('dialog.gallery-lightbox[open]');
    await dialog.waitFor({ state: 'visible', timeout: 3000 });
    const image = dialog.locator('.gallery-lightbox__image');
    await image.evaluate(img => img.decode());
    check(await image.getAttribute('src') === new URL(firstSource, baseURL).href, 'Opening a thumbnail displays its original file');

    const fitted = await image.evaluate(img => ({
        width: img.getBoundingClientRect().width,
        height: img.getBoundingClientRect().height,
        stageWidth: img.parentElement.clientWidth,
        stageHeight: img.parentElement.clientHeight,
    }));
    check(fitted.width <= fitted.stageWidth && fitted.height <= fitted.stageHeight, 'Fit mode shows the complete photo within the viewer');
    await dialog.locator('[data-gallery-zoom]').click();
    const actual = await image.evaluate(img => ({
        width: img.getBoundingClientRect().width,
        height: img.getBoundingClientRect().height,
        naturalWidth: img.naturalWidth,
        naturalHeight: img.naturalHeight,
    }));
    check(Math.abs(actual.width - actual.naturalWidth) < 1 && Math.abs(actual.height - actual.naturalHeight) < 1, '100% mode uses the original pixel dimensions');
    check(await dialog.locator('[data-gallery-zoom]').getAttribute('aria-pressed') === 'true', 'Zoom state is exposed to keyboard and screen-reader users');
    await dialog.locator('[data-gallery-zoom]').click();
    check(await dialog.locator('[data-gallery-zoom]').getAttribute('aria-pressed') === 'false', 'Fit mode can be restored');

    if (count > 1) {
        const secondSource = await photos.nth(1).getAttribute('src');
        await page.keyboard.press('ArrowRight');
        await image.evaluate(img => img.decode());
        check(await image.getAttribute('src') === new URL(secondSource, baseURL).href, 'Right arrow opens the next photograph');
        await page.keyboard.press('ArrowLeft');
        await image.evaluate(img => img.decode());
        check(await image.getAttribute('src') === new URL(firstSource, baseURL).href, 'Left arrow returns to the previous photograph');
    }

    await page.keyboard.press('Escape');
    await dialog.waitFor({ state: 'hidden' });
    check(await page.locator('[data-gallery-photo]').first().evaluate(link => document.activeElement === link), 'Closing restores focus to the photograph that opened the viewer');
    check(await page.evaluate(() => !document.documentElement.classList.contains('gallery-lightbox-open')), 'Closing restores page scrolling');
    check(Math.abs(await page.evaluate(() => window.scrollY) - scrollBefore) < 2, 'Closing preserves the gallery scroll position');

    await page.locator('[data-gallery-photo]').first().focus();
    await page.keyboard.press('Enter');
    await dialog.waitFor({ state: 'visible' });
    await dialog.locator('[data-gallery-close]').click();
    await dialog.waitFor({ state: 'hidden' });
    check(await page.locator('dialog.gallery-lightbox[open]').count() === 0, 'Photos open from the keyboard and close using the close button');

    await page.setViewportSize({ width: 390, height: 844 });
    await photos.first().click();
    await dialog.waitFor({ state: 'visible' });
    await image.evaluate(img => img.decode());
    await dialog.locator('[data-gallery-zoom]').click();
    const mobile = await image.evaluate(img => {
        const stage = img.parentElement;
        stage.scrollLeft = stage.scrollWidth;
        return {
            width: img.getBoundingClientRect().width,
            naturalWidth: img.naturalWidth,
            widerThanViewport: img.naturalWidth > stage.clientWidth,
            scrolled: stage.scrollLeft > 0,
            pageOverflow: document.documentElement.scrollWidth > window.innerWidth,
        };
    });
    check(Math.abs(mobile.width - mobile.naturalWidth) < 1, 'Mobile 100% mode keeps original image dimensions');
    check(!mobile.widerThanViewport || mobile.scrolled, 'Large mobile photographs can be panned horizontally');
    check(!mobile.pageOverflow, 'The viewer does not widen the mobile page');
    await page.keyboard.press('Escape');
    await dialog.waitFor({ state: 'hidden' });
    if (await page.locator('.gallery-item video').count()) {
        await page.locator('.gallery-item video').first().click();
        check(await page.locator('dialog.gallery-lightbox[open]').count() === 0, 'Video clicks keep the native player instead of opening the photo viewer');
        await page.locator('.gallery-item video').first().evaluate(video => video.pause());
    }
    return { passed: checks.length, checks };
}
