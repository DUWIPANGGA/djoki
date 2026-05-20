<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const DESKTOP = 1024;

    const loader = document.getElementById('page-loader');
    const sidebar = document.getElementById('sidebar');
    const backdrop = document.getElementById('sidebar-backdrop');
    const toggleBtn = document.getElementById('sidebar-toggle');
    const closeBtn = document.getElementById('sidebar-close');

    function isMobile() {
        return window.innerWidth < DESKTOP;
    }

    if (loader) {
        const showLoader = () => loader.classList.add('is-loading');
        const hideLoader = () => loader.classList.remove('is-loading');

        hideLoader();

        document.addEventListener('click', function (e) {
            const link = e.target.closest('a[href]');
            if (!link || link.target === '_blank' || link.hasAttribute('download')) return;
            const href = link.getAttribute('href');
            if (!href || href.startsWith('#') || href.startsWith('javascript:') || href.startsWith('mailto:') || href.startsWith('tel:')) return;
            try {
                if (new URL(link.href, window.location.origin).origin !== window.location.origin) return;
            } catch (_) { return; }
            showLoader();
        });

        document.addEventListener('submit', function (e) {
            if (e.target instanceof HTMLFormElement && e.target.target !== '_blank') showLoader();
        });

        window.addEventListener('load', hideLoader);
        window.addEventListener('pageshow', hideLoader);
    }

    if (!sidebar) return;

    function setExpanded(open) {
        if (toggleBtn) toggleBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
    }

    function openSidebar() {
        if (!isMobile()) return;
        sidebar.classList.add('is-open');
        if (backdrop) backdrop.classList.add('is-visible');
        document.body.classList.add('sidebar-drawer-open');
        setExpanded(true);
    }

    function closeSidebar(e) {
        if (e) {
            e.preventDefault();
            e.stopPropagation();
        }
        sidebar.classList.remove('is-open');
        if (backdrop) backdrop.classList.remove('is-visible');
        document.body.classList.remove('sidebar-drawer-open');
        setExpanded(false);
    }

    function syncViewport() {
        if (!isMobile()) closeSidebar();
    }

    if (toggleBtn) {
        toggleBtn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            openSidebar();
        });
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', closeSidebar);
        closeBtn.addEventListener('touchend', function (e) {
            e.preventDefault();
            closeSidebar(e);
        }, { passive: false });
    }

    if (backdrop) {
        backdrop.addEventListener('click', closeSidebar);
    }

    sidebar.addEventListener('click', function (e) {
        if (e.target.closest('#sidebar-close')) {
            closeSidebar(e);
        }
    });

    sidebar.querySelectorAll('nav a').forEach(function (link) {
        link.addEventListener('click', function () {
            if (isMobile()) closeSidebar();
        });
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && sidebar.classList.contains('is-open')) {
            closeSidebar();
        }
    });

    window.addEventListener('resize', syncViewport);
    syncViewport();
});
</script>
