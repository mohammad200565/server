<x-layout title="Users">

    <style>
        /* --- ANIMATIONS (Shared with Dashboard) --- */
        @keyframes slideUpFade {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* --- BACKGROUND SHAPE ANIMATION --- */
        @keyframes floatShape {
            0% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(50px, 80px) rotate(10deg); }
            66% { transform: translate(-30px, 40px) rotate(-5deg); }
            100% { transform: translate(0, 0) rotate(0deg); }
        }

        .bg-animation-layer {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            z-index: -1;
            overflow: hidden;
            pointer-events: none;
        }

        .anim-shape {
            position: absolute;
            filter: blur(70px);
            opacity: 0.4;
            z-index: -1;
            animation: floatShape 20s infinite ease-in-out alternate;
        }

        /* Shape 1: Subtle Purple */
        .shape-1 {
            top: -10%; left: -10%;
            width: 50vw; height: 50vw;
            background: rgba(124, 77, 255, 0.2);
            border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
        }

        /* Shape 2: Subtle Blue/Teal */
        .shape-2 {
            bottom: -10%; right: -10%;
            width: 45vw; height: 45vw;
            background: rgba(33, 150, 243, 0.2);
            border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
            animation-duration: 25s;
            animation-direction: alternate-reverse;
        }

        /* --- PAGE SPECIFIC STYLES --- */
        
        /* Container Animation */
        .users-container {
            padding: 40px;
            max-width: 1400px;
            margin: 0 auto;
            animation: slideUpFade 0.6s ease-out; /* Updated to match dashboard */
        }

        /* --- Header & Title --- */
        .users-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            flex-wrap: wrap;
            gap: 24px;
        }

        .users-title {
            font-size: 32px;
            font-weight: 800;
            color: var(--text-main);
            margin: 0;
            letter-spacing: -1px;
        }

        /* --- Modern Control Bar (Search + Filter) --- */
        .controls-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            background: var(--bg-card); /* Adaptive background */
            padding: 8px 12px;
            border-radius: 100px;
            box-shadow: var(--shadow-card);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .controls-wrapper:focus-within {
            border-color: var(--gold);
            box-shadow: 0 8px 20px rgba(200, 168, 122, 0.15);
        }

        .search-group { position: relative; display: flex; align-items: center; }

        .search-icon {
            color: var(--text-sub);
            margin-left: 12px;
            pointer-events: none;
        }

        .search-box {
            border: none;
            background: transparent;
            padding: 12px 16px;
            font-size: 14px;
            color: var(--text-main);
            width: 260px;
            outline: none;
            font-weight: 600;
        }

        .search-box::placeholder { color: var(--text-sub); opacity: 0.7; }

        .divider-vertical {
            width: 1px;
            height: 24px;
            background-color: var(--border-color);
            margin: 0 8px;
        }

        /* --- Buttons --- */
        .btn-action {
            padding: 10px 24px;
            border-radius: 100px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            border: none;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            white-space: nowrap;
        }

        .btn-search {
            background-color: var(--primary);
            color: #fff; /* Always white */
        }

        .btn-search:hover {
            background-color: var(--gold);
            transform: translateY(-1px);
        }

        /* Dark mode overrides for search btn */
        :root.dark .btn-search { color: var(--bg-body); }

        .btn-filter {
            background-color: transparent;
            color: var(--text-sub);
        }

        .btn-filter:hover {
            background-color: var(--bg-body);
            color: var(--text-main);
        }

        .btn-filter.active {
            background-color: var(--gold-light);
            color: var(--gold);
        }

        /* --- Active Filters --- */
        .active-filters-bar {
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .filter-label {
            font-size: 13px; font-weight: 700; color: var(--text-sub);
        }

        .filter-tag {
            background: var(--bg-card);
            border: 1px solid var(--gold);
            color: var(--text-main);
            padding: 6px 16px;
            border-radius: 100px;
            font-size: 12px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .clear-link {
            font-size: 12px;
            color: var(--text-sub);
            text-decoration: underline;
            cursor: pointer;
            transition: color 0.2s;
        }

        .clear-link:hover { color: var(--gold); }

        /* --- Grid Layout --- */
        .users-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
        }

        /* --- Empty State --- */
        .no-users {
            grid-column: 1 / -1;
            text-align: center;
            padding: 80px;
            color: var(--text-sub);
            background: var(--bg-card);
            border-radius: 24px;
            border: 2px dashed var(--border-color);
        }

        /* --- Pagination Styling --- */
        .pagination-container {
            margin-top: 60px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .page-info-text {
            text-align: center;
            color: var(--text-sub);
            font-size: 13px;
            font-weight: 500;
        }

        /* Overriding Laravel Default Pagination SVG/Link styles if necessary */
        .pagination-container nav {
            background: var(--bg-card);
            padding: 10px;
            border-radius: 100px;
            box-shadow: var(--shadow-card);
        }
    </style>

    <!-- Animation Layer (Behind Content) -->
    <div class="bg-animation-layer">
        <div class="anim-shape shape-1"></div>
        <div class="anim-shape shape-2"></div>
    </div>

    <div class="users-container">
        
        <div class="users-header">
            <h1 class="users-title">Users Directory</h1>
            
            <div class="controls-wrapper">
                <!-- Search Form -->
                <form method="GET" action="{{ route('users.index') }}" style="display: flex; align-items: center;">
                    @if(request('filter') === 'pending')
                        <input type="hidden" name="filter" value="pending">
                    @endif
                    
                    <div class="search-group">
                        <!-- Search Icon -->
                        <svg class="search-icon" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" name="search" class="search-box" placeholder="Find user by name..." value="{{ request('search') }}">
                    </div>
                    
                    <button type="submit" class="btn-action btn-search">Search</button>
                </form>

                <div class="divider-vertical"></div>

                <!-- Filter Toggle -->
                <form method="GET" action="{{ route('users.index') }}" style="display: inline;">
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    
                    <button type="submit" name="filter" value="{{ request('filter') === 'pending' ? '' : 'pending' }}" 
                        class="btn-action btn-filter {{ request('filter') === 'pending' ? 'active' : '' }}">
                        {{ request('filter') === 'pending' ? 'Show All' : 'Pending Only' }}
                    </button>
                </form>
            </div>
        </div>

        <!-- Active Filters Display -->
        @if(request('search') || request('filter') === 'pending')
            <div class="active-filters-bar">
                <span class="filter-label">Active Filters:</span>
                
                @if(request('search'))
                    <div class="filter-tag">
                        <span>🔍 "{{ request('search') }}"</span>
                    </div>
                @endif
                
                @if(request('filter') === 'pending')
                    <div class="filter-tag" style="border-color: #f57f17; color: #f57f17;">
                        <span>⚠️ Pending Users</span>
                    </div>
                @endif
                
                <a href="{{ route('users.index') }}" class="clear-link">Clear All</a>
            </div>
        @endif

        <!-- Users Grid -->
        <div class="users-grid">
            @forelse($users as $user)
                <!-- Using the modernized Vertical Card Component -->
                <x-user-card :user="$user" />
            @empty
                <div class="no-users">
                    <div style="font-size: 48px; margin-bottom: 20px; opacity: 0.5;">🕵️‍♂️</div>
                    <h3 style="color: var(--text-main); font-weight: 700; margin-bottom: 8px;">No users found</h3>
                    <p>
                        @if(request('search') || request('filter') === 'pending')
                            We couldn't find any users matching your criteria.
                        @else
                            The database is currently empty.
                        @endif
                    </p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="pagination-container">
            <div class="page-info-text">
                Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} results
            </div>
            <!-- Laravel default pagination links -->
            {{ $users->links() }}
        </div>
        
    </div>

</x-layout>
