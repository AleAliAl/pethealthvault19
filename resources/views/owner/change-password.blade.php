<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
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
            <h3 class="title">Change Password</h3>

            {{-- Display error messages right under the "Change Password" title --}}
            @if ($errors->any())
            <div class="error-message-group">
                @foreach ($errors->all() as $error)
                <p class="error-message text-sm">{{ $error }}</p>
                @endforeach
            </div>
            @endif

            <form action="{{ route('change.password.update') }}" method="POST">
                @csrf

                {{-- Old Password --}}
                <div class="text-input">
                    <i class="ri-lock-password-fill"></i>
                    <input type="password" name="old_password" placeholder="Enter old password" required>
                </div>

                {{-- New Password --}}
                <div class="text-input">
                    <i class="ri-lock-password-fill"></i>
                    <input type="password" name="new_password" placeholder="Enter new password" required>
                </div>

                {{-- Confirm New Password --}}
                <div class="text-input">
                    <i class="ri-lock-fill"></i>
                    <input type="password" name="new_password_confirmation" placeholder="Confirm new password" required>
                </div>

                <button type="submit" class="login-btn">Update Password</button>
            </form>
        </div>
    </div>
</body>

</html>