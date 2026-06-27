<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SportX Fest Login </title>
    <Link rel="stylesheet" href="{{ asset('css/style.css')}}">
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
                
                <form method="POST" action="/login">
                    @csrf
                    <input type="email" name="email" placeholder="Email" required>
                    <div style="position:relative;">
                        <input type="password" id="password" name="password" placeholder="Password" required>
                        <span onclick="togglePassword()" style="position:absolute;right:10px;top:15%;transform:translateY(-15%);cursor:pointer;">
                        👁️
                        </span>
                    </div>
                    @error('email')
                        <p style="color:red">{{ $message }}</p>
                    @enderror
                    
                    @error('password')
                        <p style="color:red">{{ $message }}</p>
                    @enderror
                    <button type="submit">Login</button>
                </form>

                <p>
                    Don't have an account?
                    <a href="/register">Register</a>
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