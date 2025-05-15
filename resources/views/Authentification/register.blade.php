<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Walsa Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .register-container {
            display: flex;
            height: 100vh;
        }
        .hotel-image {
            flex: 1;
            background-image: url('/images/log_reg.jpg');
            background-size: cover;
            background-position: center;
        }
        .register-form {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 0 12%;
            overflow-y: auto;
        }
        .register-title {
            font-size: 3.5rem;
            font-weight: bold;
            margin-bottom: 2rem;
            text-align: center;
            display: inline-block;
            padding-bottom: 0.25rem;
            width: auto;
        }
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
        }
        .form-input {
            width: 100%;
            padding: 0.75rem;
            margin: 0 0 2rem;  /* Increased bottom margin for more vertical space */
            border-radius: 0.5rem;  /* More rounded corners */
            background-color: #e5e5e5;
            border: none;
        }
        .register-btn {
            width: 100%;
            padding: 0.75rem;
            background-color: #4052b5;
            color: white;
            border: none;
            border-radius: 0.5rem;  /* More rounded corners for button too */
            font-size: 1rem;
            cursor: pointer;
            margin-top: 0.5rem;
            margin-bottom: 1.5rem;
        }
        .register-btn:hover {
            background-color: #3545a5;
        }
        .login-text {
            text-align: center;
            font-size: 0.95rem;
        }
        .login-link {
            color: #4052b5;
            text-decoration: none;
            font-weight: bold;
        }
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem  3rem;  /* Vertical gap 1rem, horizontal gap 1.5rem */
        }
        .form-full-width {
            grid-column: span 2;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="hotel-image"></div>
        <div class="register-form">
            <h1 class="register-title">Register</h1>
            
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

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-grid">
                    <div>
                        <label class="form-label" for="prenom">First Name</label>
                        <input id="prenom" class="form-input" type="text" name="prenom" value="{{ old('prenom') }}" required />
                    </div>

                    <div>
                        <label class="form-label" for="nom">Last Name</label>
                        <input id="nom" class="form-input" type="text" name="nom" value="{{ old('nom') }}" required />
                    </div>
                
                    <div>
                        <label class="form-label" for="email">E-mail</label>
                        <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required />
                    </div>

                    <div>
                        <label class="form-label" for="telephone">Telephone</label>
                        <input id="telephone" class="form-input" type="tel" name="telephone" value="{{ old('telephone') }}" />
                    </div>

                    <div>
                        <label class="form-label" for="date_naissance">Date of birth</label>
                        <input id="date_naissance" class="form-input" type="date" name="date_naissance" value="{{ old('date_naissance') }}" />
                    </div>

                    <div>
                        <label class="form-label" for="adresse">Address</label>
                        <input id="adresse" class="form-input" type="text" name="adresse" value="{{ old('adresse') }}" />
                    </div>

                    <div>
                        <label class="form-label" for="password">Password</label>
                        <input id="password" class="form-input" type="password" name="password" required />
                    </div>

                    <div>
                        <label class="form-label" for="password_confirmation">password confirmation</label>
                        <input id="password_confirmation" class="form-input" type="password" name="password_confirmation" required />
                    </div>
                </div>

                <button type="submit" class="register-btn">Register</button>
            </form>

            <div class="login-text">
                Do you already have an account? <a href="{{ route('login') }}" class="login-link">Log in</a>
            </div>
        </div>
    </div>
</body>
</html>