<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SportX Fest Register</title>
    <Link rel="stylesheet" href="{{ asset('css/style.css')}}">
</head>
<body>
    <div class="container">
        
        <div class="left-section">
            <img src="{{ asset('images/Lari.jpg') }}" alt="">
        </div>

        <div class ="right-section">
            <div class="card">
                
                <div class="logo">
                    <img src="{{ asset('images/LOGO.png') }}" alt="">
                </div>

                <h1> Create Account </h1>
                <p> Join exciting event </p>

                @if(session('success'))
                    <p style="color:green">{{ session('success') }}</p>
                @endif
                
                @if(session('error'))
                    <p style="color:red">{{ session('error') }}</p>
                @endif
                
                <form method="POST" action="/register">
                    @csrf

                    <input type="text" name="name" placeholder="Name" required>
                    <input type="email" name="email" placeholder="Email" required>
                <div class="form-group">
                    <input type="password" id="password" name="password" placeholder="Password" required>
                    <span onclick="togglePassword()" class="toggle-eye">👁️</span>
                </div>

                <div class="form-group">
                    <input type="password" id="confirm_password" name="password_confirmation" placeholder="Confirm Password" required>
                    <span onclick="togglePasswordConfirm()" class="toggle-eye">👁️</span>
                </div>
                    @error('email')
                        <p style="color:red">{{ $message }}</p>
                    @enderror
                    
                    @error('password')
                        <p style="color:red">{{ $message }}</p>
                    @enderror

                    <button type="submit">Register</button>
                </form>

                <p>
                    Already have an account?
                    <a href="/login">Login</a>
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








