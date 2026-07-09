<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>@yield('title', 'Admin') — TransRoute</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Hanken+Grotesk:wght@600;700&family=IBM+Plex+Sans:wght@400;600&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "inverse-primary": "#a3c9fc",
                        "secondary": "#a04100",
                        "on-primary-fixed-variant": "#1e4973",
                        "on-error-container": "#93000a",
                        "surface-container-low": "#f1f4f6",
                        "secondary-fixed-dim": "#ffb693",
                        "primary": "#001f3c",
                        "on-primary-container": "#799fcf",
                        "primary-container": "#00355f",
                        "primary-fixed-dim": "#a3c9fc",
                        "on-tertiary-container": "#929cb1",
                        "inverse-on-surface": "#eef1f3",
                        "on-tertiary": "#ffffff",
                        "on-tertiary-fixed-variant": "#3d4759",
                        "on-primary": "#ffffff",
                        "surface-tint": "#39608d",
                        "surface-variant": "#e0e3e5",
                        "on-secondary-fixed-variant": "#7a3000",
                        "surface-container-high": "#e5e9eb",
                        "primary-fixed": "#d2e4ff",
                        "on-surface": "#181c1e",
                        "on-surface-variant": "#42474f",
                        "outline-variant": "#c3c6d0",
                        "error": "#ba1a1a",
                        "on-tertiary-fixed": "#121c2c",
                        "tertiary": "#151f2f",
                        "secondary-container": "#fe6b00",
                        "surface-dim": "#d7dadc",
                        "tertiary-container": "#2a3445",
                        "tertiary-fixed": "#d9e3f9",
                        "tertiary-fixed-dim": "#bdc7dc",
                        "surface-container-highest": "#e0e3e5",
                        "surface-bright": "#f7fafc",
                        "background": "#f7fafc",
                        "on-secondary": "#ffffff",
                        "surface-container-lowest": "#ffffff",
                        "on-primary-fixed": "#001c37",
                        "on-secondary-container": "#572000",
                        "surface-container": "#ebeef0",
                        "on-error": "#ffffff",
                        "secondary-fixed": "#ffdbcc",
                        "error-container": "#ffdad6",
                        "on-secondary-fixed": "#351000",
                        "on-background": "#181c1e",
                        "inverse-surface": "#2d3133",
                        "surface": "#f7fafc",
                        "outline": "#73777f"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "sm": "12px",
                        "container-max": "1280px",
                        "gutter": "24px",
                        "md": "24px",
                        "xl": "80px",
                        "lg": "48px",
                        "margin-mobile": "16px",
                        "xs": "4px",
                        "base": "8px"
                    },
                    "fontFamily": {
                        "body-md": ["Inter"],
                        "data-tabular": ["IBM Plex Sans"],
                        "label-caps": ["IBM Plex Sans"],
                        "display-lg": ["Hanken Grotesk"],
                        "headline-md": ["Hanken Grotesk"],
                        "headline-lg": ["Hanken Grotesk"],
                        "body-lg": ["Inter"]
                    },
                    "fontSize": {
                        "body-md": ["16px", {
                            "lineHeight": "24px",
                            "fontWeight": "400"
                        }],
                        "data-tabular": ["14px", {
                            "lineHeight": "20px",
                            "fontWeight": "400"
                        }],
                        "label-caps": ["12px", {
                            "lineHeight": "16px",
                            "letterSpacing": "0.05em",
                            "fontWeight": "600"
                        }],
                        "display-lg": ["48px", {
                            "lineHeight": "56px",
                            "letterSpacing": "-0.02em",
                            "fontWeight": "700"
                        }],
                        "headline-md": ["24px", {
                            "lineHeight": "32px",
                            "fontWeight": "600"
                        }],
                        "headline-lg": ["32px", {
                            "lineHeight": "40px",
                            "letterSpacing": "-0.01em",
                            "fontWeight": "600"
                        }],
                        "body-lg": ["18px", {
                            "lineHeight": "28px",
                            "fontWeight": "400"
                        }]
                    }
                }
            },
        }
    </script>
    <style>
        .glass-nav {
            background: rgba(247, 250, 252, 0.8);
            backdrop-filter: blur(12px);
        }

        .zebra-row:nth-child(even) {
            background-color: #f1f4f6;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .sidebar-link.active {
            background-color: #fe6b00;
            color: #572000;
        }

        .modal-backdrop {
            background-color: rgba(0, 31, 60, 0.5);
            backdrop-filter: blur(4px);
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-background text-on-background font-body-md">
    <aside
        class="h-screen w-64 fixed left-0 top-0 bg-primary text-on-primary shadow-sm border-r border-outline-variant/30 flex flex-col p-md gap-base z-50 overflow-y-auto scroll-smooth">
        <div class="mb-lg">
            <h1 class="font-display-lg text-display-lg font-bold text-on-primary"
                style="font-size:28px;line-height:1.2">TransRoute</h1>
            <p class="font-label-caps text-label-caps text-on-primary/60 uppercase">Kinetic Logistics</p>
        </div>
        <nav class="flex-grow flex flex-col gap-xs">
            @php $r = request()->route()->getName(); @endphp
            <a href="{{ route('admin.dashboard') }}"
                class="sidebar-link flex items-center gap-base p-sm text-on-primary/70 hover:text-on-primary hover:bg-primary-container transition-colors duration-200 rounded-lg group {{ $r === 'admin.dashboard' ? 'active' : '' }}">
                <span class="material-symbols-outlined">dashboard</span><span
                    class="font-label-caps text-label-caps">Dashboard</span>
            </a>
            <a href="{{ route('admin.flights.index') }}"
                class="sidebar-link flex items-center gap-base p-sm text-on-primary/70 hover:text-on-primary hover:bg-primary-container transition-colors duration-200 rounded-lg group {{ str_starts_with($r, 'admin.flights') ? 'active' : '' }}">
                <span class="material-symbols-outlined">calendar_month</span><span
                    class="font-label-caps text-label-caps">Schedule</span>
            </a>
            <a href="{{ route('admin.bookings.index') }}"
                class="sidebar-link flex items-center gap-base p-sm text-on-primary/70 hover:text-on-primary hover:bg-primary-container transition-colors duration-200 rounded-lg group {{ str_starts_with($r, 'admin.bookings') ? 'active' : '' }}">
                <span class="material-symbols-outlined">confirmation_number</span><span
                    class="font-label-caps text-label-caps">Booking</span>
            </a>
            <a href="{{ route('admin.luggage.index') }}"
                class="sidebar-link flex items-center gap-base p-sm text-on-primary/70 hover:text-on-primary hover:bg-primary-container transition-colors duration-200 rounded-lg group {{ str_starts_with($r, 'admin.luggage') ? 'active' : '' }}">
                <span class="material-symbols-outlined">luggage</span><span
                    class="font-label-caps text-label-caps">Luggage</span>
            </a>
            <a href="{{ route('admin.shipping.index') }}"
                class="sidebar-link flex items-center gap-base p-sm text-on-primary/70 hover:text-on-primary hover:bg-primary-container transition-colors duration-200 rounded-lg group {{ str_starts_with($r, 'admin.shipping') ? 'active' : '' }}">
                <span class="material-symbols-outlined">local_shipping</span><span
                    class="font-label-caps text-label-caps">Shipping</span>
            </a>
            <a href="{{ route('admin.crew.index') }}"
                class="sidebar-link flex items-center gap-base p-sm text-on-primary/70 hover:text-on-primary hover:bg-primary-container transition-colors duration-200 rounded-lg group {{ str_starts_with($r, 'admin.crew') ? 'active' : '' }}">
                <span class="material-symbols-outlined">groups</span><span
                    class="font-label-caps text-label-caps">Crew</span>
            </a>
            <a href="{{ route('admin.reports.index') }}"
                class="sidebar-link flex items-center gap-base p-sm text-on-primary/70 hover:text-on-primary hover:bg-primary-container transition-colors duration-200 rounded-lg group {{ str_starts_with($r, 'admin.reports') ? 'active' : '' }}">
                <span class="material-symbols-outlined">assessment</span><span
                    class="font-label-caps text-label-caps">Reports</span>
            </a>
            <a href="{{ route('admin.passengers.index') }}"
                class="sidebar-link flex items-center gap-base p-sm text-on-primary/70 hover:text-on-primary hover:bg-primary-container transition-colors duration-200 rounded-lg group {{ str_starts_with($r, 'admin.passengers') ? 'active' : '' }}">
                <span class="material-symbols-outlined">person</span><span
                    class="font-label-caps text-label-caps">Passengers</span>
            </a>
        </nav>
        <div class="mt-auto flex flex-col gap-xs pt-base border-t border-on-primary/10">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-base p-sm text-on-primary/70 hover:text-on-primary rounded-lg">
                    <span class="material-symbols-outlined">logout</span><span
                        class="font-label-caps text-label-caps">Logout</span>
                </button>
            </form>
        </div>
    </aside>
    <header
        class="fixed top-0 right-0 w-[calc(100%-16rem)] h-16 bg-surface/80 backdrop-blur-md border-b border-outline-variant/30 flex justify-between items-center px-lg z-40">
        <div class="flex items-center gap-md">
            <h2 class="font-headline-md text-headline-md font-bold text-primary">@yield('page-title', 'Dashboard')</h2>
        </div>
        <div class="flex items-center gap-lg">
            <div class="flex items-center gap-md border-l border-outline-variant/30 pl-md">
                <span class="material-symbols-outlined text-on-surface-variant">notifications</span>
                <div
                    class="w-8 h-8 rounded-full bg-secondary-container flex items-center justify-center text-on-secondary-container font-bold text-xs">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </div>
        </div>
    </header>
    <main class="ml-64 pt-16 min-h-screen">
        <div class="max-w-container-max mx-auto p-lg space-y-lg">
            @if (session('success'))
                <div
                    class="bg-green-50 border border-green-200 text-green-800 px-md py-sm rounded-lg text-sm flex items-center gap-2">
                    <span class="material-symbols-outlined text-green-600 text-base">check_circle</span>
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div
                    class="bg-red-50 border border-red-200 text-red-800 px-md py-sm rounded-lg text-sm flex items-center gap-2">
                    <span class="material-symbols-outlined text-red-600 text-base">error</span> {{ session('error') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-800 px-md py-sm rounded-lg text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @yield('content')
        </div>
    </main>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @stack('scripts')
</body>

</html>
