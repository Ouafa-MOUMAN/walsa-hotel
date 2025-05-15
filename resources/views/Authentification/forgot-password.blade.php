
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Walsa Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .forgot-container {
            display: flex;
            height: 100vh;
        }
        .hotel-image {
            flex: 1;
            background-image: url('/images/log_reg.jpg');
            background-size: cover;
            background-position: center;
        }
        .forgot-form {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 0 10%;
            
        }
        .forgot-title {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 2rem;
           
            display: inline-block;
            padding-bottom: 0.5rem;
            text-align: center
        }
        .form-input {
            width: 100%;
            padding: 1rem;
            margin: 0.5rem 0 1.5rem;
            border-radius: 0.375rem;
            background-color: #e5e5e5;
            border: none;
        }
        .forgot-btn {
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
        .forgot-btn:hover {
            background-color: #2a37c0;
        }
        .login-text {
            text-align: center;
        }
        .login-link {
            color: #3b49df;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="forgot-container">
        <div class="hotel-image"></div>
        <div class="forgot-form">
            <h1 class="forgot-title">Reset Password</h1>
            
            @if (session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('status') }}
                </div>
            @endif
            
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <p class="mb-4">
                Forgot your password? No problem. Just let us know your email address and we will email you a password reset link.
            </p>

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div>
                    <label for="email">E-mail</label>
                    <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autofocus />
                </div>

                <button type="submit" class="forgot-btn">Send Password Reset Link</button>
            </form>

            <div class="login-text">
                Remember your password? <a href="{{ route('login') }}" class="login-link">Log in</a>
            </div>
        </div>
    </div>
</body>
</html>