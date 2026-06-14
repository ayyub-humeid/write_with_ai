<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>@yield('title', 'Write AI')</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Source+Serif+4:wght@400;600;700&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-error-container": "#93000a",
                        "on-primary": "#ffffff",
                        "inverse-on-surface": "#f1f1f1",
                        "tertiary-container": "#a15100",
                        "outline": "#7b7487",
                        "tertiary-fixed-dim": "#ffb784",
                        "on-secondary-fixed-variant": "#474746",
                        "on-primary-fixed": "#25005a",
                        "inverse-primary": "#d2bbff",
                        "surface-variant": "#e2e2e2",
                        "on-tertiary-fixed-variant": "#713700",
                        "outline-variant": "#ccc3d8",
                        "secondary-fixed": "#e5e2e1",
                        "on-secondary": "#ffffff",
                        "on-surface-variant": "#4a4455",
                        "primary": "#630ed4",
                        "secondary": "#5f5e5e",
                        "on-secondary-fixed": "#1c1b1b",
                        "on-primary-fixed-variant": "#5a00c6",
                        "surface-container-lowest": "#ffffff",
                        "surface-tint": "#732ee4",
                        "surface-container-low": "#f3f3f3",
                        "on-primary-container": "#ede0ff",
                        "secondary-fixed-dim": "#c8c6c5",
                        "surface": "#f9f9f9",
                        "error": "#ba1a1a",
                        "inverse-surface": "#2f3131",
                        "tertiary": "#7d3d00",
                        "surface-container": "#eeeeee",
                        "surface-bright": "#f9f9f9",
                        "on-tertiary-container": "#ffe0cd",
                        "secondary-container": "#e2dfde",
                        "surface-container-high": "#e8e8e8",
                        "on-background": "#1a1c1c",
                        "on-surface": "#1a1c1c",
                        "primary-fixed-dim": "#d2bbff",
                        "primary-fixed": "#eaddff",
                        "surface-container-highest": "#e2e2e2",
                        "surface-dim": "#dadada",
                        "error-container": "#ffdad6",
                        "on-tertiary": "#ffffff",
                        "on-error": "#ffffff",
                        "tertiary-fixed": "#ffdcc6",
                        "on-secondary-container": "#636262",
                        "background": "#f9f9f9",
                        "primary-container": "#7c3aed",
                        "on-tertiary-fixed": "#301400"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "margin-mobile": "1rem",
                        "container-max": "1200px",
                        "gutter": "1.5rem",
                        "article-max": "720px",
                        "section-gap": "4rem"
                    },
                    "fontFamily": {
                        "body-lg": ["Source Serif 4"],
                        "ui-button": ["Inter"],
                        "display-lg": ["Source Serif 4"],
                        "headline-md": ["Source Serif 4"],
                        "body-md": ["Source Serif 4"],
                        "display-lg-mobile": ["Source Serif 4"],
                        "metadata": ["Inter"],
                        "ui-label": ["Inter"]
                    },
                    "fontSize": {
                        "body-lg": ["20px", {
                            "lineHeight": "1.6",
                            "fontWeight": "400"
                        }],
                        "ui-button": ["16px", {
                            "lineHeight": "1",
                            "letterSpacing": "0.02em",
                            "fontWeight": "600"
                        }],
                        "display-lg": ["48px", {
                            "lineHeight": "1.2",
                            "letterSpacing": "-0.02em",
                            "fontWeight": "700"
                        }],
                        "headline-md": ["32px", {
                            "lineHeight": "1.3",
                            "fontWeight": "600"
                        }],
                        "body-md": ["18px", {
                            "lineHeight": "1.6",
                            "fontWeight": "400"
                        }],
                        "display-lg-mobile": ["32px", {
                            "lineHeight": "1.2",
                            "fontWeight": "700"
                        }],
                        "metadata": ["12px", {
                            "lineHeight": "1.4",
                            "fontWeight": "400"
                        }],
                        "ui-label": ["14px", {
                            "lineHeight": "1.4",
                            "letterSpacing": "0.01em",
                            "fontWeight": "500"
                        }]
                    }
                },
            },
        }
    </script>

    @stack('style')
</head>

<body class="@yield('bodyClass')">
    @include('layouts.includes.navbar')
    <!-- Main Content Layout -->
    <main class="@yield('mainClass')">
        @yield('content')

    </main>

    <!-- Footer -->
    @include('layouts.includes.footer')

    <!-- Modern Tailwind Toaster -->
    @include('layouts.includes.toasts')

    <!-- Modern Tailwind Confirmation Modal -->
    @include('layouts.includes.confirm-modal')
    <script src="{{ asset('js/engamentFunctions.js') }}"></script>

    @yield('script')
</body>

</html>
