<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <style>
        :root {
            --primary-color: #0E4BF1;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9fafc;
            color: #2d2d2d;
            margin: 0;
            padding: 40px 15px;
        }

        .email-container {
            max-width: 600px;
            margin: auto;
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            padding: 32px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        }

        .email-header {
            text-align: center;
            border-bottom: 1px solid #eaeaea;
            padding-bottom: 16px;
            margin-bottom: 24px;
        }

        .email-header h1 {
            font-size: 22px;
            color: var(--primary-color);
            margin: 0;
        }

        .email-body {
            font-size: 15px;
            line-height: 1.7;
            color: #444;
        }

        .btn {
            display: inline-block;
            margin: 24px 0;
            padding: 14px 28px;
            background-color: var(--primary-color);
            color: #ffffff;
            text-decoration: none;
            font-weight: 600;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0935a5;
            color: #ffffff;
        }

        .email-footer {
            text-align: center;
            font-size: 13px;
            color: #888;
            margin-top: 32px;
            border-top: 1px solid #eaeaea;
            padding-top: 16px;
        }

        @media (max-width: 600px) {
            .email-container {
                padding: 24px 20px;
            }

            .email-header h1 {
                font-size: 20px;
            }

            .btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Password Reset</h1>
        </div>

        <div class="email-body">
            <p>Hello,</p>
            <p>You recently requested to reset the password for your PetHealthVault account.</p>
            <p>Click the button below to proceed with resetting your password:</p>

            <p style="text-align: center;">
                <a href="{{ route('reset.password', ['token' => $token]) }}" class="btn">Reset Password</a>
            </p>

            <p>If you didn’t request a password reset, you can safely ignore this email—no changes will be made to your account.</p>

            <p>Thanks,<br>The Heptagon Team</p>
        </div>

        <div class="email-footer">
            <p>If you need help, contact us at <a href="mailto:pethealthvault@gmail.com">pethealthvault@gmail.com</a></p>
        </div>
    </div>
</body>
</html>
