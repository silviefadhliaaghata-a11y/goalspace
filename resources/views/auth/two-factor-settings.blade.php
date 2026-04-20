<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan OTP - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 py-10 px-4">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-200">
                <h1 class="text-2xl font-bold text-slate-800">Pengaturan OTP / 2FA</h1>
                <p class="text-sm text-slate-500 mt-2">
                    Aktifkan verifikasi 2 langkah untuk keamanan akun.
                </p>
            </div>

            <div class="p-8 space-y-6">
                @if (session('status') == 'two-factor-authentication-enabled')
                    <div class="rounded-xl border border-yellow-200 bg-yellow-50 px-4 py-3 text-sm text-yellow-800">
                        OTP berhasil diaktifkan. Scan QR code lalu masukkan kode OTP untuk konfirmasi.
                    </div>
                @endif

                @if (session('status') == 'two-factor-authentication-confirmed')
                    <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                        OTP berhasil dikonfirmasi dan sudah aktif.
                    </div>
                @endif

                @if (session('status') == 'recovery-codes-generated')
                    <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                        Recovery code berhasil dibuat ulang.
                    </div>
                @endif

                @if ($errors->any())
                    <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="rounded-2xl border border-slate-200 p-6">
                    <h2 class="text-lg font-semibold text-slate-800 mb-2">Status OTP</h2>

                    @if (is_null(auth()->user()->two_factor_secret))
                        <p class="text-sm text-slate-500 mb-5">
                            OTP belum aktif di akun ini.
                        </p>

                        <form method="POST" action="{{ url('/user/two-factor-authentication') }}">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800 transition">
                                Aktifkan OTP Sekarang
                            </button>
                        </form>
                    @else
                        <p class="text-sm text-green-600 font-medium mb-5">
                            OTP sudah diaktifkan.
                        </p>

                        @if (is_null(auth()->user()->two_factor_confirmed_at))
                            <div class="mb-6 rounded-xl border border-yellow-200 bg-yellow-50 p-4">
                                <p class="text-sm text-yellow-800 font-medium mb-2">
                                    Langkah berikutnya:
                                </p>
                                <p class="text-sm text-yellow-700">
                                    Scan QR code berikut dengan Google Authenticator, lalu masukkan 6 digit kode OTP untuk konfirmasi.
                                </p>
                            </div>

                            <div class="mb-6">
                                <h3 class="text-sm font-semibold text-slate-700 mb-3">QR Code</h3>
                                <div class="inline-block rounded-2xl border border-slate-200 bg-white p-4">
                                    {!! auth()->user()->twoFactorQrCodeSvg() !!}
                                </div>
                            </div>

                            <div class="mb-6">
                                <h3 class="text-sm font-semibold text-slate-700 mb-3">Konfirmasi OTP</h3>

                                <form method="POST" action="{{ url('/user/confirmed-two-factor-authentication') }}" class="space-y-4">
                                    @csrf

                                    <input
                                        type="text"
                                        name="code"
                                        inputmode="numeric"
                                        autocomplete="one-time-code"
                                        placeholder="Masukkan 6 digit OTP"
                                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-300"
                                    >

                                    <button type="submit"
                                        class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700 transition">
                                        Konfirmasi OTP
                                    </button>
                                </form>
                            </div>
                        @endif

                        @if (!is_null(auth()->user()->two_factor_confirmed_at))
                            <div class="mb-6">
                                <h3 class="text-sm font-semibold text-slate-700 mb-3">Recovery Codes</h3>

                                <div class="rounded-2xl bg-slate-900 p-5">
                                    <div class="grid gap-2 sm:grid-cols-2">
                                        @foreach (auth()->user()->recoveryCodes() as $code)
                                            <div class="rounded-lg bg-slate-800 px-3 py-2 text-sm text-slate-100 font-mono">
                                                {{ $code }}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <form method="POST" action="{{ url('/user/two-factor-recovery-codes') }}">
                                        @csrf
                                        <button type="submit"
                                            class="rounded-xl bg-amber-500 px-5 py-3 text-sm font-semibold text-white hover:bg-amber-600 transition">
                                            Generate Ulang Recovery Code
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif

                        <form method="POST" action="{{ url('/user/two-factor-authentication') }}">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                class="rounded-xl bg-red-600 px-5 py-3 text-sm font-semibold text-white hover:bg-red-700 transition">
                                Nonaktifkan OTP
                            </button>
                        </form>
                    @endif
                </div>

                @php
                    $team = auth()->user()?->currentTeam ?? auth()->user()?->personalTeam();
                @endphp

                @if ($team)
                    <a href="{{ route('dashboard', ['current_team' => $team->slug]) }}"
                       class="text-sm text-slate-500 hover:text-slate-700">
                        ← Kembali ke dashboard
                    </a>
                @endif
            </div>
        </div>
    </div>
</body>
</html>