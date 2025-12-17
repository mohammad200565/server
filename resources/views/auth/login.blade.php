<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Daleel Admin</title>

    <!-- Premium Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            /* Palette */
            --primary: #5d4037;
            --primary-hover: #4a332a;
            --primary-soft: #8d6e63;
            
            --gold: #c8a87a;
            --gold-light: #f5efe6;
            
            --bg-body: #f9f8f6;
            --bg-card: #ffffff;
            
            /* Shadows & Radius */
            --shadow-soft: 0 10px 40px -10px rgba(93, 64, 55, 0.08);
            --radius-xl: 24px;
            --radius-md: 12px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: var(--bg-body);
            color: var(--primary);
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* --- Login Card --- */
        .login-container {
            width: 100%;
            max-width: 440px;
            background: var(--bg-card);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-soft);
            padding: 40px;
            border: 1px solid rgba(255,255,255,0.6);
            margin: 20px;
        }

        /* --- Header Section --- */
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo {
            font-size: 24px;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 10px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            letter-spacing: -0.5px;
        }

        .logo::after {
            content: '';
            width: 8px;
            height: 8px;
            background: var(--gold);
            border-radius: 50%;
        }

        .welcome-text h2 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .welcome-text p {
            color: #999;
            font-size: 14px;
        }

        /* --- Form Elements --- */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            font-size: 14px;
            border: 2px solid #eee;
            border-radius: var(--radius-md);
            background: #fcfcfc;
            color: var(--primary);
            font-family: inherit;
            transition: all 0.2s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--gold);
            background: white;
            box-shadow: 0 0 0 4px var(--gold-light);
        }

        .form-input::placeholder {
            color: #ccc;
        }

        /* --- Button --- */
        .login-btn {
            width: 100%;
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 14px;
            border-radius: var(--radius-pill); /* Using pill shape for buttons */
            border-radius: 50px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .login-btn:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(93, 64, 55, 0.2);
        }

        /* --- Error Message --- */
        .error-message {
            background-color: #fef2f2;
            border: 1px solid #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: var(--radius-md);
            font-size: 13px;
            font-weight: 500;
            text-align: center;
            margin-bottom: 20px;
        }

        /* --- Footer Links --- */
        .login-footer {
            margin-top: 25px;
            text-align: center;
            font-size: 13px;
            color: #aaa;
        }
        
        .login-footer a {
            color: var(--gold);
            text-decoration: none;
            font-weight: 600;
        }
        .login-footer a:hover { text-decoration: underline; }

    </style>
</head>
<body>

    <div class="login-container">
        
        <div class="login-header">
            <div class="logo">Daleel Admin</div>
            <div class="welcome-text">
                <h2>Welcome Back</h2>
                <p>Please enter your details to sign in.</p>
            </div>
        </div>

        <!-- Error Message -->
        @if($errors->any())
            <div class="error-message">
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
                    placeholder="name@example.com"
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

            <!-- Submit Button -->
            <button type="submit" class="login-btn">
                Sign In
            </button>
        </form>

        <div class="login-footer">
            &copy; 2026 Daleel. All rights reserved.
        </div>

    </div>

</body>
</html>
