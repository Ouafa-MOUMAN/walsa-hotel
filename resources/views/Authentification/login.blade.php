<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Walsa Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .login-container {
            display: flex;
            height: 100vh;
        }
        .hotel-image {
            flex: 1;
            background-image: url('/images/log_reg.jpg');
            background-size: cover;
            background-position: center;
        }
        .login-form {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 0 10%;
        }
        .login-title {
            font-size: 3rem;
            font-weight: 400;
            color: #000000;
            margin: 0 0 20px 0;
            padding: 0;
            border: none;
            position: relative;
            display: block;
            text-align: center; /* Changement: centrage du texte */
        }
        .form-input {
            width: 100%;
            padding: 1rem;
            margin: 0.5rem 0 1.5rem;
            border-radius: 0.375rem;
            background-color: #e5e5e5;
            border: none;
        }
        .login-btn {
            width: 100%;
            padding: 1rem;
            background-color: #3b49df;
            color: white;
            border: none;
            border-radius: 0.375rem;
            font-size: 1rem;
            cursor: pointer;
            margin-top: 1rem;
            margin-bottom: 1.5rem;
        }
        .login-btn:hover {
            background-color: #2a37c0;
        }
        .forgot-password {
            text-align: center;
            color: #3b49df;
            text-decoration: none;
            margin-bottom: 1rem;
        }
        .register-text {
            text-align: center;
        }
        .register-link {
            color: #3b49df;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="hotel-image"></div>
        <div class="login-form">
            <h1 class="login-title">Log in</h1>
            
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div>
                    <label for="email">E-mail</label>
                    <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autofocus />
                </div>
                
                <div>
                    <label for="password">Password</label>
                    <input id="password" class="form-input" type="password" name="password" required />
                </div>
                
                <button type="submit" class="login-btn">Log in</button>
            </form>
            
            <div class="forgot-password">
                <a href="{{ route('password.request') }}">Forgot password?</a>
            </div>
            
            <div class="register-text">
                Don't have an account? <a href="{{ route('register') }}" class="register-link">Register</a>
            </div>
        </div>
    </div>
</body>
</html>