<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Daleel Admin' }}</title>
    
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
            --gold-light: #f5efe6; /* Lighter cream for hovers */
            --gold-hover: #b89a6a;

            --bg-body: #f9f8f6; /* Warm luxury gray */
            --bg-card: #ffffff;
            
            /* Shadows & Radius */
            --shadow-header: 0 4px 20px rgba(93, 64, 55, 0.06);
            --shadow-card: 0 10px 40px -10px rgba(93, 64, 55, 0.08);
            --radius-pill: 100px;
            --radius-card: 24px;
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
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
        }

        /* --- Modern Header --- */
        .navbar {
            background-color: var(--bg-card);
            padding: 1.2rem 3rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: var(--shadow-header);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            text-decoration: none;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 8px;
            letter-spacing: -0.5px;
        }
        
        /* Optional: Add a gold dot to logo */
        .logo::after {
            content: '';
            width: 8px;
            height: 8px;
            background-color: var(--gold);
            border-radius: 50%;
            display: inline-block;
        }

        /* --- Navigation Links --- */
        .nav-menu {
            display: flex;
            gap: 8px;
            background: var(--bg-body);
            padding: 6px;
            border-radius: var(--radius-pill);
        }

        .nav-link {
            color: var(--primary-soft);
            text-decoration: none;
            padding: 10px 24px;
            border-radius: var(--radius-pill);
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav-link:hover {
            color: var(--primary);
            background-color: rgba(200, 168, 122, 0.1);
        }

        .nav-link.active {
            background-color: var(--primary);
            color: white;
            box-shadow: 0 4px 12px rgba(93, 64, 55, 0.25);
        }

        /* --- Auth Buttons --- */
        .auth-btn {
            background-color: transparent;
            color: var(--primary);
            border: 2px solid var(--bg-body);
            padding: 10px 24px;
            border-radius: var(--radius-pill);
            font-weight: 700;
            font-size: 0.9rem;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .auth-btn:hover {
            border-color: var(--gold);
            color: var(--gold-hover);
            background-color: white;
        }
        
        .logout-btn {
            background-color: var(--bg-body);
            border: none;
            color: var(--primary);
        }
        .logout-btn:hover {
            background-color: #eee;
            color: #333;
        }

        /* --- Main Content --- */
        .main-content {
            flex: 1;
            width: 100%;
            /* The specific page views will handle their own containers/max-widths 
               to allow for full-width headers or contained grids */
        }

        /* --- Footer --- */
        .footer {
            background-color: white;
            padding: 2rem;
            text-align: center;
            color: var(--primary-soft);
            font-size: 0.85rem;
            font-weight: 500;
            border-top: 1px solid rgba(0,0,0,0.03);
            margin-top: auto;
        }

        /* --- Responsive Design --- */
        @media (max-width: 900px) {
            .navbar {
                flex-direction: column;
                padding: 1rem;
                gap: 1.5rem;
            }
            
            .nav-menu {
                width: 100%;
                justify-content: center;
                overflow-x: auto; /* Allow scroll on small mobile */
            }

            .nav-link {
                padding: 8px 16px;
                font-size: 0.85rem;
                white-space: nowrap;
            }
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <!-- Logo -->
        <a href="/" class="logo">
            Daleel Admin
        </a>

        <!-- Center Navigation -->
        <div class="nav-menu">
            <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                Dashboard
            </a>
            <a href="/users" class="nav-link {{ request()->is('users*') ? 'active' : '' }}">
                Users
            </a>
            <!-- REVERTED LABEL HERE -->
            <a href="/departments" class="nav-link {{ request()->is('departments*') ? 'active' : '' }}">
                Departments
            </a>
            <a href="/contracts" class="nav-link {{ request()->is('contracts*') ? 'active' : '' }}">
                Contracts
            </a>
        </div>

        <!-- Auth Actions -->
        <div>
            @guest
                <a href="/login" class="auth-btn">Log In</a>
            @endguest

            @auth
                <form method="POST" action="/logout" style="display:inline;">
                    @csrf
                    <button class="auth-btn logout-btn">Log Out</button>
                </form>
            @endauth
        </div>
    </nav>

    <main class="main-content">
        {{ $slot }}
    </main>

    <footer class="footer">
        <p>&copy; 2026 Daleel. Designed with elegance.</p>
    </footer>

</body>
</html>
