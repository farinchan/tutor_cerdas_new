<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .container {
            background-color: #f4f4f4;
            padding: 30px;
            border-radius: 5px;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Reset Password Request</h2>
        <p>Halo,</p>
        <p>Anda menerima email ini karena kami menerima permintaan reset password untuk akun Anda.</p>
        <p>
            <a href="{{ route('reset.password', ['token' => $token]) }}?email={{ urlencode($email) }}" class="button">
                Reset Password
            </a>
        </p>
        <p>Link reset password ini akan kadaluarsa dalam 60 menit.</p>
        <p>Jika Anda tidak melakukan permintaan reset password, abaikan email ini.</p>
        <div class="footer">
            <p>Jika Anda mengalami masalah dengan tombol "Reset Password", salin dan tempel URL berikut ke browser Anda:</p>
            <p>{{ route('reset.password', ['token' => $token]) }}?email={{ urlencode($email) }}</p>
        </div>
    </div>
</body>
</html>
