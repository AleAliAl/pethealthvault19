<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="{{ asset('css/remixicon.css') }}">
    <link rel="stylesheet" href="{{ asset('css/forgot-password.css') }}">
</head>

<body>
    <div class="container">
        <div class="design">
            <div class="pill-1 rotate-45"></div>
            <div class="pill-2 rotate-45"></div>
            <div class="pill-3 rotate-45"></div>
            <div class="pill-4 rotate-45"></div>
        </div>

        <div class="login">
            <h3 class="title">Reset Password</h3>

            {{-- Success Message --}}
            @if (session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
            @endif

            {{-- All Error Messages --}}
            @if ($errors->any())
            <div class="error-message-group">
                @foreach ($errors->all() as $error)
                <p class="error-message text-sm">{{ $error }}</p>
                @endforeach
            </div>
            @endif

            <form action="{{ route('reset.password.post') }}" method="POST">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                {{-- Email --}}
                <div class="text-input">
                    <i class="ri-user-fill"></i>
                    <input type="email" name="email" placeholder="Email address" required value="{{ old('email') }}">
                </div>

                {{-- New Password --}}
                <div class="text-input">
                    <i class="ri-lock-password-fill"></i>
                    <input type="password" name="password" placeholder="New password" required>
                </div>

                {{-- Confirm Password --}}
                <div class="text-input">
                    <i class="ri-lock-fill"></i>
                    <input type="password" name="password_confirmation" placeholder="Confirm new password" required>
                </div>

                <button type="submit" class="login-btn">Reset Password</button>
            </form>
        </div>

    </div>
</body>

</html>