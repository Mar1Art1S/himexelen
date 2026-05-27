<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>
    {{ filled($title ?? null) ? $title.' - '.config('app.name', 'Laravel') : config('app.name', 'Laravel') }}
</title>

<link rel="icon" href="{{ asset('images/favicon/favicon.ico') }}" sizes="any">
<link rel="icon" href="{{ asset('images/favicon/favicon.svg') }}" type="image/svg+xml">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon/favicon-16x16.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon/favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="48x48" href="{{ asset('images/favicon/favicon-48x48.png') }}">
<link rel="apple-touch-icon" href="{{ asset('images/favicon/apple-touch-icon.png') }}">
<link rel="apple-touch-icon" sizes="152x152" href="{{ asset('images/favicon/apple-touch-icon-152x152.png') }}">
<link rel="apple-touch-icon" sizes="167x167" href="{{ asset('images/favicon/apple-touch-icon-167x167.png') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon/apple-touch-icon-180x180.png') }}">
<link rel="mask-icon" href="{{ asset('images/favicon/safari-pinned-tab.svg') }}" color="#b86f17">
<link rel="manifest" href="{{ asset('images/favicon/site.webmanifest') }}">
<meta name="theme-color" content="#ffffff">

@fonts

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
