<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" /><meta content="width=device-width, initial-scale=1.0" name="viewport" />
<title>Admin Login — TransRoute</title>
<script src="https://cdn.tailwindcss.com?plugins=forms"></script>
<link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@600;700&family=Inter:wght@400;500&family=IBM+Plex+Sans:wght@400;600&display=swap" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
<style>.material-symbols-outlined{vertical-align:middle;}</style>
</head>
<body style="background:linear-gradient(135deg,#001f3c,#151f2f);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px;font-family:Inter,sans-serif">
<div style="width:100%;max-width:28rem">
    <div style="text-align:center;margin-bottom:2rem">
        <span class="material-symbols-outlined" style="color:#fe6b00;font-size:2.5rem">admin_panel_settings</span>
        <h1 style="color:#fff;font-family:'Hanken Grotesk',sans-serif;font-size:1.75rem;font-weight:700;margin-top:.5rem">TransRoute</h1>
        <p style="color:rgba(255,255,255,.6);font-size:.875rem">Administrator Portal</p>
    </div>
    <div style="background:#fff;border-radius:.75rem;box-shadow:0 25px 50px -12px rgba(0,0,0,.5);overflow:hidden;padding:2rem">
        <h3 style="font-family:'Hanken Grotesk',sans-serif;font-size:1.5rem;font-weight:600;color:#001f3c;margin-bottom:.5rem;text-align:center">Admin Sign In</h3>
        <p style="font-size:.875rem;color:#42474f;margin-bottom:1.5rem;text-align:center">Restricted access — authorized personnel only</p>
        <form method="POST" action="{{ route('admin.login') }}" style="display:flex;flex-direction:column;gap:1rem">
            @csrf
            <div>
                <label style="display:block;font-size:12px;font-weight:600;letter-spacing:.05em;margin-bottom:.25rem;text-transform:uppercase">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                    style="width:100%;padding:.75rem;border:1px solid #c3c6d0;border-radius:.5rem;outline:none"
                    placeholder="admin@transroute.com" />
            </div>
            <div>
                <label style="display:block;font-size:12px;font-weight:600;letter-spacing:.05em;margin-bottom:.25rem;text-transform:uppercase">Password</label>
                <input type="password" name="password" required
                    style="width:100%;padding:.75rem;border:1px solid #c3c6d0;border-radius:.5rem;outline:none"
                    placeholder="••••••••" />
            </div>
            <button type="submit" style="width:100%;background:#fe6b00;color:#572000;padding:1rem;border-radius:.5rem;font-weight:700;font-size:12px;letter-spacing:.05em;text-transform:uppercase;border:none;cursor:pointer">
                Access Admin Console
            </button>
        </form>
        <p style="margin-top:1.5rem;font-size:.75rem;color:#94a3b8;text-align:center"><a href="{{ route('login') }}" style="color:#001f3c">← Passenger Login</a></p>
    </div>
</div>
</body>
</html>
