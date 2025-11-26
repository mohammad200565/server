<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Daleel Admin' }}</title>
    <style>
        :root {
            --offwhite: #f8f4e9;
            --hazel: #c8a87a;
            --brown: #5d4037;
            --light-brown: #8d6e63;
            --dark-hazel: #b3956a;
            --active-color: #7a5c3c;
            --dark-brown: #3e2723;
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
            flex-direction: column;
        }

        .header {
            background-color: var(--hazel);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(93, 64, 55, 0.1);
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 600;
            text-decoration: none;
            color: var(--brown);
        }

        .nav-buttons {
            display: flex;
            gap: 1.5rem;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        .nav-link {
            background-color: var(--offwhite);
            color: var(--brown);
            border: none;
            padding: 0.7rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(93, 64, 55, 0.1);
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .nav-link:hover {
            background-color: var(--dark-hazel);
            color: var(--offwhite);
            transform: translateY(-2px);
        }

        .nav-link.active {
            background-color: var(--active-color);
            color: var(--offwhite);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(93, 64, 55, 0.2);
        }

        .login-btn {
            background-color: var(--offwhite);
            color: var(--brown);
            border: 2px solid var(--brown);
            padding: 0.5rem 1.5rem;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .login-btn:hover {
            background-color: var(--brown);
            color: var(--offwhite);
        }

        .content {
            flex: 1;
            padding: 2rem;
        }

        .footer {
            background-color: var(--hazel);
            padding: 1rem;
            text-align: center;
            color: var(--brown);
            font-weight: 500;
        }

        /* Color Utility Classes */
        .text-brown { color: var(--brown); }
        .text-light-brown { color: var(--light-brown); }
        .text-dark-brown { color: var(--dark-brown); }
        .text-hazel { color: var(--hazel); }
        .text-offwhite { color: var(--offwhite); }
        
        .bg-brown { background-color: var(--brown); }
        .bg-light-brown { background-color: var(--light-brown); }
        .bg-hazel { background-color: var(--hazel); }
        .bg-offwhite { background-color: var(--offwhite); }
        .bg-dark-hazel { background-color: var(--dark-hazel); }
        
        .border-brown { border-color: var(--brown); }
        .border-light-brown { border-color: var(--light-brown); }
        .border-hazel { border-color: var(--hazel); }

        /* Text utility classes */
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        
        .text-lg { font-size: 1.25rem; }
        .text-xl { font-size: 1.5rem; }
        .text-2xl { font-size: 2rem; }
        .text-3xl { font-size: 2.5rem; }

        /* Spacing utility classes */
        .p-4 { padding: 2rem; }
        .p-6 { padding: 3rem; }
        .py-4 { padding-top: 2rem; padding-bottom: 2rem; }
        .px-4 { padding-left: 2rem; padding-right: 2rem; }
        
        .m-4 { margin: 2rem; }
        .my-4 { margin-top: 2rem; margin-bottom: 2rem; }
        .mx-auto { margin-left: auto; margin-right: auto; }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 1rem;
                padding: 1rem;
            }
            
            .nav-buttons {
                position: static;
                transform: none;
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .logo {
                order: -1;
            }
        }
    </style>
</head>
<body>
    <!-- Header with centered navigation and login -->
    <header class="header">
        <a href="/" class="logo">Daleel Admins</a>
        
        <div class="nav-buttons">
            <a href="/" class="nav-link {{ request()->is('users') ? 'active' : '' }}">Home</a>
            <a href="/users" class="nav-link {{ request()->is('users') ? 'active' : '' }}">Users</a>
            <a href="/departments" class="nav-link {{ request()->is('departments') ? 'active' : '' }}">Departments</a>
            <a href="/contracts" class="nav-link {{ request()->is('contracts') ? 'active' : '' }}">Contracts</a>
            <a href="/history" class="nav-link {{ request()->is('history') ? 'active' : '' }}">History</a>
        </div>
        
        @guest
            <a href="/login" class="login-btn">Log In</a>
        @endguest

        @auth
            <a href="/logout" class="login-btn">Log Out</a>
        @endauth

    </header>

    <!-- Content area - slot for any content -->
    <div class="content">
        {{ $slot }}
    </div>

    <!-- Footer with company name -->
    <footer class="footer">
        <p>&copy; 2026 Daleel. All rights reserved.</p>
    </footer>
</body>
</html>