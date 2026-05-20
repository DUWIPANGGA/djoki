const DESKTOP_BREAKPOINT = 1024;

export function initSidebar() {
    const sidebar = document.getElementById('sidebar');
    const backdrop = document.getElementById('sidebar-backdrop');
    const toggleBtn = document.getElementById('sidebar-toggle');
    const closeBtn = document.getElementById('sidebar-close');

    if (!sidebar) {
        return;
    }

    function isMobileViewport() {
        return window.innerWidth < DESKTOP_BREAKPOINT;
    }

    function setToggleExpanded(expanded) {
        toggleBtn?.setAttribute('aria-expanded', expanded ? 'true' : 'false');
    }

    function openSidebar() {
        if (!isMobileViewport()) {
            return;
        }
        sidebar.classList.add('is-open');
        backdrop?.classList.add('is-visible');
        document.body.classList.add('overflow-hidden');
        setToggleExpanded(true);
    }

    function closeSidebar() {
        sidebar.classList.remove('is-open');
        backdrop?.classList.remove('is-visible');
        document.body.classList.remove('overflow-hidden');
        setToggleExpanded(false);
    }

    function syncSidebarForViewport() {
        if (!isMobileViewport()) {
            closeSidebar();
        }
    }

    toggleBtn?.addEventListener('click', openSidebar);
    closeBtn?.addEventListener('click', closeSidebar);
    backdrop?.addEventListener('click', closeSidebar);

    sidebar.querySelectorAll('nav a').forEach((link) => {
        link.addEventListener('click', () => {
            if (isMobileViewport()) {
                closeSidebar();
            }
        });
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeSidebar();
        }
    });

    window.addEventListener('resize', syncSidebarForViewport);
    syncSidebarForViewport();
}

document.addEventListener('DOMContentLoaded', initSidebar);
