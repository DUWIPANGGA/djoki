<style>
    /* Critical UI — tidak bergantung pada build Tailwind/Vite */
    #page-loader {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 9999;
        align-items: center;
        justify-content: center;
        background: #0f172a;
    }

    #page-loader.is-loading {
        display: flex;
    }

    #page-loader .page-loader__inner {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
        text-align: center;
        padding: 1.5rem;
    }

    #page-loader .page-loader__spinner {
        width: 3rem;
        height: 3rem;
        border-radius: 9999px;
        border: 2px solid rgba(255, 255, 255, 0.1);
        border-top-color: #6366f1;
        animation: djoki-spin 0.8s linear infinite;
    }

    #page-loader .page-loader__brand {
        font-size: 1.5rem;
        font-weight: 700;
        background: linear-gradient(to right, #818cf8, #c084fc);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    #page-loader .page-loader__text {
        font-size: 0.875rem;
        color: #94a3b8;
    }

    @keyframes djoki-spin {
        to { transform: rotate(360deg); }
    }

    /* Default: sembunyikan kontrol mobile */
    #sidebar-toggle,
    #sidebar-close {
        display: none !important;
    }

    #sidebar-backdrop {
        display: none !important;
    }

    /* Desktop */
    @media (min-width: 1024px) {
        #sidebar {
            position: sticky;
            top: 0;
            height: 100dvh;
            flex-shrink: 0;
            width: 18rem;
            transform: none;
        }
    }

    /* Mobile & tablet: drawer */
    @media (max-width: 1023px) {
        #sidebar-toggle {
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
        }

        #sidebar-close {
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 60;
            cursor: pointer;
            -webkit-tap-highlight-color: transparent;
        }

        #sidebar {
            position: fixed;
            inset-block: 0;
            left: 0;
            z-index: 50;
            width: 18rem;
            max-width: 85vw;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            will-change: transform;
        }

        #sidebar.is-open {
            transform: translateX(0);
        }

        #sidebar-backdrop.is-visible {
            display: block !important;
            position: fixed;
            inset: 0;
            z-index: 40;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            cursor: pointer;
        }

        body.sidebar-drawer-open {
            overflow: hidden;
        }
    }
</style>
