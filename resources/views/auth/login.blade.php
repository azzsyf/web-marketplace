<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Akun - Bakoel Jaersey</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800;900&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'DM Sans', sans-serif; background: #f4f5f7; color: #0b0b2b; margin: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .font-brand { font-family: 'Barlow Condensed', sans-serif; }
        .auth-card { width: 100%; max-width: 440px; background: #ffffff; border-radius: 20px; box-shadow: 0 10px 30px rgba(11, 11, 43, 0.08); border: 1px solid #e4e5ef; overflow: hidden; }
        .auth-header { background: #0b0b2b; padding: 32px 24px; text-align: center; color: #ffffff; }
        .auth-body { padding: 32px; }
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-size: 13px; font-weight: 700; color: #0b0b2b; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; }
        .form-input { width: 100%; padding: 12px 16px; border: 1.5px solid #e4e5ef; border-radius: 12px; font-size: 14px; font-family: 'DM Sans', sans-serif; color: #0b0b2b; transition: all 0.2s; outline: none; }
        .form-input:focus { border-color: #e10613; box-shadow: 0 0 0 3px rgba(225, 6, 19, 0.15); }
        .btn-primary { width: 100%; padding: 14px; background: #e10613; color: #ffffff; border: none; border-radius: 12px; font-family: 'Barlow Condensed', sans-serif; font-size: 20px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; transition: background 0.2s; box-shadow: 0 4px 14px rgba(225, 6, 19, 0.3); }
        .btn-primary:hover { background: #a30008; }
        .alert-error { background: #fde8ea; border: 1px solid #f3c4cc; color: #a30008; padding: 12px 16px; border-radius: 12px; font-size: 13px; margin-bottom: 20px; }
    </style>
</head>
<body>

    <div class="auth-card">
        <div class="auth-header">
            <a href="{{ url('/') }}" style="text-decoration: none; display: inline-block; margin-bottom: 8px;">
                <span class="font-brand" style="font-size: 32px; font-weight: 900; text-transform: uppercase; color: #e10613; letter-spacing: 1px;">
                    BAKOEL <span style="color: #ffffff;">JAERSEY</span>
                </span>
            </a>
            <p style="margin: 0; font-size: 13px; color: #a1a3b8;">Masuk untuk melanjutkan belanja jersey favoritmu</p>
        </div>

        <div class="auth-body">
            @if ($errors->any())
                <div class="alert-error">
                    <ul style="margin: 0; padding-left: 16px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input class="form-input" type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@email.com">
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input class="form-input" type="password" id="password" name="password" required placeholder="••••••••">
                </div>

                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; font-size: 13px;">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; color: #6a6c85;">
                        <input type="checkbox" name="remember" id="remember" style="accent-color: #e10613; width: 16px; height: 16px;">
                        Ingat Saya
                    </label>
                </div>

                <button type="submit" class="btn-primary">Masuk Sekarang</button>
            </form>

            <div style="text-align: center; margin-top: 24px; font-size: 13px; color: #6a6c85;">
                Belum punya akun? 
                <a href="{{ route('register') }}" style="color: #e10613; font-weight: 700; text-decoration: none;">Daftar sekarang</a>
            </div>

            <div style="text-align: center; margin-top: 16px;">
                <a href="{{ url('/') }}" style="font-size: 12px; color: #6a6c85; text-decoration: none;">← Kembali ke Beranda</a>
            </div>
        </div>
    </div>

</body>
</html>

