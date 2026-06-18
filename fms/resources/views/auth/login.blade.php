<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Passenger Login — TransRoute</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@600;700&family=Inter:wght@400;500&family=IBM+Plex+Sans:wght@400;600&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <style>
        .material-symbols-outlined {
            vertical-align: middle;
        }
    </style>
</head>

<body
    style="background:linear-gradient(135deg,#00355f,#001f3c);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px;font-family:Inter,sans-serif">
    <div style="width:100%;max-width:28rem">
        <div style="text-align:center;margin-bottom:2rem">
            <span class="material-symbols-outlined" style="color:#a3c9fc;font-size:2.5rem">flight</span>
            <h1
                style="color:#fff;font-family:'Hanken Grotesk',sans-serif;font-size:1.75rem;font-weight:700;margin-top:.5rem">
                TransRoute</h1>
            <p style="color:rgba(255,255,255,.6);font-size:.875rem">Passenger Portal</p>
        </div>
        <div
            style="background:#fff;border-radius:.75rem;box-shadow:0 25px 50px -12px rgba(0,0,0,.5);overflow:hidden;padding:2rem">
            <h3
                style="font-family:'Hanken Grotesk',sans-serif;font-size:1.5rem;font-weight:600;color:#00355f;margin-bottom:.5rem;text-align:center">
                Welcome Back</h3>
            <p style="font-size:.875rem;color:#42474f;margin-bottom:1.5rem;text-align:center">Enter your credentials to
                access your account</p>
            <form method="POST" action="{{ route('login') }}" style="display:flex;flex-direction:column;gap:1rem">
                @csrf
                <div>
                    <label
                        style="display:block;font-size:12px;font-weight:600;letter-spacing:.05em;margin-bottom:.25rem;text-transform:uppercase">Email
                        Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        style="width:100%;padding:.75rem;border:1px solid #c2c7d1;border-radius:.5rem;outline:none"
                        placeholder="name@example.com" />
                </div>
                <div>
                    <label
                        style="display:block;font-size:12px;font-weight:600;letter-spacing:.05em;margin-bottom:.25rem;text-transform:uppercase">Password</label>
                    <input type="password" name="password" required
                        style="width:100%;padding:.75rem;border:1px solid #c2c7d1;border-radius:.5rem;outline:none"
                        placeholder="••••••••" />
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;font-size:.875rem">
                    <label style="display:flex;align-items:center;gap:.5rem"><input type="checkbox" name="remember">
                        <span>Remember me</span></label>
                </div>
                <button type="submit"
                    style="width:100%;background:#00355f;color:#fff;padding:1rem;border-radius:.5rem;font-weight:600;font-size:12px;letter-spacing:.05em;text-transform:uppercase;border:none;cursor:pointer">
                    Login Now
                </button>
            </form>
            <p style="margin-top:1.5rem;font-size:.875rem;color:#42474f;text-align:center">Don't have an account? <a
                    href="{{ route('register') }}" style="color:#00355f;font-weight:700;text-decoration:underline">Sign
                    up</a></p>
            <p style="margin-top:.75rem;font-size:.75rem;color:#94a3b8;text-align:center"><a
                    href="{{ route('admin.login') }}" style="color:#a04100">Administrator Login →</a></p>
        </div>
    </div>
</body>

</html>
