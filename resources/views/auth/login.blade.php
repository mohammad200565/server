<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Daleel</title>
    <style>
        :root {
            --offwhite: #f8f4e9;
            --hazel: #c8a87a;
            --brown: #5d4037;
            --light-brown: #8d6e63;
            --dark-hazel: #b3956a;
            --active-color: #7a5c3c;
            --dark-brown: #3e2323ff;
            --light-red: #ff9b9bff
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--offwhite);
            color: var(--brown);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            max-width: 400px;
            width: 90%;
            background: var(--offwhite);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(93, 55, 55, 0.15);
            border: 2px solid var(--hazel);
            overflow: hidden;
        }

        .login-header {
            background-color: var(--hazel);
            padding: 2rem;
            text-align: center;
        }

        .logo {
            font-size: 2rem;
            font-weight: 700;
            color: var(--brown);
            text-decoration: none;
        }

        .login-body {
            padding: 2rem;
        }

        .welcome-text {
            text-align: center;
            margin-bottom: 2rem;
        }

        .welcome-text h2 {
            color: var(--brown);
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .welcome-text p {
            color: var(--light-brown);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            color: var(--brown);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid var(--light-brown);
            border-radius: 8px;
            background: white;
            color: var(--brown);
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--hazel);
            box-shadow: 0 0 0 3px rgba(200, 168, 122, 0.2);
        }

        .form-input::placeholder {
            color: var(--light-brown);
            opacity: 0.7;
        }

        .login-btn {
            width: 100%;
            background-color: var(--brown);
            color: var(--offwhite);
            border: none;
            padding: 0.75rem;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 1rem;
        }

        .login-btn:hover {
            background-color: var(--dark-brown);
            transform: translateY(-2px);
        }

        .forgot-password {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .forgot-link {
            color: var(--light-brown);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .forgot-link:hover {
            color: var(--brown);
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
            color: var(--light-brown);
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid var(--light-brown);
            opacity: 0.3;
        }

        .divider span {
            padding: 0 1rem;
            font-size: 0.9rem;
        }

        .social-login {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .social-btn {
            flex: 1;
            padding: 0.75rem;
            border: 2px solid var(--light-brown);
            border-radius: 8px;
            background: white;
            color: var(--brown);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .social-btn:hover {
            border-color: var(--hazel);
            background-color: var(--offwhite);
        }

        .signup-link {
            text-align: center;
            color: var(--light-brown);
        }

        .signup-link a {
            color: var(--brown);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .signup-link a:hover {
            color: var(--dark-brown);
        }

        .error-message {
            background-color: var(--light-red);
            border: 1px solid var(--light-brown);
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            color: var(--brown);
            text-align: center;
            font-size: 1.3rem;
            font-weight: 600;
            font-style: oblique;
        }

        @media (max-width: 480px) {
            .login-container {
                width: 95%;
            }
            
            .login-body {
                padding: 1.5rem;
            }
            
            .social-login {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Header -->
        <div class="login-header">
            <div class="logo">Daleel Admin</div>
        </div>

        <!-- Login Form -->
        <div class="login-body">
            <div class="welcome-text">
                <h2>Welcome Back</h2>
                <p>Sign in to your Daleel account</p>
            </div>

            <!-- Error Message (optional) -->
            @if($errors->any())
                <div class="error-message text-3xl">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="/login" method="POST">
                @csrf
                
                <!-- Email Input -->
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input 
                        id="email" 
                        name="email" 
                        type="email" 
                        required 
                        class="form-input"
                        placeholder="Enter your email"
                        value="{{ old('email') }}"
                    >
                </div>

                <!-- Password Input -->
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input 
                        id="password"
                        name="password" 
                        type="password" 
                        required 
                        class="form-input"
                        placeholder="Enter your password"
                    >
                </div>

                <!-- Login Button -->
                <button type="submit" class="login-btn">
                    Sign In
                </button>
            </form>
        </div>
    </div>
</body>
</html>