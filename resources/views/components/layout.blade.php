<!DOCTYPE html>
<html lang="en" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Daleel Admin' }}</title>

    <!-- Premium Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script>
        // Prevent flash of unstyled content
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <style>
        :root {
            /* --- GLOBAL VARIABLES (LIGHT MODE) --- */
            --primary: #5d4037;
            --primary-soft: #8d6e63;
            --primary-hover: #4a332a;

            --gold: #c8a87a;
            --gold-light: #f5efe6;
            --gold-hover: #b89a6a;

            --bg-body: #f9f8f6;
            --bg-card: #ffffff;
            /* Nav is now slightly transparent for glass effect */
            --bg-nav: rgba(255, 255, 255, 0.8);

            --text-main: #5d4037;
            --text-sub: #8d6e63;
            --border-color: rgba(0, 0, 0, 0.05);
            
            --shadow-header: 0 4px 30px rgba(0, 0, 0, 0.03);
            --shadow-card: 0 10px 40px -10px rgba(93, 64, 55, 0.08);

            --radius-pill: 100px;
            --radius-card: 24px;
        }

        /* --- DARK MODE OVERRIDES --- */
        :root.dark {
            --primary: #e6dace;
            --primary-soft: #a89f91;
            --primary-hover: #ffffff;

            --gold: #d4b483;
            --gold-light: #2a241c;
            --gold-hover: #e0c090;

            --bg-body: #121212;
            --bg-card: #1e1e1e;
            /* Dark glass nav */
            --bg-nav: rgba(30, 30, 30, 0.8);

            --text-main: #e6dace;
            --text-sub: #a89f91;
            --border-color: rgba(255, 255, 255, 0.1);

            --shadow-header: 0 4px 30px rgba(0, 0, 0, 0.2);
            --shadow-card: 0 10px 40px -10px rgba(0, 0, 0, 0.5);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background-color: var(--bg-body);
            color: var(--text-main);
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: background-color 0.3s ease, color 0.3s ease;
            overflow-x: hidden; /* Prevent horizontal scroll from animations */
        }

        /* --- GLOBAL BACKGROUND ANIMATION --- */
        @keyframes floatShape {
            0% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(50px, 80px) rotate(10deg); }
            66% { transform: translate(-30px, 40px) rotate(-5deg); }
            100% { transform: translate(0, 0) rotate(0deg); }
        }

        .bg-animation-layer {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            z-index: -1; /* Behind everything */
            overflow: hidden;
            pointer-events: none;
        }

        .anim-shape {
            position: absolute;
            filter: blur(80px);
            opacity: 0.4;
            z-index: -1;
            animation: floatShape 25s infinite ease-in-out alternate;
        }

        .shape-1 {
            top: -10%; left: -10%;
            width: 50vw; height: 50vw;
            background: rgba(124, 77, 255, 0.15); /* Soft Purple */
            border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
        }

        .shape-2 {
            bottom: -10%; right: -10%;
            width: 45vw; height: 45vw;
            background: rgba(33, 150, 243, 0.15); /* Soft Blue */
            border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
            animation-duration: 30s;
            animation-direction: alternate-reverse;
        }

        /* --- Modern Glass Navbar --- */
        .navbar {
            background-color: var(--bg-nav);
            backdrop-filter: blur(12px); /* Blur effect */
            -webkit-backdrop-filter: blur(12px);
            padding: 1rem 3rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            text-decoration: none;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 8px;
            letter-spacing: -0.5px;
        }

        .logo::after {
            content: '';
            width: 8px; height: 8px;
            background-color: var(--gold);
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 10px var(--gold);
        }

        /* --- Nav Links --- */
        .nav-menu {
            display: flex;
            gap: 6px;
            background: rgba(var(--text-main), 0.03); /* Extremely subtle bg */
            padding: 5px;
            border-radius: var(--radius-pill);
            border: 1px solid var(--border-color);
        }

        .nav-link {
            color: var(--text-sub);
            text-decoration: none;
            padding: 8px 20px;
            border-radius: var(--radius-pill);
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .nav-link:hover {
            color: var(--primary);
            background-color: rgba(200, 168, 122, 0.1);
        }

        .nav-link.active {
            background-color: var(--primary);
            color: #ffffff !important; /* Force white text in both modes */
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        /* --- Buttons --- */
        .auth-btn {
            background: transparent;
            color: var(--text-main);
            border: 1px solid var(--border-color);
            padding: 8px 20px;
            border-radius: var(--radius-pill);
            font-weight: 700;
            font-size: 0.9rem;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .auth-btn:hover {
            border-color: var(--gold);
            color: var(--gold);
            background: rgba(200, 168, 122, 0.05);
        }

        /* --- Theme Toggle --- */
        .theme-toggle {
            background: transparent;
            border: 1px solid var(--border-color);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--text-main);
            font-size: 1.1rem;
            margin-left: 10px;
            transition: all 0.3s ease;
        }

        .theme-toggle:hover {
            border-color: var(--gold);
            color: var(--gold);
            background: rgba(200, 168, 122, 0.1);
            transform: rotate(15deg);
        }

        .actions-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .main-content {
            flex: 1;
            width: 100%;
            position: relative;
            z-index: 1;
        }

        .footer {
            background-color: transparent; /* Transparent to show bg */
            padding: 2rem;
            text-align: center;
            color: var(--text-sub);
            font-size: 0.85rem;
            border-top: 1px solid var(--border-color);
            margin-top: auto;
            backdrop-filter: blur(5px);
        }

        @media (max-width: 900px) {
            .navbar { flex-direction: column; gap: 1rem; padding: 1rem; }
            .nav-menu { width: 100%; justify-content: center; overflow-x: auto; }
        }
    </style>
</head>

<body>
    
    <!-- GLOBAL ANIMATION BACKGROUND -->
    <div class="bg-animation-layer">
        <div class="anim-shape shape-1"></div>
        <div class="anim-shape shape-2"></div>
    </div>

    <nav class="navbar">
        <a href="/" class="logo">Daleel Admin</a>

        <div class="nav-menu">
            <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Dashboard</a>
            <a href="/users" class="nav-link {{ request()->is('users*') ? 'active' : '' }}">Users</a>
            <a href="/departments" class="nav-link {{ request()->is('departments*') ? 'active' : '' }}">Departments</a>
            <a href="/contracts" class="nav-link {{ request()->is('contracts*') ? 'active' : '' }}">Contracts</a>
        </div>

        <div class="actions-group">
            <!-- Auth Buttons -->
            @guest
                <a href="/login" class="auth-btn">Log In</a>
            @endguest

            @auth
                <form method="POST" action="/logout" style="display:inline;">
                    @csrf
                    <button class="auth-btn">Log Out</button>
                </form>
            @endauth

            <!-- THEME TOGGLE BUTTON -->
            <button id="theme-toggle" class="theme-toggle" title="Toggle Dark Mode">
                <span class="icon-sun" style="display: none;">☀️</span>
                <span class="icon-moon">🌙</span>
            </button>
        </div>
    </nav>

    <main class="main-content">
        {{ $slot }}
    </main>

    <footer class="footer">
        <p>&copy; 2026 Daleel. All rights reserved.</p>
    </footer>

    <!-- Dark Mode Logic Script -->
    <script>
        const themeToggleBtn = document.getElementById('theme-toggle');
        const iconSun = document.querySelector('.icon-sun');
        const iconMoon = document.querySelector('.icon-moon');
        const htmlRoot = document.documentElement;

        function updateIcon() {
            if (htmlRoot.classList.contains('dark')) {
                iconSun.style.display = 'block';
                iconMoon.style.display = 'none';
            } else {
                iconSun.style.display = 'none';
                iconMoon.style.display = 'block';
            }
        }

        // Initial Icon Set
        updateIcon();

        themeToggleBtn.addEventListener('click', () => {
            if (htmlRoot.classList.contains('dark')) {
                htmlRoot.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                htmlRoot.classList.add('dark');
                localStorage.theme = 'dark';
            }
            updateIcon();
        });
    </script>

</body>
</html>
