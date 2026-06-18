<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8" />
<meta content="width=device-width, initial-scale=1.0" name="viewport" />
<title>@yield('title','Dashboard') — TransRoute</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=IBM+Plex+Sans:wght@400;600&family=Hanken+Grotesk:wght@600;700&display=swap" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
<style>
.glass-nav{backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px);}
.material-symbols-outlined{font-variation-settings:'FILL' 0,'wght' 400,'GRAD' 0,'opsz' 24;}
.sidebar-active-item{background-color:rgba(254,107,0,1);color:white;}
.sidebar-active-item .material-symbols-outlined{font-variation-settings:'FILL' 1;}
.custom-scrollbar::-webkit-scrollbar{width:6px;}
.custom-scrollbar::-webkit-scrollbar-track{background:transparent;}
.custom-scrollbar::-webkit-scrollbar-thumb{background:#cbd5e1;border-radius:10px;}
[x-cloak]{display:none!important;}
</style>
<script id="tailwind-config">
tailwind.config = {
    darkMode: "class",
    theme: { extend: {
        "colors": {
            "on-surface-variant":"#42474f","primary-fixed-dim":"#a3c9fc","inverse-primary":"#a3c9fc","surface-variant":"#e0e3e5",
            "surface-container-high":"#e5e9eb","on-secondary-fixed-variant":"#7a3000","on-primary-fixed-variant":"#1e4973",
            "surface-tint":"#39608d","secondary-container":"#fe6b00","primary":"#001f3c","surface-bright":"#f7fafc","surface":"#f7fafc",
            "on-secondary":"#ffffff","secondary-fixed":"#ffdbcc","on-primary":"#ffffff","error":"#ba1a1a","background":"#f7fafc",
            "on-tertiary-fixed-variant":"#3d4759","secondary":"#a04100","tertiary":"#151f2f","surface-container-lowest":"#ffffff",
            "on-surface":"#181c1e","outline-variant":"#c2c7d1","inverse-surface":"#2d3133","surface-container-highest":"#e0e3e5",
            "outline":"#73777f","tertiary-fixed-dim":"#bdc7dc","surface-container-low":"#f1f4f6","on-tertiary-container":"#929cb1",
            "error-container":"#ffdad6","on-tertiary":"#ffffff","on-error-container":"#93000a","on-secondary-container":"#572000",
            "on-background":"#181c1e","on-tertiary-fixed":"#121c2c","on-primary-container":"#799fcf","surface-container":"#ebeef0",
            "primary-fixed":"#d2e4ff","tertiary-fixed":"#d9e3f9","on-primary-fixed":"#001c37","tertiary-container":"#2a3445",
            "surface-dim":"#d7dadc","on-error":"#ffffff"
        },
        "borderRadius": {"DEFAULT":"0.25rem","lg":"0.5rem","xl":"0.75rem","full":"9999px"},
        "spacing": {"lg":"48px","gutter":"24px","md":"24px","xl":"80px","base":"8px","xs":"4px","margin-mobile":"16px","sm":"12px","container-max":"1280px"},
        "fontFamily": {"headline-lg":["Hanken Grotesk"],"data-tabular":["IBM Plex Sans"],"body-lg":["Inter"],"label-caps":["IBM Plex Sans"],"display-lg":["Hanken Grotesk"],"headline-md":["Hanken Grotesk"],"body-md":["Inter"]},
        "fontSize": {
            "headline-lg":["32px",{"lineHeight":"40px","letterSpacing":"-0.01em","fontWeight":"600"}],"data-tabular":["14px",{"lineHeight":"20px","fontWeight":"400"}],
            "body-lg":["18px",{"lineHeight":"28px","fontWeight":"400"}],"label-caps":["12px",{"lineHeight":"16px","letterSpacing":"0.05em","fontWeight":"600"}],
            "display-lg":["48px",{"lineHeight":"56px","letterSpacing":"-0.02em","fontWeight":"700"}],"headline-md":["24px",{"lineHeight":"32px","fontWeight":"600"}],
            "body-md":["16px",{"lineHeight":"24px","fontWeight":"400"}]
        }
    }},
}
</script>
</head>
<body class="bg-surface text-on-surface font-body-md overflow-x-hidden">
<aside class="h-screen w-64 fixed left-0 top-0 bg-primary border-r border-outline-variant/30 shadow-sm flex flex-col p-md gap-base z-50 hidden md:flex">
    <div class="mb-lg">
        <h1 class="font-display-lg text-[24px] leading-tight font-bold text-on-primary">TransRoute</h1>
        <p class="font-label-caps text-label-caps text-on-primary/60">Kinetic Logistics</p>
    </div>
    <nav class="flex-1 flex flex-col gap-xs">
        @php $r = request()->route()->getName(); @endphp
        <a href="{{ route('passenger.dashboard') }}" class="nav-item flex items-center gap-base p-base rounded-lg transition-colors duration-200 {{ $r==='passenger.dashboard' ? 'sidebar-active-item' : 'text-on-primary/70 hover:text-on-primary hover:bg-primary-container' }}">
            <span class="material-symbols-outlined">dashboard</span><span class="font-label-caps text-label-caps">Dashboard</span>
        </a>
        <a href="{{ route('passenger.schedule.index') }}" class="nav-item flex items-center gap-base p-base rounded-lg transition-colors duration-200 {{ str_starts_with($r,'passenger.schedule') ? 'sidebar-active-item' : 'text-on-primary/70 hover:text-on-primary hover:bg-primary-container' }}">
            <span class="material-symbols-outlined">calendar_month</span><span class="font-label-caps text-label-caps">Schedule</span>
        </a>
        <a href="{{ route('passenger.bookings.index') }}" class="nav-item flex items-center gap-base p-base rounded-lg transition-colors duration-200 {{ str_starts_with($r,'passenger.bookings') ? 'sidebar-active-item' : 'text-on-primary/70 hover:text-on-primary hover:bg-primary-container' }}">
            <span class="material-symbols-outlined">confirmation_number</span><span class="font-label-caps text-label-caps">My Bookings</span>
        </a>
        <a href="{{ route('passenger.luggage.index') }}" class="nav-item flex items-center gap-base p-base rounded-lg transition-colors duration-200 {{ str_starts_with($r,'passenger.luggage') ? 'sidebar-active-item' : 'text-on-primary/70 hover:text-on-primary hover:bg-primary-container' }}">
            <span class="material-symbols-outlined">luggage</span><span class="font-label-caps text-label-caps">Luggage</span>
        </a>
        <a href="{{ route('passenger.shipping.index') }}" class="nav-item flex items-center gap-base p-base rounded-lg transition-colors duration-200 {{ str_starts_with($r,'passenger.shipping') ? 'sidebar-active-item' : 'text-on-primary/70 hover:text-on-primary hover:bg-primary-container' }}">
            <span class="material-symbols-outlined">local_shipping</span><span class="font-label-caps text-label-caps">Shipping</span>
        </a>
    </nav>
    <div class="pt-base border-t border-outline-variant/30 mt-md flex flex-col gap-xs">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-base p-base rounded-lg text-on-primary/70 hover:text-on-primary hover:bg-primary-container transition-colors">
                <span class="material-symbols-outlined">logout</span><span class="font-label-caps text-label-caps">Logout</span>
            </button>
        </form>
    </div>
</aside>
<header class="fixed top-0 right-0 w-full md:w-[calc(100%-16rem)] h-16 bg-surface/80 backdrop-blur-md border-b border-outline-variant/30 glass-nav z-40 flex justify-between items-center px-gutter">
    <div class="flex items-center gap-lg flex-1">
        <h2 class="font-headline-md text-headline-md font-bold text-primary">TransRoute</h2>
    </div>
    <div class="flex items-center gap-md">
        <div class="h-8 w-8 rounded-full bg-primary overflow-hidden border border-outline-variant flex items-center justify-center text-on-primary font-bold text-xs">
            {{ strtoupper(substr(auth()->user()->name,0,1)) }}
        </div>
    </div>
</header>
<main class="pt-24 pb-xl px-margin-mobile md:px-gutter ml-0 md:ml-64 min-h-screen">
    <div class="max-w-container-max mx-auto space-y-gutter">
        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-md py-sm rounded-lg text-sm flex items-center gap-2">
            <span class="material-symbols-outlined text-green-600 text-base">check_circle</span> {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 px-md py-sm rounded-lg text-sm flex items-center gap-2">
            <span class="material-symbols-outlined text-red-600 text-base">error</span> {{ session('error') }}
        </div>
        @endif
        @yield('content')
    </div>
</main>
<nav class="fixed bottom-0 w-full z-50 rounded-t-xl bg-surface border-t border-outline-variant/30 shadow-lg flex md:hidden justify-around items-center h-16 px-margin-mobile">
    <a href="{{ route('passenger.dashboard') }}" class="flex flex-col items-center justify-center {{ $r==='passenger.dashboard'?'text-secondary':'text-on-surface-variant' }}">
        <span class="material-symbols-outlined">home</span><span class="font-label-caps text-[10px] uppercase">Home</span>
    </a>
    <a href="{{ route('passenger.bookings.index') }}" class="flex flex-col items-center justify-center {{ str_starts_with($r,'passenger.bookings')?'text-secondary':'text-on-surface-variant' }}">
        <span class="material-symbols-outlined">airplane_ticket</span><span class="font-label-caps text-[10px] uppercase">Bookings</span>
    </a>
    <a href="{{ route('passenger.shipping.index') }}" class="flex flex-col items-center justify-center {{ str_starts_with($r,'passenger.shipping')?'text-secondary':'text-on-surface-variant' }}">
        <span class="material-symbols-outlined">local_shipping</span><span class="font-label-caps text-[10px] uppercase">Cargo</span>
    </a>
</nav>
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@stack('scripts')
</body>
</html>
