<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Policy & Persyaratan — D'JOKI</title>
    <!-- Font Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #B79CED;
            --secondary: #A3D977;
            --accent: #E9B949;
            --bg: #0F172A;
            --card: #1E293B;
            --text: #F8FAFC;
            --muted: #94A3B8;
            --border: #334155;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg);
            color: var(--text);
            line-height: 1.7;
            overflow-x: hidden;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 80px 24px;
        }

        .navbar {
            padding: 24px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 60px;
        }

        .logo {
            font-size: 24px;
            font-weight: 800;
            color: var(--text);
            text-decoration: none;
        }

        .logo span {
            color: var(--primary);
        }

        .btn-back {
            color: var(--muted);
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.2s;
        }

        .btn-back:hover {
            color: var(--primary);
        }

        h1 {
            font-size: 48px;
            font-weight: 800;
            margin-bottom: 16px;
            letter-spacing: -1px;
        }

        .section-nav {
            display: flex;
            gap: 24px;
            margin-bottom: 48px;
            border-bottom: 1px solid var(--border);
            padding-bottom: 16px;
        }

        .section-nav a {
            color: var(--muted);
            text-decoration: none;
            font-weight: 700;
            transition: 0.2s;
        }

        .section-nav a:hover, .section-nav a.active {
            color: var(--primary);
        }

        .policy-content section {
            margin-bottom: 60px;
        }

        h2 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 24px;
            color: var(--primary);
        }

        h3 {
            font-size: 20px;
            font-weight: 700;
            margin: 32px 0 12px 0;
            color: var(--text);
        }

        p {
            margin-bottom: 16px;
            color: var(--muted);
        }

        ul {
            margin-bottom: 24px;
            padding-left: 20px;
            color: var(--muted);
        }

        li {
            margin-bottom: 8px;
        }

        .highlight-box {
            background: rgba(183, 156, 237, 0.1);
            border-left: 4px solid var(--primary);
            padding: 24px;
            border-radius: 0 16px 16px 0;
            margin: 32px 0;
        }

        .highlight-box strong {
            color: var(--primary);
            display: block;
            margin-bottom: 8px;
        }

        footer {
            margin-top: 100px;
            padding-top: 40px;
            border-top: 1px solid var(--border);
            text-align: center;
            color: var(--muted);
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container">
        <nav class="navbar">
            <a href="/" class="logo">D'JOKI<span>.</span></a>
            <a href="/" class="btn-back">← Kembali ke Beranda</a>
        </nav>

        <header>
            <h1>Persyaratan & Kebijakan</h1>
            <p style="font-size: 18px; max-width: 600px;">Kami menjaga kepercayaan Anda dengan transparansi penuh mengenai cara kami bekerja dan melindungi data Anda.</p>
        </header>

        <div class="section-nav">
            <a href="#terms">Ketentuan Layanan</a>
            <a href="#privacy">Kebijakan Privasi</a>
            <a href="#trust">Trust & Safety</a>
        </div>

        <div class="policy-content">
            <!-- Terms of Service -->
            <section id="terms">
                <h2>Ketentuan Layanan</h2>
                <p>Dengan menggunakan platform D'JOKI, Anda menyetujui seluruh ketentuan yang ditetapkan di bawah ini. Mohon baca dengan seksama.</p>
                
                <h3>1. Lingkup Proyek</h3>
                <p>Layanan yang disediakan oleh provider di D'JOKI mencakup bantuan teknis, pengembangan perangkat lunak, dan konsultasi IT sesuai dengan detail yang disepakati di awal pesanan.</p>
                
                <h3>2. Sistem Pembayaran</h3>
                <ul>
                    <li>Pembayaran dilakukan melalui transfer bank atau e-wallet resmi.</li>
                    <li>Kami mendukung opsi DP (Down Payment) 30% untuk proyek dengan skala tertentu.</li>
                    <li>Dana akan diteruskan ke provider hanya setelah Anda mengonfirmasi bahwa pekerjaan telah selesai atau masa sanggah berakhir.</li>
                </ul>

                <h3>3. Sistem Revisi</h3>
                <p>Kami memastikan hasil yang Anda terima sesuai dengan ekspektasi awal:</p>
                <ul>
                    <li>Setiap proyek mendapatkan jatah minimal <strong>2x revisi gratis</strong>.</li>
                    <li>Permintaan revisi harus diajukan dalam jangka waktu 48 jam setelah hasil pekerjaan dikirimkan oleh provider.</li>
                    <li>Revisi mencakup perbaikan bug, penyesuaian desain minor, atau koreksi logika yang tidak mengubah lingkup proyek awal secara drastis.</li>
                </ul>

                <h3>4. Sistem Persetujuan & Masa Sanggah</h3>
                <p>Untuk melindungi keamanan transaksi Anda, kami menggunakan sistem penahanan dana (Escrow):</p>
                <ul>
                    <li>Setelah provider mengirimkan hasil akhir, status pesanan akan berubah menjadi <strong>"Menunggu Persetujuan"</strong>.</li>
                    <li>Anda memiliki waktu <strong>48 jam (Masa Sanggah)</strong> untuk meninjau hasil tersebut.</li>
                    <li>Jika Anda puas, Anda dapat menekan tombol "Selesaikan Pesanan" untuk melepaskan dana ke provider.</li>
                    <li>Jika tidak ada aksi dari klien dalam 48 jam, sistem akan menganggap proyek telah diterima dan dana akan dilepaskan secara otomatis.</li>
                </ul>
            </section>

            <!-- Privacy Policy -->
            <section id="privacy">
                <h2>Kebijakan Privasi</h2>
                <p>Privasi Anda adalah prioritas tertinggi kami. D'JOKI dirancang untuk menjaga kerahasiaan aktivitas Anda sepenuhnya.</p>

                <div class="highlight-box">
                    <strong>Jaminan Anonimitas</strong>
                    Kami menjamin bahwa identitas asli Anda tidak akan pernah diungkapkan kepada publik atau pihak ketiga yang tidak berkepentingan terkait penggunaan jasa kami.
                </div>

                <h3>1. Perlindungan Data</h3>
                <p>Semua file yang diunggah ke platform kami disimpan dalam penyimpanan terenkripsi (AES-256) dan hanya dapat diakses oleh provider yang ditugaskan dan administrator sistem.</p>

                <h3>2. Penggunaan Informasi</h3>
                <p>Informasi yang kami kumpulkan hanya digunakan untuk keperluan koordinasi proyek dan peningkatan layanan. Kami tidak akan pernah menjual atau membagikan data Anda kepada pihak luar.</p>
            </section>

            <!-- Trust & Safety -->
            <section id="trust">
                <h2>Trust & Safety</h2>
                <p>Membangun ekosistem yang aman untuk kolaborasi IT yang jujur dan profesional.</p>

                <h3>Verified Providers</h3>
                <p>Setiap provider di platform kami melalui proses verifikasi identitas dan portofolio yang ketat. Kami memastikan hanya tenaga profesional yang menangani proyek Anda.</p>

                <h3>Sistem Masa Sanggah</h3>
                <p>Setelah provider menandai pekerjaan selesai, Anda memiliki waktu 48 jam untuk meninjau hasil sebelum dana dilepaskan secara otomatis. Ini menjamin Anda mendapatkan hasil yang sesuai kesepakatan.</p>

                <h3>Enkripsi & Keamanan Server</h3>
                <p>Platform kami menggunakan protokol keamanan terkini untuk memastikan setiap percakapan dan pertukaran data tetap privat dan terlindungi dari serangan siber.</p>
            </section>
        </div>

        <footer>
            <p>© 2025 D'JOKI — Premium IT Services Marketplace. Semua hak dilindungi.</p>
        </footer>
    </div>

    <script>
        // Simple smooth scroll for section nav
        document.querySelectorAll('.section-nav a').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
                
                document.querySelectorAll('.section-nav a').forEach(a => a.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>

</html>
