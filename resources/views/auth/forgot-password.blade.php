<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FORGOT-PASSWORD</title>
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
            <h3 class="title">Forgot Your Password?</h3>
            <p class="subtitle">We will send a link to your email, use that to reset your password.</p>

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


            <form action="{{ route('forgot.password.post') }}" method="POST">
                @csrf

                {{-- Email --}}
                <div class="text-input">
                    <i class="ri-user-fill"></i>
                    <input type="email" name="email" placeholder="Email address" required>
                </div>

                <button type="submit" class="login-btn">Send Reset Link</button>
            </form>
        </div>
    </div>
</body>

</html>