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

    <script>
        // Check for saved theme preference immediately to prevent flash
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <style>
        :root {
            /* --- LIGHT THEME VARIABLES --- */
            --primary: #5d4037;
            --primary-grad: linear-gradient(135deg, #5d4037 0%, #8d6e63 100%);
            --gold: #c8a87a;
            --gold-glow: rgba(200, 168, 122, 0.5);
            
            --bg-body: #f3f4f6;
            --bg-card: rgba(255, 255, 255, 0.8);
            --text-main: #1f2937;
            --text-sub: #6b7280;
            --border-color: #e5e7eb;
            --input-bg: rgba(255, 255, 255, 0.5);
            --shadow-card: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
            --btn-text: #ffffff;
        }

        /* --- DARK THEME VARIABLES --- */
        :root.dark {
            --bg-body: #0f172a;
            --bg-card: rgba(30, 41, 59, 0.6);
            --text-main: #f8fafc;
            --text-sub: #94a3b8;
            --border-color: #334155;
            --input-bg: rgba(15, 23, 42, 0.4);
            
            /* Gold becomes primary in dark mode for visibility */
            --primary: #c8a87a; 
            --primary-grad: linear-gradient(135deg, #c8a87a 0%, #a88b5d 100%);
            --shadow-card: 0 25px 50px -12px rgba(0, 0, 0, 0.6);
            --btn-text: #0f172a;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--bg-body);
            color: var(--text-main);
            overflow: hidden;
            position: relative;
            transition: background-color 0.5s ease, color 0.5s ease;
        }

        /* --- BACKGROUND ANIMATION --- */
        .background-blobs {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px); /* Sharper blur for more visibility */
            opacity: 0.7;
            animation: moveOrb 8s infinite alternate ease-in-out;
        }

        .blob-1 {
            top: -10%; left: -10%; width: 50vw; height: 50vw;
            background: var(--primary);
            animation-duration: 12s;
        }
        
        .blob-2 {
            bottom: -10%; right: -10%; width: 40vw; height: 40vw;
            background: var(--gold);
            animation-duration: 9s;
            animation-delay: -2s;
        }

        @keyframes moveOrb {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(50px, 80px) scale(1.1); }
        }

        /* --- TOGGLE BUTTON --- */
        .theme-toggle-wrapper {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 50;
        }

        .theme-toggle-btn {
            background: var(--bg-card);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border-color);
            color: var(--text-main);
            width: 48px;
            height: 48px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .theme-toggle-btn:hover {
            transform: scale(1.1) rotate(15deg);
            border-color: var(--gold);
            color: var(--gold);
        }

        /* --- LOGIN CARD --- */
        .login-container {
            width: 100%;
            max-width: 420px;
            background: var(--bg-card);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 32px;
            padding: 48px;
            box-shadow: var(--shadow-card);
            position: relative;
            z-index: 10;
            
            /* Continuous Floating Animation */
            animation: floatCard 6s ease-in-out infinite;
        }

        /* Entrance Animation handled by JS/CSS class usually, but pure CSS here: */
        .login-container {
            animation: 
                entranceCard 1s cubic-bezier(0.2, 0.8, 0.2, 1) forwards,
                floatCard 6s ease-in-out 1s infinite; /* Wait 1s then float */
        }

        @keyframes entranceCard {
            from { opacity: 0; transform: translateY(50px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        @keyframes floatCard {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }

        /* --- HEADER --- */
        .login-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .logo {
            font-size: 26px;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 8px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .logo-icon {
            width: 12px; height: 12px;
            background: var(--gold);
            border-radius: 50%;
            box-shadow: 0 0 15px var(--gold);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.5); opacity: 0.5; }
            100% { transform: scale(1); opacity: 1; }
        }

        /* --- FORM --- */
        .form-group {
            margin-bottom: 24px;
            position: relative;
            transform-origin: left;
            animation: slideIn 0.5s ease-out forwards;
            opacity: 0;
        }
        
        .form-group:nth-child(1) { animation-delay: 0.2s; }
        .form-group:nth-child(2) { animation-delay: 0.3s; }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 8px;
            margin-left: 4px;
            transition: color 0.3s;
        }

        .form-input {
            width: 100%;
            padding: 16px 18px;
            font-size: 15px;
            border: 2px solid var(--border-color);
            border-radius: 16px;
            background: var(--input-bg);
            color: var(--text-main);
            font-family: inherit;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        /* Pop animation on focus */
        .form-input:focus {
            outline: none;
            border-color: var(--gold);
            background: var(--bg-card);
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
            transform: scale(1.02);
        }
        
        .form-input:focus + .form-label { color: var(--gold); }

        /* --- BUTTON --- */
        .login-btn {
            width: 100%;
            background: var(--primary-grad);
            color: var(--btn-text);
            border: none;
            padding: 16px;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
            opacity: 0;
            animation: slideUpBtn 0.5s 0.5s ease-out forwards;
            position: relative;
            overflow: hidden;
        }

        /* Button Shine Effect */
        .login-btn::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }

        .login-btn:hover::before { left: 100%; }

        .login-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px -5px rgba(0,0,0,0.3);
        }

        @keyframes slideUpBtn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* --- FOOTER & ERROR --- */
        .error-message {
            background-color: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #ef4444;
            padding: 14px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            text-align: center;
            margin-bottom: 24px;
            animation: shake 0.4s ease-in-out;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .login-footer {
            margin-top: 30px;
            text-align: center;
            font-size: 13px;
            color: var(--text-sub);
            opacity: 0;
            animation: fadeIn 0.8s 0.8s forwards;
        }
        
        @keyframes fadeIn { to { opacity: 1; } }

        /* Icon visibility logic */
        .icon-sun { display: none; }
        .icon-moon { display: block; }
        
        :root.dark .icon-sun { display: block; }
        :root.dark .icon-moon { display: none; }

    </style>
</head>
<body>

    <!-- Theme Toggle Button -->
    <div class="theme-toggle-wrapper">
        <button id="theme-toggle" class="theme-toggle-btn" title="Toggle Dark/Light Mode">
            <span class="icon-sun">☀️</span>
            <span class="icon-moon">🌙</span>
        </button>
    </div>

    <!-- Animated Background Elements -->
    <div class="background-blobs">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
    </div>

    <div class="login-container">
        
        <div class="login-header">
            <div class="logo">
                Daleel Admin
                <div class="logo-icon"></div>
            </div>
            <div style="margin-top: 10px; color: var(--text-sub); font-size: 14px;">
                Welcome back! Please enter your details.
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
                <input 
                    id="email" 
                    name="email" 
                    type="email" 
                    required 
                    class="form-input"
                    placeholder="name@example.com"
                    value="{{ old('email') }}"
                >
                <!-- Label moved after input for CSS selector focus trick -->
                <!-- Note: In real layout, you might need flex-reverse or absolute positioning if you want label on top visually but below in DOM. 
                     Here I kept simple order but removed the sibling selector styling to keep it robust. -->
            </div>

            <!-- Password Input -->
            <div class="form-group">
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

    <script>
        const themeToggleBtn = document.getElementById('theme-toggle');
        const htmlRoot = document.documentElement;

        themeToggleBtn.addEventListener('click', () => {
            if (htmlRoot.classList.contains('dark')) {
                htmlRoot.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                htmlRoot.classList.add('dark');
                localStorage.theme = 'dark';
            }
        });
    </script>

</body>
</html>
