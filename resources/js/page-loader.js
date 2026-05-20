export function initPageLoader() {
    const loader = document.getElementById('page-loader');
    if (!loader) {
        return;
    }

    const show = () => loader.classList.add('is-loading');
    const hide = () => loader.classList.remove('is-loading');

    document.addEventListener('click', (event) => {
        const link = event.target.closest('a[href]');
        if (!link || link.target === '_blank' || link.hasAttribute('download')) {
            return;
        }

        const href = link.getAttribute('href');
        if (!href || href.startsWith('#') || href.startsWith('javascript:')) {
            return;
        }

        if (href.startsWith('mailto:') || href.startsWith('tel:')) {
            return;
        }

        let url;
        try {
            url = new URL(link.href, window.location.origin);
        } catch {
            return;
        }

        if (url.origin !== window.location.origin) {
            return;
        }

        show();
    });

    document.addEventListener('submit', (event) => {
        const form = event.target;
        if (form instanceof HTMLFormElement && form.target !== '_blank') {
            show();
        }
    });

    window.addEventListener('pageshow', () => hide());
    window.addEventListener('load', () => hide());
    hide();
}

document.addEventListener('DOMContentLoaded', initPageLoader);
