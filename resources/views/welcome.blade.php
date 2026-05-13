<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>D'JOKI — Premium IT Services Platform</title>
    <!-- Font Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg);
            color: var(--text);
            line-height: 1.5;
            scroll-behavior: smooth;
            overflow-x: hidden;
        }

        :root {
            --primary: #B79CED;
            /* Purple */
            --secondary: #A3D977;
            /* Green */
            --accent: #E9B949;
            /* Orange */
            --bg: #0F172A;
            --card: #1E293B;
            --text: #F8FAFC;
            --muted: #94A3B8;
            --border: #334155;
            --glow-purple: rgba(183, 156, 237, 0.2);
            --glow-green: rgba(163, 217, 119, 0.15);
        }

        /* Playful abstract backgrounds & shapes */
        .shape-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -2;
            overflow: hidden;
            pointer-events: none;
        }

        .shape {
            position: absolute;
            background: radial-gradient(circle, rgba(183, 156, 237, 0.2) 0%, rgba(183, 156, 237, 0) 70%);
            border-radius: 50%;
            filter: blur(60px);
        }

        .shape-1 {
            width: 500px;
            height: 500px;
            top: -150px;
            left: -150px;
            background: radial-gradient(circle, var(--primary) 0%, transparent 70%);
            opacity: 0.3;
        }

        .shape-2 {
            width: 600px;
            height: 600px;
            bottom: -200px;
            right: -200px;
            background: radial-gradient(circle, var(--secondary) 0%, transparent 70%);
            opacity: 0.2;
        }

        .shape-3 {
            width: 400px;
            height: 400px;
            top: 40%;
            left: 70%;
            background: radial-gradient(circle, var(--accent) 0%, transparent 70%);
            opacity: 0.15;
        }

        /* abstract wavy lines */
        .wave-line {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 120px;
            background: repeating-linear-gradient(45deg, transparent, transparent 40px, rgba(183, 156, 237, 0.15) 40px, rgba(183, 156, 237, 0.15) 80px);
            pointer-events: none;
        }

        .grid-dots {
            background-image: radial-gradient(var(--muted) 1px, transparent 1px);
            background-size: 30px 30px;
            opacity: 0.1;
            position: fixed;
            inset: 0;
            z-index: -1;
        }

        /* container */
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* navbar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 24px 0;
            flex-wrap: wrap;
            gap: 16px;
        }

        .logo {
            font-size: 28px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            letter-spacing: -0.5px;
        }

        .logo span {
            background: none;
            -webkit-background-clip: unset;
            color: var(--text);
        }

        .nav-links {
            display: flex;
            gap: 32px;
            align-items: center;
        }

        .nav-links a {
            color: var(--muted);
            text-decoration: none;
            font-weight: 600;
            transition: 0.2s;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .btn {
            padding: 12px 28px;
            border-radius: 40px;
            font-weight: 700;
            transition: all 0.2s ease;
            cursor: pointer;
            border: none;
            font-family: inherit;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none !important;
        }

        .btn-primary {
            background: linear-gradient(135deg, #B79CED 0%, #9066E5 100%);
            color: white;
            box-shadow: 0 8px 20px rgba(183, 156, 237, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            filter: brightness(1.1);
            box-shadow: 0 12px 28px rgba(183, 156, 237, 0.5);
        }

        .btn-outline {
            background: transparent;
            border: 1.5px solid var(--primary);
            color: var(--primary);
        }

        .btn-outline:hover {
            background: rgba(183, 156, 237, 0.1);
            transform: translateY(-2px);
        }

        .hero {
            padding: 60px 0 80px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 48px;
        }

        .hero-content {
            flex: 1;
        }

        .hero-badge {
            background: rgba(183, 156, 237, 0.2);
            width: fit-content;
            padding: 6px 16px;
            border-radius: 60px;
            font-size: 14px;
            font-weight: 600;
            color: var(--primary);
            border: 1px solid rgba(183, 156, 237, 0.4);
            margin-bottom: 24px;
            backdrop-filter: blur(4px);
        }

        .hero h1 {
            font-size: 56px;
            font-weight: 800;
            line-height: 1.2;
            letter-spacing: -1.5px;
            margin-bottom: 24px;
        }

        .hero-gradient-text {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .hero p {
            font-size: 18px;
            color: var(--muted);
            margin-bottom: 32px;
            max-width: 500px;
        }

        .hero-buttons {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }

        .hero-stats {
            display: flex;
            gap: 32px;
            margin-top: 48px;
            flex-wrap: wrap;
        }

        .stat-item h3 {
            font-size: 28px;
            font-weight: 800;
            color: var(--secondary);
        }

        .stat-item p {
            font-size: 14px;
            color: var(--muted);
            margin-bottom: 0;
        }

        .hero-visual {
            flex: 1;
            position: relative;
            min-height: 400px;
            display: flex;
            justify-content: center;
        }

        .card-float {
            background: var(--card);
            backdrop-filter: blur(10px);
            border-radius: 32px;
            padding: 20px;
            width: 280px;
            box-shadow: 0 25px 40px -12px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.05);
            position: absolute;
            transition: transform 0.3s ease;
        }

        .card-float-1 {
            top: 20px;
            left: 0;
            transform: rotate(-5deg);
        }

        .card-float-2 {
            bottom: 40px;
            right: 0;
            transform: rotate(6deg);
            background: rgba(30, 41, 59, 0.9);
        }

        .card-float-3 {
            top: 50%;
            left: 30%;
            transform: translateY(-50%) rotate(2deg);
            background: rgba(30, 41, 59, 0.8);
        }

        .float-icon {
            font-size: 32px;
            margin-bottom: 12px;
        }

        .trust-badge {
            display: flex;
            gap: 24px;
            flex-wrap: wrap;
            justify-content: center;
            margin: 40px 0;
            padding: 20px 0;
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }

        .badge-item {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, 0.03);
            padding: 8px 24px;
            border-radius: 80px;
            backdrop-filter: blur(4px);
        }

        .section-title {
            text-align: center;
            font-size: 40px;
            font-weight: 700;
            margin-bottom: 16px;
        }

        .section-sub {
            text-align: center;
            color: var(--muted);
            max-width: 600px;
            margin: 0 auto 48px;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 32px;
            margin: 48px 0;
        }

        .service-card {
            background: var(--card);
            border-radius: 32px;
            padding: 32px 24px;
            transition: all 0.25s;
            border: 1px solid rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(8px);
        }

        .service-card:hover {
            transform: translateY(-6px);
            border-color: var(--primary);
            box-shadow: 0 20px 30px -15px rgba(183, 156, 237, 0.2);
        }

        .service-icon {
            width: 56px;
            height: 56px;
            background: rgba(183, 156, 237, 0.2);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            margin-bottom: 24px;
        }

        .service-card h3 {
            font-size: 24px;
            margin-bottom: 12px;
        }

        .service-card p {
            color: var(--muted);
        }

        .why-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 28px;
            margin: 48px 0;
        }

        .why-card {
            background: rgba(30, 41, 59, 0.6);
            border-radius: 28px;
            padding: 28px;
            text-align: center;
            transition: 0.2s;
            border: 1px solid rgba(255, 255, 255, 0.03);
        }

        .why-card:hover {
            background: var(--card);
            border-color: var(--secondary);
        }

        .why-emoji {
            font-size: 44px;
            margin-bottom: 20px;
        }

        .pricing-card {
            background: var(--card);
            border-radius: 36px;
            padding: 32px;
            text-align: center;
            border: 1px solid var(--border);
        }

        .flex-cards {
            display: flex;
            flex-wrap: wrap;
            gap: 32px;
            justify-content: center;
            margin: 40px 0;
        }

        .flex-cards .pricing-card {
            flex: 1;
            min-width: 240px;
        }

        .price {
            font-size: 42px;
            font-weight: 800;
            color: var(--primary);
            margin: 20px 0;
        }

        .testimonial-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 32px;
            margin: 56px 0;
        }

        .testimonial {
            background: var(--card);
            border-radius: 28px;
            padding: 28px;
            border: 1px solid var(--border);
        }

        .testimonial p {
            font-style: italic;
            margin-bottom: 20px;
        }

        .avatar {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar-img {
            width: 48px;
            height: 48px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .faq-item {
            background: var(--card);
            margin-bottom: 16px;
            border-radius: 24px;
            padding: 20px 28px;
            cursor: pointer;
        }

        .faq-question {
            font-weight: 700;
            display: flex;
            justify-content: space-between;
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: 0.3s;
            color: var(--muted);
            margin-top: 12px;
        }

        .faq-item.active .faq-answer {
            max-height: 200px;
        }

        footer {
            text-align: center;
            padding: 48px 0 32px;
            border-top: 1px solid var(--border);
            margin-top: 64px;
            color: var(--muted);
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 40px;
            }

            .navbar {
                flex-direction: column;
            }

            .hero-visual {
                display: none;
            }

            .container {
                padding: 0 20px;
            }

            .section-title {
                font-size: 32px;
            }
        }

        .btn-small {
            padding: 8px 20px;
            font-size: 14px;
        }

        .blob {
            position: absolute;
            width: 300px;
            height: 300px;
            background: var(--glow-purple);
            filter: blur(80px);
            border-radius: 60% 40% 70% 30%;
            z-index: -1;
        }
    </style>
</head>

<body>

    <div class="shape-bg">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
        <div class="grid-dots"></div>
    </div>

    <div class="container">
        <!-- Navbar -->
        <nav class="navbar">
            <a href="/" class="logo" style="text-decoration: none;">D'JOKI<span>.</span></a>
            <div class="nav-links">
                <a href="#layanan">Layanan</a>
                <a href="#trust">Trust</a>
                <a href="{{ route('policy') }}">Policy</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-outline btn-small">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline btn-small">Login</a>
                @endauth
                <a href="{{ route('layanan.index') }}" class="btn btn-primary btn-small">Start Project</a>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="hero">
            <div class="hero-content">
                <div class="hero-badge">
                    100% Confidential & Premium
                </div>
                <h1>
                    IT Services With <span class="hero-gradient-text">Privacy & Speed</span>
                </h1>
                <p>
                    D'JOKI membantu project IT Anda selesai lebih cepat, aman, dan professional. Didukung provider
                    terverifikasi dan sistem anti bocor.
                </p>
                <div class="hero-buttons">
                    <a href="{{ route('layanan.index') }}" class="btn btn-primary">Mulai Project →</a>
                    <a href="{{ route('layanan.index') }}" class="btn btn-outline">Lihat Layanan</a>
                </div>
                <div class="hero-stats">
                    <div class="stat-item">
                        <h3>500+</h3>
                        <p>Projects Completed</p>
                    </div>
                    <div class="stat-item">
                        <h3>98%</h3>
                        <p>Satisfaction Rate</p>
                    </div>
                    <div class="stat-item">
                        <h3>&lt;5 min</h3>
                        <p>Avg Response</p>
                    </div>
                    <div class="stat-item">
                        <h3>100%</h3>
                        <p>Confidential</p>
                    </div>
                </div>
            </div>
            <div class="hero-visual">
                <div class="card-float card-float-1">
                    <div class="float-icon">🔒</div>
                    <strong>Private Storage</strong>
                    <div style="font-size:12px">AES-256 encrypted</div>
                </div>
                <div class="card-float card-float-2">
                    <div class="float-icon">⚡</div>
                    <strong>Express 2 days</strong>
                    <div style="font-size:12px">Urgent mode ready</div>
                </div>
                <div class="card-float card-float-3">
                    <div class="float-icon">💎</div>
                    <strong>Quality Guarantee</strong>
                    <div style="font-size:12px">Free 2x revisi</div>
                </div>
            </div>
        </div>

        <!-- Quick Order Shortcut -->
        <div class="quick-order-section" id="order-now" style="margin-bottom: 80px;">
            <div class="glass p-8 md:p-12 rounded-[48px] border border-white/10 relative overflow-hidden">
                <div class="blob" style="top: -100px; right: -100px; opacity: 0.1;"></div>
                <div class="blob" style="bottom: -100px; left: -100px; background: var(--glow-green); opacity: 0.1;">
                </div>

                <div
                    style="display: flex; flex-wrap: wrap; gap: 48px; align-items: center; position: relative; z-index: 1;">
                    <div style="flex: 1; min-width: 300px;">
                        <div class="hero-badge"
                            style="background: rgba(163, 217, 119, 0.2); color: var(--secondary); border-color: rgba(163, 217, 119, 0.4);">
                            Fast Checkout
                        </div>
                        <h2 style="font-size: 32px; font-weight: 800; margin-bottom: 16px;">Punya Project Mendadak?</h2>
                        <p style="color: var(--muted); margin-bottom: 24px;">Isi detail singkat di samping, dan sistem
                            kami akan langsung mencarikan provider terbaik untuk Anda. Aman & Terenkripsi.</p>

                        <div style="display: flex; flex-direction: column; gap: 16px;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div
                                    style="width: 32px; height: 32px; border-radius: 50%; background: var(--primary); color: #0F172A; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 14px;">
                                    1</div>
                                <span style="font-weight: 600;">Isi Detail Singkat</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div
                                    style="width: 32px; height: 32px; border-radius: 50%; background: var(--secondary); color: #0F172A; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 14px;">
                                    2</div>
                                <span style="font-weight: 600;">Login & Konfirmasi</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div
                                    style="width: 32px; height: 32px; border-radius: 50%; background: var(--accent); color: #0F172A; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 14px;">
                                    3</div>
                                <span style="font-weight: 600;">Project Dimulai!</span>
                            </div>
                        </div>
                    </div>

                    <div
                        style="flex: 1.2; min-width: 300px; background: rgba(15, 23, 42, 0.5); padding: 32px; border-radius: 32px; border: 1px solid rgba(255,255,255,0.05);">
                        <form action="{{ route('orders.create') }}" method="GET" class="space-y-4">
                            <div style="margin-bottom: 20px;">
                                <label
                                    style="display: block; font-size: 14px; font-weight: 600; color: var(--muted); margin-bottom: 8px;">Judul
                                    Project / Tugas</label>
                                <input type="text" name="title" required
                                    placeholder="Contoh: Landing Page Toko Sepatu"
                                    style="width: 100%; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; padding: 14px 20px; color: white; font-family: inherit;">
                            </div>

                            <div style="margin-bottom: 20px;">
                                <label
                                    style="display: block; font-size: 14px; font-weight: 600; color: var(--muted); margin-bottom: 8px;">Kategori
                                    Layanan</label>
                                <select name="category_id" required
                                    style="width: 100%; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; padding: 14px 20px; color: white; font-family: inherit; appearance: none;">
                                    <option value="" disabled selected>Pilih Kategori...</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}" style="background: var(--bg);">
                                            {{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div style="margin-bottom: 24px;">
                                <label
                                    style="display: block; font-size: 14px; font-weight: 600; color: var(--muted); margin-bottom: 8px;">Deskripsi
                                    Singkat</label>
                                <textarea name="description" placeholder="Ceritakan apa yang Anda butuhkan..." rows="3"
                                    style="width: 100%; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; padding: 14px 20px; color: white; font-family: inherit; resize: none;"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary"
                                style="width: 100%; justify-content: center; padding: 16px;">
                                Lanjutkan Pemesanan
                            </button>

                            <p style="font-size: 11px; color: var(--muted); text-align: center; margin-top: 16px;">
                                * Anda akan diminta login otomatis menggunakan Google/GitHub jika belum masuk.
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Trust Badges / Feature Highlights -->
        <div class="trust-badge" id="trust">
            <div class="badge-item">100% Confidential Project</div>
            <div class="badge-item">Avg. Response < 5 Minutes</div>
            <div class="badge-item">Verified Providers</div>
            <div class="badge-item">Secure Payment Gateway</div>
            <div class="badge-item">Real-time Chat</div>
        </div>

            <!-- Service Categories -->
            <div class="services" id="layanan">
                <h2 class="section-title">Premium Services <span style="color: var(--accent);">For Serious
                        Projects</span></h2>
                <div class="section-sub">Pengerjaan cepat, rapi, dan hasil standar enterprise</div>
                <div class="services-grid">
                    <div class="service-card">
                        <div class="service-icon"></div>
                        <h3>Landing Page</h3>
                        <p>High-converting, modern design, responsive. 2-3 Days</p>
                        <div style="margin-top:18px"><a href="{{ route('layanan.index') }}"
                                class="btn btn-outline btn-small">Start From Rp350K</a></div>
                    </div>
                    <div class="service-card">
                        <div class="service-icon"></div>
                        <h3>Backend API</h3>
                        <p>Laravel, Node.js, database architecture. 5-7 Days</p>
                        <div style="margin-top:18px"><a href="{{ route('layanan.index') }}"
                                class="btn btn-outline btn-small">Negotiable</a></div>
                    </div>
                    <div class="service-card">
                        <div class="service-icon"></div>
                        <h3>Mobile App</h3>
                        <p>Flutter, React Native, full support. 10-14 Days</p>
                        <div style="margin-top:18px"><a href="{{ route('layanan.index') }}"
                                class="btn btn-outline btn-small">Custom Quote</a></div>
                    </div>
                    <div class="service-card">
                        <div class="service-icon"></div>
                        <h3>Bug Fix & Maintenance</h3>
                        <p>Fast debugging, server maintenance. 1-2 Days</p>
                        <div style="margin-top:18px"><a href="{{ route('layanan.index') }}"
                                class="btn btn-outline btn-small">DP 30%</a></div>
                    </div>
                    <div class="service-card">
                        <div class="service-icon"></div>
                        <h3>Joki Tugas IT</h3>
                        <p>Coding, paper, algorithm, assignment help. 2-4 Days</p>
                        <div style="margin-top:18px"><a href="{{ route('layanan.index') }}"
                                class="btn btn-outline btn-small">Mulai Rp150K</a></div>
                    </div>
                    <div class="service-card">
                        <div class="service-icon"></div>
                        <h3>Joki Tugas Kilat</h3>
                        <p>Express service for urgent deadlines. < 24 Hours</p>
                        <div style="margin-top:18px"><a href="{{ route('layanan.index') }}"
                                class="btn btn-outline btn-small">Express Price</a></div>
                    </div>
                    <div class="service-card">
                        <div class="service-icon"></div>
                        <h3>UI/UX (Figma)</h3>
                        <p>Prototyping, high-fidelity design, assets. 3-5 Days</p>
                        <div style="margin-top:18px"><a href="{{ route('layanan.index') }}"
                                class="btn btn-outline btn-small">Negotiable</a></div>
                    </div>
                    <div class="service-card">
                        <div class="service-icon"></div>
                        <h3>Database Architecture</h3>
                        <p>Optimization, SQL/NoSQL, normalization. 4-6 Days</p>
                        <div style="margin-top:18px"><a href="{{ route('layanan.index') }}"
                                class="btn btn-outline btn-small">Start Rp500K</a></div>
                    </div>
                </div>
            </div>

            <!-- Why D'JOKI (Neo Memphis / playful) -->
            <div>
                <h2 class="section-title">Why <span style="color: var(--secondary);">D'JOKI?</span></h2>
                <div class="section-sub">Trust, Speed, Privacy — bukan sekedar joki biasa</div>
                <div class="why-grid">
                    <div class="why-card">
                        <div class="why-emoji"></div>
                        <h3>Privacy Guaranteed</h3>
                        <p>Identitas Anda anonim. Tidak ada yang akan tahu Anda menggunakan jasa kami. Data & file dijamin aman.</p>
                    </div>
                    <div class="why-card">
                        <div class="why-emoji"></div>
                        <h3>Fast Execution</h3>
                        <p>Pengerjaan tepat waktu, estimasi akurat, realtime progress.</p>
                    </div>
                    <div class="why-card">
                        <div class="why-emoji"></div>
                        <h3>Trusted Providers</h3>
                        <p>100% terverifikasi, portfolio nyata, rating transparan.</p>
                    </div>
                    <div class="why-card">
                        <div class="why-emoji"></div>
                        <h3>Premium Quality</h3>
                        <p>Code bersih, dokumentasi rapi, standar tinggi.</p>
                    </div>
                    <div class="why-card">
                        <div class="why-emoji"></div>
                        <h3>Live Communication</h3>
                        <p>Chat real-time dengan provider, update setiap milestone.</p>
                    </div>
                    <div class="why-card">
                        <div class="why-emoji"></div>
                        <h3>Flexible Payment</h3>
                        <p>DP, full payment, atau negotiable — sesuai kebutuhanmu.</p>
                    </div>
                </div>
            </div>

            <!-- Pricing options highlight -->
            <div
                style="background: linear-gradient(135deg, rgba(30,41,59,0.6), rgba(15,23,42,0.9)); border-radius: 48px; padding: 40px 24px; margin: 48px 0;">
                <h2 class="section-title" style="margin-bottom: 8px;">Flexible Pricing <span
                        style="color: var(--accent);">For Everyone</span></h2>
                <div class="flex-cards">
                    <div class="pricing-card">
                        <h3>Fixed Price</h3>
                        <div class="price">Mulai Rp250K</div>
                        <p>Langsung checkout, estimasi tetap, tanpa drama</p>
                        <a href="{{ route('layanan.index') }}" class="btn btn-outline"
                            style="margin-top:16px;">Pilih Layanan</a>
                    </div>
                    <div class="pricing-card">
                        <h3>DP 30%</h3>
                        <div class="price">Bayar Bertahap</div>
                        <p>Proyek besar, down payment ringan, sisanya setelah selesai</p>
                        <a href="{{ route('layanan.index') }}" class="btn btn-outline"
                            style="margin-top:16px;">Mulai Negosiasi</a>
                    </div>
                    <div class="pricing-card">
                        <h3>Custom / Negotiable</h3>
                        <div class="price">Diskusi dulu</div>
                        <p>Budget belum fix? Konsultasi gratis, dapatkan harga terbaik</p>
                        <a href="https://wa.me/6285956404789" target="_blank" class="btn btn-outline"
                            style="margin-top:16px;">Konsultasi Gratis</a>
                    </div>
                </div>
            </div>

            <!-- Testimonials -->
            <div>
                <h2 class="section-title">Trusted by <span style="color: var(--primary);">Students & Business</span>
                </h2>
                <div class="testimonial-grid">
                    <div class="testimonial">
                        <p>"Proses super cepat dan hasilnya rapi. Saya dapat source code bersih, dan privasi terjamin.
                            Rekomendasi!"</p>
                        <div class="avatar">
                            <div class="avatar-img">R</div>
                            <div><strong>Rina</strong>
                                <div>Mahasiswa Informatika</div>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial">
                        <p>"Butuh API mendadak untuk skripsi, D'JOKI bantu dalam 2 hari. Komunikasi via chat realtime,
                            mantap!"</p>
                        <div class="avatar">
                            <div class="avatar-img">A</div>
                            <div><strong>Adi</strong>
                                <div>Fresh Graduate</div>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial">
                        <p>"Platform premium, provider terverifikasi, file dienkripsi. Saya tidak khawatir source code
                            bocor."</p>
                        <div class="avatar">
                            <div class="avatar-img">S</div>
                            <div><strong>Sari</strong>
                                <div>Startup Owner</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ Simple -->
            <div>
                <h2 class="section-title">Pertanyaan Umum</h2>
                <div class="faq-list">
                    <div class="faq-item">
                        <div class="faq-question">Bagaimana jika hasil tidak sesuai (Revisi)? <span>+</span></div>
                        <div class="faq-answer">Setiap pesanan memiliki jatah minimal 2x revisi gratis. Anda bisa meminta perbaikan melalui fitur chat atau tombol revisi di dashboard sebelum menyetujui pekerjaan.</div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question">Bagaimana sistem persetujuan & masa sanggah? <span>+</span></div>
                        <div class="faq-answer">Setelah provider mengirim hasil akhir, Anda memiliki waktu 48 jam (Masa Sanggah) untuk memeriksa hasil. Jika dalam 48 jam tidak ada komplain, sistem akan otomatis menganggap pesanan selesai dan melepaskan dana.</div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question">Apakah kerahasiaan saya terjamin? <span>+</span></div>
                        <div class="faq-answer">Sangat terjamin. Kami mengutamakan privasi penuh sehingga tidak ada pihak luar yang akan tahu Anda menggunakan jasa D'JOKI. File dienkripsi dan provider terikat kontrak kerahasiaan ketat.</div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question">Berapa lama estimasi pengerjaan?<span>+</span></div>
                        <div class="faq-answer">Mulai dari 2 hari untuk landing page, hingga 2 minggu untuk aplikasi
                            besar. Anda bisa pilih layanan express dengan biaya tambahan.</div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question">Bagaimana metode pembayaran?<span>+</span></div>
                        <div class="faq-answer">Pembayaran dilakukan via transfer bank atau e-wallet (QRIS) secara aman setelah detail project disepakati.</div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question">Apakah provider benar-benar terverifikasi?<span>+</span></div>
                        <div class="faq-answer">Setiap provider melalui verifikasi dokumen, portofolio, dan rating
                            transparan. Anda bisa melihat statistik penyelesaian mereka.</div>
                    </div>
                </div>
            </div>

            <!-- CTA Banner -->
            <div
                style="background: linear-gradient(110deg, rgba(183,156,237,0.2), rgba(163,217,119,0.1)); border-radius: 48px; padding: 56px 32px; text-align: center; margin: 64px 0;">
                <h2 style="font-size: 36px;">Siap wujudkan project IT Anda?</h2>
                <p style="color: var(--muted); max-width: 500px; margin: 16px auto;">Aman, cepat, dan hasil premium
                    tanpa ribet.</p>
                <div style="display: flex; gap: 20px; justify-content: center; margin-top: 32px; flex-wrap: wrap;">
                    <a href="{{ route('layanan.index') }}" class="btn btn-primary">Mulai Project Sekarang</a>
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-outline">Login Sosial</a>
                    @endguest
                </div>
            </div>

            <footer>
                <p>© 2025 D'JOKI — Premium IT Services Marketplace. Privacy Guaranteed.</p>
                <div style="margin-top: 12px; display: flex; gap: 24px; justify-content: center;">
                    <a href="{{ route('policy') }}#privacy" style="color: inherit; text-decoration: none;">Kebijakan Privasi</a>
                    <a href="{{ route('policy') }}#terms" style="color: inherit; text-decoration: none;">Ketentuan Layanan</a>
                    <a href="{{ route('policy') }}#trust" style="color: inherit; text-decoration: none;">Trust & Safety</a>
                </div>
            </footer>
        </div>

        <script>
            // faq accordion
            document.querySelectorAll('.faq-item').forEach(item => {
                const questionDiv = item.querySelector('.faq-question');
                questionDiv.addEventListener('click', () => {
                    item.classList.toggle('active');
                    const span = questionDiv.querySelector('span');
                    if (item.classList.contains('active')) {
                        span.textContent = '−';
                    } else {
                        span.textContent = '+';
                    }
                });
            });
            // slight animation on scroll (optional)
            window.addEventListener('load', () => {
                const cards = document.querySelectorAll('.service-card, .why-card, .pricing-card, .testimonial');
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.style.opacity = '1';
                            entry.target.style.transform = 'translateY(0)';
                        }
                    });
                }, {
                    threshold: 0.1
                });
                cards.forEach(card => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    card.style.transition = '0.4s';
                    observer.observe(card);
                });
            });
        </script>

</body>

</html>
