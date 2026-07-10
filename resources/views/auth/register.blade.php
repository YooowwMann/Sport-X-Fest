<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SportXFest</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <div class="container">

        <div class="left-section">
            <img src="{{ asset('images/Lari.jpg') }}" alt="SportXFest">
        </div>

        <div class="right-section">
            <div class="card">

                <div class="logo">
                    <img src="{{ asset('images/LOGO.png') }}" alt="Logo">
                </div>

                <h1>Create Account</h1>
                <p>Join exciting events</p>

                @if(session('success'))
                    <p style="color:green;font-size:.85rem;">{{ session('success') }}</p>
                @endif
                @if(session('error'))
                    <p style="color:red;font-size:.85rem;">{{ session('error') }}</p>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    {{-- Nama --}}
                    <input type="text" name="name"
                           placeholder="Full Name"
                           value="{{ old('name') }}"
                           required>
                    @error('name')
                        <p style="color:red;font-size:.8rem;margin-top:-8px;margin-bottom:8px;">{{ $message }}</p>
                    @enderror

                    {{-- Email --}}
                    <input type="email" name="email"
                           placeholder="Email"
                           value="{{ old('email') }}"
                           required>
                    @error('email')
                        <p style="color:red;font-size:.8rem;margin-top:-8px;margin-bottom:8px;">{{ $message }}</p>
                    @enderror

                    {{-- No. Telepon --}}
                    <input type="tel" name="phone"
                           placeholder="No. Telepon (contoh: 08123456789)"
                           value="{{ old('phone') }}"
                           pattern="[0-9+\-\s]{9,20}"
                           required>
                    @error('phone')
                        <p style="color:red;font-size:.8rem;margin-top:-8px;margin-bottom:8px;">{{ $message }}</p>
                    @enderror

                    {{-- Password --}}
                    <div class="form-group">
                        <input type="password" id="password" name="password"
                               placeholder="Password" required>
                        <span onclick="togglePassword()" class="toggle-eye">👁️</span>
                    </div>
                    @error('password')
                        <p style="color:red;font-size:.8rem;margin-top:-8px;margin-bottom:8px;">{{ $message }}</p>
                    @enderror

                    {{-- Confirm Password --}}
                    <div class="form-group">
                        <input type="password" id="confirm_password" name="password_confirmation"
                               placeholder="Confirm Password" required>
                        <span onclick="togglePasswordConfirm()" class="toggle-eye">👁️</span>
                    </div>

                    <button type="submit">Register</button>
                </form>

                <p>
                    Already have an account?
                    <a href="{{ route('login') }}">Login</a>
                </p>

            </div>
        </div>
    </div>

<script>
function togglePassword() {
    const input = document.getElementById("password");
    input.type = input.type === "password" ? "text" : "password";
}
function togglePasswordConfirm() {
    const input = document.getElementById("confirm_password");
    input.type = input.type === "password" ? "text" : "password";
}
</script>
</body>
</html>
