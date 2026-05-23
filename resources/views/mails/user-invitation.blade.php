@php
$rtlLocales = ['ar', 'fa', 'he']; // Arabic, Persian, Hebrew
$dir = in_array(app()->getLocale(), $rtlLocales) ? 'rtl' : 'ltr';

// 1. Fetch your base frontend domain
$frontendUrl = $frontendUrl ?? config('app.frontend_url', 'https://app.ceo-app.com');

// 2. Define your query parameters
$queryParams = [
'tenant_id' => $tenant_id,
'email' => $user['email'] ?? ''
];

// 3. Combine them safely into a clean URL
$invitationLink = rtrim($frontendUrl, '/') . '/invitations/employee?' . http_build_query($queryParams);
@endphp

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $dir }}">

<head>
    <meta charset="UTF-8">
    <title>{{ __('mail.invite_subject') }}</title>
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
        <img src="{{ url('https://www2.0zz0.com/2025/08/28/13/180370951.png') }}" alt="ceo logo" width="80" height="80">
    </div>

    {{-- Greeting --}}
    <h2 style="margin-bottom: 10px;">
        {{ __('mail.invite_greeting') }} {{ $user['first_name'] ?? '' }}
    </h2>

    {{-- Invitation Body --}}
    <p style="margin-bottom: 20px; white-space: pre-line;">
        {{ __('mail.invite_welcome') }}
    </p>

    <p style="margin-bottom: 25px;">
        {{ __('mail.invite_instruction') }}
    </p>

    {{-- Dynamic Call to Action Button --}}
    <div style="margin: 30px 0; text-align: {{ $dir == 'rtl' ? 'right' : 'left' }};">
        <a href="{{ $invitationLink }}"
            style="display: inline-block;
                  background-color: #1a1a1a;
                  color: #ffc107 !important;
                  font-size: 18px;
                  font-weight: bold;
                  padding: 12px 28px;
                  border-radius: 6px;
                  text-decoration: none;
                  box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
            {{ __('mail.invite_button') }}
        </a>
    </div>

    {{-- Expiry & Alternative Link --}}
    <p style="margin-bottom: 10px; font-size: medium; color: #666;">
        {{ __('mail.invite_expiry') }}
    </p>

    <p style="margin-bottom: 20px; font-size: small; color: #888; word-break: break-all;">
        {{ __('mail.invite_trouble') }}<br>
        <a href="{{ $invitationLink }}" style="color: #1a1a1a;">{{ $invitationLink }}</a>
    </p>

    {{-- Thanks --}}
    <p style="white-space: pre-line;">
        {{ __('mail.thanks') }}
    </p>

</body>

</html>
