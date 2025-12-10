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

        .user-card-link {
            text-decoration: none;
            color: inherit;
        }

        .user-card-link:hover .user-card {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(93, 64, 55, 0.15);
            transition: all 0.3s ease;
        }

        .user-initials {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background-color: #c8a87a;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            color: #5d4037;
            font-weight: bold;
            font-size: 24px;
        }

        .verification-badge.verified {
            background-color: #84e387ff;
            color: white;
        }

        .verification-badge.rejected {
            background-color: #ec6359ff;
            color: white;
        }

        .verification-badge.pending {
            background-color: #ff9800;
            color: white;
        }

        .verification-indicator {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }

        .verification-indicator.verified {
            background-color: #4caf50;
            color: white;
        }

        .verification-indicator.rejected {
            background-color: #f44336;
            color: white;
        }

        .verification-indicator.pending {
            background-color: #ff9800;
            color: white;
        }

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

        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        
        .text-lg { font-size: 1.25rem; }
        .text-xl { font-size: 1.5rem; }
        .text-2xl { font-size: 2rem; }
        .text-3xl { font-size: 2.5rem; }

        .p-4 { padding: 2rem; }
        .p-6 { padding: 3rem; }
        .py-4 { padding-top: 2rem; padding-bottom: 2rem; }
        .px-4 { padding-left: 2rem; padding-right: 2rem; }
        
        .m-4 { margin: 2rem; }
        .my-4 { margin-top: 2rem; margin-bottom: 2rem; }
        .mx-auto { margin-left: auto; margin-right: auto; }
        
        .pagination-container {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
        }

        .pagination-modern {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .pagination-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background-color: #f5f5f5;
            color: #5d4037;
            border: 2px solid #c8a87a;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 4px rgba(93, 64, 55, 0.1);
        }

        .pagination-btn:hover:not(.disabled) {
            background-color: #c8a87a;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(93, 64, 55, 0.15);
            border-color: #b89a6a;
        }

        .pagination-btn.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            background-color: #f0f0f0;
            color: #9e9e9e;
            border-color: #e0e0e0;
        }

        .pagination-icon {
            width: 16px;
            height: 16px;
        }

        .pagination-numbers {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .pagination-number {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: #f5f5f5;
            color: #5d4037;
            border: 2px solid #c8a87a;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .pagination-number:hover:not(.active) {
            background-color: #e8e8e8;
            border-color: #b89a6a;
            transform: translateY(-1px);
        }

        .pagination-number.active {
            background-color: #5d4037;
            color: white;
            border-color: #5d4037;
            box-shadow: 0 2px 6px rgba(93, 64, 55, 0.2);
        }

        .pagination-ellipsis {
            color: #9e9e9e;
            padding: 0 10px;
            font-weight: bold;
        }

        .pagination-info {
            text-align: center;
            color: #7d6b5a;
            font-size: 14px;
            font-weight: 500;
        }

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
    <header class="header">
        <a href="/" class="logo">Daleel Admins</a>
        
        <div class="nav-buttons">
            <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Recent</a>
            <a href="/users" class="nav-link {{ request()->is('users') ? 'active' : '' }}">Users</a>
            <a href="/departments" class="nav-link {{ request()->is('departments') ? 'active' : '' }}">Departments</a>
            <a href="/contracts" class="nav-link {{ request()->is('contracts') ? 'active' : '' }}">Contracts</a>
        </div>
        
        @guest
            <a href="/login" class="login-btn">Log In</a>
        @endguest

        @auth
            <form method="POST" action="/logout">
                @csrf
                <button class="login-btn" style="font-size: 16px;">Log Out</button>
            </form>
        @endauth

    </header>

    <div class="content">
        {{ $slot }}
    </div>

    <footer class="footer">
        <p>&copy; 2026 Daleel. All rights reserved.</p>
    </footer>
</body>
</html>