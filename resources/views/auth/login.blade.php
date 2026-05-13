<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - D'JOKI</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }

        .glass {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .text-gradient {
            background: linear-gradient(to right, #60a5fa, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .btn-premium {
            background: linear-gradient(to right, #3b82f6, #8b5cf6);
            color: white;
            font-weight: bold;
            border-radius: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);
        }

        .btn-premium:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(59, 130, 246, 0.4);
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 100;
            opacity: 0;
            pointer-events: none;
            transition: all 0.3s ease;
        }

        .modal-overlay.active {
            opacity: 1;
            pointer-events: auto;
        }

        .modal-content {
            background: #1e293b;
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 2rem;
            border-radius: 1.5rem;
            max-width: 400px;
            width: 90%;
            transform: scale(0.9);
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            text-align: center;
        }

        .modal-overlay.active .modal-content {
            transform: scale(1);
        }
    </style>
</head>

<body class="antialiased bg-[#0f172a] min-h-screen flex items-center justify-center p-6">
    <div id="policyModal" class="modal-overlay">
        <div class="modal-content">
            <div class="w-16 h-16 bg-blue-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Persetujuan Diperlukan</h3>
            <p class="text-slate-400 mb-6 text-sm">Mohon centang kotak persetujuan Kebijakan Privasi & Ketentuan Layanan untuk melanjutkan.</p>
            <button onclick="closeModal()" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition">
                Saya Mengerti
            </button>
        </div>
    </div>

    <div class="absolute inset-0 z-0 overflow-hidden">
        <div
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-blue-600/10 blur-[120px] rounded-full">
        </div>
    </div>

    <div class="w-full max-w-md relative z-10">
        <div class="text-center mb-8">
            <a href="/" class="text-3xl font-bold text-gradient inline-block mb-2">D'JOKI</a>
            <p class="text-slate-400">Selamat datang kembali! Silahkan masuk ke akun Anda.</p>
        </div>

        @if (session('success'))
            <div
                class="mb-6 p-4 rounded-2xl bg-green-500/10 border border-green-500/20 text-green-400 text-sm text-center">
                {{ session('success') }}
            </div>
        @endif

        <div class="glass p-8 rounded-3xl">
            <div class="space-y-6 ">
                <div class="text-center">
                    <p class="text-xs uppercase tracking-widest text-slate-500 font-bold mb-8">Masuk dengan Akun Sosial
                    </p>
                </div>

                <div class="space-y-6">
                    <div class="flex items-start gap-3 p-4 bg-white/5 border border-white/10 rounded-2xl">
                        <div class="flex items-center h-5">
                            <input id="agree_policy" type="checkbox" onchange="toggleLoginButtons()"
                                class="w-4 h-4 text-blue-600 bg-[#0f172a] border-white/20 rounded focus:ring-blue-500 focus:ring-offset-[#0f172a]">
                        </div>
                        <label for="agree_policy" class="text-xs text-slate-400 cursor-pointer">
                            Saya telah membaca dan menyetujui <a href="{{ route('policy') }}#terms" target="_blank"
                                class="text-blue-400 hover:underline">Ketentuan Layanan</a> serta <a
                                href="{{ route('policy') }}#privacy" target="_blank"
                                class="text-blue-400 hover:underline">Kebijakan Privasi</a> D'JOKI.
                        </label>
                    </div>

                    <div id="login_buttons_container"
                        class="grid grid-cols-1 gap-4 opacity-40 pointer-events-none transition-opacity duration-300">
                        <a href="javascript:void(0)" onclick="loginWithGoogle()"
                            class="flex items-center justify-center px-6 py-4 bg-white/5 border border-white/10 rounded-2xl hover:bg-white/10 transition group hover:border-blue-500/50">
                            <svg class="h-6 w-6 mr-3" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M12.48 10.92v3.28h7.84c-.24 1.84-.908 3.152-1.896 4.14-1.236 1.236-3.156 2.532-6.424 2.532-5.172 0-9.204-4.14-9.204-9.204s4.032-9.204 9.204-9.204c2.82 0 4.932 1.104 6.432 2.52l2.316-2.316C18.42 1.056 15.756 0 12.48 0 6.648 0 1.92 4.728 1.92 10.56S6.648 21.12 12.48 21.12c3.156 0 5.544-1.044 7.416-2.976 1.92-1.92 2.532-4.596 2.532-6.768 0-.648-.048-1.26-.144-1.848h-9.804z" />
                            </svg>
                            <span class="text-sm font-bold text-white">Lanjutkan dengan Google</span>
                        </a>

                        <a href="{{ route('social.redirect', 'github') }}"
                            onclick="if(!document.getElementById('agree_policy').checked) { event.preventDefault(); showModal(); return false; }"
                            class="flex items-center justify-center px-6 py-4 bg-white/5 border border-white/10 rounded-2xl hover:bg-white/10 transition group hover:border-slate-400/50">
                            <svg class="h-6 w-6 mr-3" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="text-sm font-bold text-white">Lanjutkan dengan GitHub</span>
                        </a>
                    </div>
                </div>

                <script>
                    function showModal() {
                        document.getElementById('policyModal').classList.add('active');
                    }

                    function closeModal() {
                        document.getElementById('policyModal').classList.remove('active');
                    }

                    function toggleLoginButtons() {
                        const checkbox = document.getElementById('agree_policy');
                        const container = document.getElementById('login_buttons_container');
                        if (checkbox.checked) {
                            container.classList.remove('opacity-40', 'pointer-events-none');
                        } else {
                            container.classList.add('opacity-40', 'pointer-events-none');
                        }
                    }
                </script>

                <div class="mt-8 pt-6 border-t border-white/10 text-center">
                    <p class="text-[10px] text-slate-500 leading-relaxed italic">
                        Dengan masuk, Anda menyetujui Ketentuan Layanan dan Kebijakan Privasi D'JOKI.
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-8 text-center text-xs text-slate-500">
            &copy; 2026 D'JOKI. Secure Login with SSL.
        </div>
    </div>
    <script type="module">
        import {
            initializeApp
        } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-app.js";
        import {
            getAuth,
            GoogleAuthProvider,
            signInWithPopup
        } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-auth.js";

        // Firebase Configuration (Replace with your actual config)
        const firebaseConfig = {
            apiKey: "{{ env('FIREBASE_API_KEY') }}",
            authDomain: "{{ env('FIREBASE_AUTH_DOMAIN') }}",
            projectId: "{{ env('FIREBASE_PROJECT_ID') }}",
            storageBucket: "{{ env('FIREBASE_STORAGE_BUCKET') }}",
            messagingSenderId: "{{ env('FIREBASE_MESSAGING_SENDER_ID') }}",
            appId: "{{ env('FIREBASE_APP_ID') }}",
            measurementId: "{{ env('FIREBASE_MEASUREMENT_ID') }}"
        };

        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);
        const provider = new GoogleAuthProvider();

        window.loginWithGoogle = async () => {
            const checkbox = document.getElementById('agree_policy');
            if (!checkbox.checked) {
                showModal();
                return;
            }
            try {
                const result = await signInWithPopup(auth, provider);
                const user = result.user;
                const idToken = await user.getIdToken();

                // Send token to backend
                const response = await fetch("{{ route('auth.firebase.google') }}", {
                    method: "POST",
                    headers: {
                        "Accept": "application/json",
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        id_token: idToken
                    })
                });

                if (!response.ok) {
                    const errorText = await response.text();
                    console.error("Backend Error Response:", errorText);
                    throw new Error(
                        "Gagal verifikasi ke server. Pastikan file kredensial Firebase sudah terpasang di storage/app/firebase-auth.json"
                    );
                }

                const data = await response.json();
                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    alert(data.message || "Gagal masuk dengan Firebase.");
                }
            } catch (error) {
                console.error("Firebase Auth Error:", error);
                alert("Kesalahan Autentikasi: " + error.message);
            }
        };
    </script>
</body>

</html>
