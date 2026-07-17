<!DOCTYPE html>
<html class="scroll-smooth" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>TransRoute</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@600;700&family=Inter:wght@400;500&family=IBM+Plex+Sans:wght@400;600&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "inverse-on-surface": "#eef1f3",
                        "inverse-primary": "#a0c9ff",
                        "outline-variant": "#c2c7d1",
                        "surface-container": "#ebeef0",
                        "tertiary": "#2a3445",
                        "on-secondary-container": "#572000",
                        "surface-container-highest": "#e0e3e5",
                        "surface-variant": "#e0e3e5",
                        "on-secondary-fixed": "#351000",
                        "on-primary-container": "#8ebdf9",
                        "surface-bright": "#f7fafc",
                        "tertiary-fixed": "#d9e3f9",
                        "surface-container-lowest": "#ffffff",
                        "on-tertiary-container": "#b1bbd0",
                        "primary-fixed-dim": "#a0c9ff",
                        "primary-container": "#0f4c81",
                        "on-error": "#ffffff",
                        "surface-tint": "#2d6197",
                        "secondary-container": "#fe6b00",
                        "on-surface-variant": "#42474f",
                        "secondary-fixed": "#ffdbcc",
                        "error": "#ba1a1a",
                        "secondary-fixed-dim": "#ffb693",
                        "secondary": "#a04100",
                        "on-secondary": "#ffffff",
                        "on-error-container": "#93000a",
                        "on-primary-fixed-variant": "#07497d",
                        "surface-container-low": "#f1f4f6",
                        "on-tertiary": "#ffffff",
                        "primary-fixed": "#d2e4ff",
                        "inverse-surface": "#2d3133",
                        "on-secondary-fixed-variant": "#7a3000",
                        "tertiary-container": "#414b5d",
                        "on-tertiary-fixed-variant": "#3d4759",
                        "surface": "#f7fafc",
                        "on-primary-fixed": "#001c37",
                        "on-surface": "#181c1e",
                        "on-background": "#181c1e",
                        "on-primary": "#ffffff",
                        "surface-container-high": "#e5e9eb",
                        "on-tertiary-fixed": "#121c2c",
                        "background": "#f7fafc",
                        "outline": "#727780",
                        "surface-dim": "#d7dadc",
                        "tertiary-fixed-dim": "#bdc7dc",
                        "error-container": "#ffdad6",
                        "primary": "#00355f"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "spacing": {
                        "md": "24px",
                        "xl": "80px",
                        "sm": "12px",
                        "margin-mobile": "16px",
                        "xs": "4px",
                        "container-max": "1280px",
                        "base": "8px",
                        "gutter": "24px",
                        "lg": "48px"
                    },
                    "fontFamily": {
                        "label-caps": ["IBM Plex Sans"],
                        "display-lg": ["Hanken Grotesk"],
                        "headline-lg-mobile": ["Hanken Grotesk"],
                        "body-lg": ["Inter"],
                        "headline-md": ["Hanken Grotesk"],
                        "body-sm": ["Inter"],
                        "headline-lg": ["Hanken Grotesk"],
                        "body-md": ["Inter"],
                        "data-tabular": ["IBM Plex Sans"]
                    },
                    "fontSize": {
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
                        "headline-lg-mobile": ["24px", {
                            "lineHeight": "32px",
                            "fontWeight": "600"
                        }],
                        "body-lg": ["18px", {
                            "lineHeight": "28px",
                            "fontWeight": "400"
                        }],
                        "headline-md": ["24px", {
                            "lineHeight": "32px",
                            "fontWeight": "600"
                        }],
                        "body-sm": ["14px", {
                            "lineHeight": "20px",
                            "fontWeight": "400"
                        }],
                        "headline-lg": ["32px", {
                            "lineHeight": "40px",
                            "letterSpacing": "-0.01em",
                            "fontWeight": "600"
                        }],
                        "body-md": ["16px", {
                            "lineHeight": "24px",
                            "fontWeight": "400"
                        }],
                        "data-tabular": ["14px", {
                            "lineHeight": "20px",
                            "fontWeight": "400"
                        }]
                    }
                }
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }

        .glass-nav {
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .zebra-row:nth-child(even) {
            background-color: #f1f4f6;
        }
    </style>
</head>

<body class="bg-surface font-body-md text-on-surface">
    <header class="fixed top-0 w-full z-50 bg-surface/80 glass-nav border-b border-outline-variant/30">
        <nav class="flex justify-between items-center h-16 px-6 lg:px-xl max-w-container-max mx-auto">
            <div class="flex items-center gap-xs">
                <span class="material-symbols-outlined text-primary"
                    style="font-variation-settings:'FILL' 1;">flight</span>
                <span class="font-headline-md text-headline-md font-bold text-primary">TransRoute</span>
            </div>
            <div class="hidden md:flex gap-md items-center">
                <a class="font-label-caps text-label-caps text-on-surface-variant hover:text-primary transition-colors"
                    href="#services">Services</a>
                <a class="font-label-caps text-label-caps text-on-surface-variant hover:text-primary transition-colors"
                    href="#schedule">Schedule</a>
                <a class="font-label-caps text-label-caps text-on-surface-variant hover:text-primary transition-colors"
                    href="#about">About</a>
                <a class="font-label-caps text-label-caps text-on-surface-variant hover:text-primary transition-colors"
                    href="#contact">Contact</a>
            </div>
            <div class="flex gap-base">
                <a href="{{ route('login') }}" target="_blank" rel="noopener"
                    class="hidden md:block px-4 py-2 text-primary font-label-caps text-label-caps hover:bg-primary/5 transition-all rounded-lg">Login</a>
                <a href="{{ route('register') }}" target="_blank" rel="noopener noreferrer"
                    class="bg-primary text-on-primary px-6 py-2 rounded-lg font-label-caps text-label-caps hover:opacity-90 transition-all shadow-sm">Signup</a>
            </div>
        </nav>
    </header>
    <main class="pt-16">
        <section class="relative h-[600px] flex items-center justify-center overflow-hidden">
            <div class="absolute inset-0 z-0">
                <img class="w-full h-full object-cover" alt="Aviation hub at dusk"
                    src="{{ asset('images/flight2.jpg') }}" />
                <div class="absolute inset-0 bg-gradient-to-r from-primary/90 to-transparent"></div>
            </div>
            <div class="relative z-10 max-w-container-max mx-auto px-6 lg:px-xl w-full text-white">
                <div class="max-w-2xl space-y-md">
                    <h1 class="font-display-lg text-display-lg md:text-[64px] leading-tight text-white">Your
                        Journey,<br /><span class="text-secondary-container">Our Priority</span></h1>
                    <p class="font-body-lg text-body-lg text-white/80 max-w-lg">Delivering excellence through precision
                        aviation logistics and seamless passenger flights across the continent's most challenging
                        routes.</p>
                    <div class="flex flex-wrap gap-base pt-md">
                        <a href="{{ route('register') }}"
                            class="bg-secondary-container text-on-secondary-container px-8 py-4 rounded-lg font-label-caps text-label-caps hover:opacity-90 transition-all">Book
                            Now</a>
                        <a href="{{ route('admin.login') }}"
                            class="border border-white/40 text-white backdrop-blur-sm px-8 py-4 rounded-lg font-label-caps text-label-caps hover:bg-white/10 transition-all">Agent
                            Login</a>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-xl bg-surface" id="services">
            <div class="max-w-container-max mx-auto px-6 lg:px-xl">
                <div class="flex flex-col md:flex-row justify-between items-end mb-lg gap-md">
                    <div class="space-y-xs">
                        <p class="font-label-caps text-label-caps text-secondary uppercase tracking-widest">Our
                            Expertise</p>
                        <h2 class="font-headline-lg text-headline-lg text-on-surface">Integrated Aviation Services</h2>
                    </div>
                    <div class="h-px bg-outline-variant/30 flex-grow mx-md hidden md:block"></div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-md">
                    <div
                        class="bg-white p-md border border-outline-variant rounded-xl group hover:shadow-xl transition-all duration-300">
                        <div
                            class="w-12 h-12 bg-primary/5 rounded-lg flex items-center justify-center mb-md group-hover:bg-primary transition-colors">
                            <span
                                class="material-symbols-outlined text-primary group-hover:text-white">local_shipping</span>
                        </div>
                        <h3 class="font-headline-md text-headline-md mb-xs">Shipping</h3>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">Global freight solutions with
                            end-to-end tracking and real-time transit updates for your peace of mind.</p>
                    </div>
                    <div
                        class="bg-white p-md border border-outline-variant rounded-xl group hover:shadow-xl transition-all duration-300">
                        <div
                            class="w-12 h-12 bg-primary/5 rounded-lg flex items-center justify-center mb-md group-hover:bg-primary transition-colors">
                            <span class="material-symbols-outlined text-primary group-hover:text-white">bolt</span>
                        </div>
                        <h3 class="font-headline-md text-headline-md mb-xs">Express Delivery</h3>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">Time-sensitive cargo handling with
                            our priority fleet, ensuring documents and parcels arrive on schedule.</p>
                    </div>
                    <div
                        class="bg-white p-md border border-outline-variant rounded-xl group hover:shadow-xl transition-all duration-300">
                        <div
                            class="w-12 h-12 bg-primary/5 rounded-lg flex items-center justify-center mb-md group-hover:bg-primary transition-colors">
                            <span class="material-symbols-outlined text-primary group-hover:text-white">commute</span>
                        </div>
                        <h3 class="font-headline-md text-headline-md mb-xs">Passenger Flights</h3>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">Premium flight services connecting
                            major cities with comfort, safety, and professional on-board hospitality.</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-xl bg-surface-container-low" id="schedule">
            <div class="max-w-container-max mx-auto px-6 lg:px-xl">
                <div class="mb-lg">
                    <h2 class="font-headline-lg text-headline-lg text-primary">Transit Schedule</h2>
                    <p class="font-body-md text-body-md text-on-surface-variant">Active flight departures across our
                        regional and international network.</p>
                </div>
                <div class="bg-white rounded-xl overflow-hidden shadow-sm border border-outline-variant">
                    <table class="w-full text-left">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="p-md font-label-caps text-label-caps">Date</th>
                                <th class="p-md font-label-caps text-label-caps">Day</th>
                                <th class="p-md font-label-caps text-label-caps">Journey</th>
                                <th class="p-md font-label-caps text-label-caps">Departure T.</th>
                                <th class="p-md font-label-caps text-label-caps">Arrival</th>
                            </tr>
                        </thead>
                        <tbody class="font-data-tabular text-data-tabular">
                            @forelse($flights as $flight)
                                <tr class="zebra-row">
                                    <td class="p-md border-b border-outline-variant/30">
                                        {{ $flight->departure_time->format('j/n/y') }}</td>
                                    <td class="p-md border-b border-outline-variant/30 font-semibold">
                                        {{ $flight->departure_time->format('l') }}</td>
                                    <td class="p-md border-b border-outline-variant/30">
                                        {{ $flight->departureAirport->city }} To {{ $flight->arrivalAirport->city }}
                                    </td>
                                    <td class="p-md border-b border-outline-variant/30">
                                        {{ $flight->departure_time->format('g:i a') }}</td>
                                    <td class="p-md border-b border-outline-variant/30">
                                        {{ $flight->arrival_time->format('g:i a') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-md text-center text-on-surface-variant">No active
                                        schedules at this time.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <section class="py-xl bg-surface" id="about">
            <div class="max-w-container-max mx-auto px-6 lg:px-xl grid grid-cols-1 lg:grid-cols-2 gap-xl items-center">
                <div class="space-y-md">
                    <h2 class="font-headline-lg text-headline-lg">Network Coverage</h2>
                    <p class="font-body-md text-body-md text-on-surface-variant">TransRoute operates a comprehensive
                        flight network covering thousands of miles. Our infrastructure is designed for reliability,
                        ensuring that even the most remote locations are integrated into our aviation ecosystem.</p>
                    <div class="bg-white border border-outline-variant rounded-xl overflow-hidden mt-md">
                        <div
                            class="bg-surface-container-high p-4 font-label-caps text-label-caps border-b border-outline-variant text-center">
                            Route Network</div>
                        <div class="grid grid-cols-3 divide-x divide-outline-variant/30">
                            <div class="p-md text-center">Juba</div>
                            <div class="p-md text-center flex items-center justify-center"><span
                                    class="material-symbols-outlined text-primary">sync</span></div>
                            <div class="p-md text-center">Malakal</div>
                            <div class="p-md text-center border-t border-outline-variant/30">Malakal</div>
                            <div
                                class="p-md text-center border-t border-outline-variant/30 flex items-center justify-center">
                                <span class="material-symbols-outlined text-primary">sync</span></div>
                            <div class="p-md text-center border-t border-outline-variant/30">Kodok</div>
                        </div>
                    </div>
                </div>
                <div class="relative h-[400px] rounded-2xl overflow-hidden shadow-2xl">
                    <img class="w-full h-full object-cover" alt="Aerial cargo hub"
                        src="{{ asset('images/flight.jpg') }}" />
                </div>
            </div>
        </section>
        <section class="py-xl bg-primary text-white" id="contact">
            <div class="max-w-container-max mx-auto px-6 lg:px-xl text-center">
                <h2 class="font-headline-lg text-headline-lg mb-md">Ready to Fly?</h2>
                <p class="font-body-lg text-body-lg text-on-primary-container max-w-xl mx-auto mb-lg">Connect with our
                    aviation logistics experts today for a personalized quote or inquiry.</p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-md text-left mb-lg">
                    <div class="bg-white/10 p-md rounded-xl backdrop-blur-md">
                        <span class="material-symbols-outlined mb-xs">location_on</span>
                        <h4 class="font-headline-md text-headline-md text-white mb-2">Office</h4>
                        <p class="font-body-sm text-white/70">Main Terminal, Airport Road<br />Juba, South Sudan</p>
                    </div>
                    <div class="bg-white/10 p-md rounded-xl backdrop-blur-md">
                        <span class="material-symbols-outlined mb-xs">call</span>
                        <h4 class="font-headline-md text-headline-md text-white mb-2">Phone</h4>
                        <p class="font-body-sm text-white/70">+211 912 345 678<br />Toll Free: 0800 555 123</p>
                    </div>
                    <div class="bg-white/10 p-md rounded-xl backdrop-blur-md">
                        <span class="material-symbols-outlined mb-xs">mail</span>
                        <h4 class="font-headline-md text-headline-md text-white mb-2">Email</h4>
                        <p class="font-body-sm text-white/70">contact@transroute.com<br />support@transroute.com</p>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer class="bg-tertiary text-on-tertiary py-12">
        <div
            class="max-w-container-max mx-auto px-6 lg:px-xl flex flex-col md:flex-row justify-between items-center gap-base">
            <div class="flex items-center gap-xs">
                <span class="material-symbols-outlined text-primary-fixed-dim"
                    style="font-variation-settings:'FILL' 1;">flight</span>
                <span class="font-headline-md text-headline-md font-bold">TransRoute</span>
            </div>
            <div class="flex gap-md">
                <a class="font-body-sm text-on-tertiary/80 hover:text-on-tertiary transition-colors"
                    href="#">Privacy Policy</a>
                <a class="font-body-sm text-on-tertiary/80 hover:text-on-tertiary transition-colors"
                    href="#">Terms of Service</a>
                <a class="font-body-sm text-on-tertiary/80 hover:text-on-tertiary transition-colors"
                    href="#">Fleet Details</a>
            </div>
            <p class="font-body-sm text-on-tertiary/60">© {{ date('Y') }} TransRoute Logistics. All rights
                reserved.</p>
        </div>
    </footer>
</body>

</html>
