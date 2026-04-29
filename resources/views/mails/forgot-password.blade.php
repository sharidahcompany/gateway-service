@php
    $rtlLocales = ['ar', 'fa', 'he'];
    $locale = app()->getLocale();
    $dir = in_array($locale, $rtlLocales) ? 'rtl' : 'ltr';
@endphp

<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $dir }}">

<head>
    <meta charset="UTF-8">
    <title>Password Reset OTP</title>
</head>

<body dir="{{ $dir }}"
    style="background-color:#f8f4f0;
           color:#000000 !important;
           padding:20px;
           font-family:Arial, sans-serif;
           font-size:large;
           direction:{{ $dir }};
           text-align:{{ $dir == 'rtl' ? 'right' : 'left' }};">

    {{-- Logo --}}
    <div style="margin-bottom: 20px; text-align: center;">
        <img src="https://www2.0zz0.com/2025/08/28/13/180370951.png"
             alt="logo"
             width="80"
             height="80">
    </div>

    {{-- Greeting --}}
    <h2 style="margin-bottom: 10px;">
        Hello {{ $user->first_name }}
    </h2>

    {{-- Message --}}
    <p style="margin-bottom: 20px;">
        We received a request to reset your password.
    </p>

    <p style="margin-bottom: 15px;">
        Use the OTP below to complete your password reset process:
    </p>

    {{-- OTP --}}
    <div style="margin: 30px 0;">
        <span style="display:inline-block;
                     background-color:#1a1a1a;
                     color:#ffc107;
                     font-size:22px;
                     font-weight:bold;
                     padding:10px 20px;
                     border-radius:6px;
                     letter-spacing:5px;">
            {{ $otp }}
        </span>
    </div>

    {{-- Expiry --}}
    <p style="margin-bottom: 10px;">
        This code will expire in 2 minutes.
    </p>

    {{-- Ignore --}}
    <p style="margin-bottom: 20px; color: #666;">
        If you did not request this, you can safely ignore this email.
    </p>

    {{-- Footer --}}
    <p>
        Thanks,<br>
        {{ config('app.name') }}
    </p>

</body>
</html>
