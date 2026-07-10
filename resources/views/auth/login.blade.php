<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SportXFest</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <div class="container">

        <div class="left-section">
            <img src="{{ asset('images/lari.png') }}" alt="">
        </div>

        <div class ="right-section">
            <div class="card">

                <div class="logo">
                    <img src="{{ asset('images/LOGO.png') }}" alt="">
                </div>

                <h1>Welcome Back</h1>
                <p>Login to join exciting event</p>
                
                @if(session('error'))
                    <p style="color:red">{{ session('error') }}</p>
                @endif
                
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                    <div class="form-group">
                        <input type="password" id="password" name="password" placeholder="Password" required>
                        <span onclick="togglePassword()" class="toggle-eye">👁️</span>
                    </div>
                    @error('email')
                        <p style="color:red;font-size:.8rem;margin-top:-8px;margin-bottom:8px;">{{ $message }}</p>
                    @enderror
                    @error('password')
                        <p style="color:red;font-size:.8rem;margin-top:-8px;margin-bottom:8px;">{{ $message }}</p>
                    @enderror
                    <button type="submit">Login</button>
                </form>

                <p>
                    Don't have an account?
                    <a href="{{ route('register') }}">Register</a>
                </p>
            </div>
        </div>
    </div>
    
<script>
function togglePassword() {
    const input = document.getElementById("password");
    input.type = input.type === "password" ? "text" : "password";
}
</script>
</body>
</html>