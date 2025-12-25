<x-layout title="Departments">

    <style>
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

        .shape-1 {
            top: -10%; left: -10%;
            width: 50vw; height: 50vw;
            background: rgba(124, 77, 255, 0.2);
            border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
        }

        .shape-2 {
            bottom: -10%; right: -10%;
            width: 45vw; height: 45vw;
            background: rgba(33, 150, 243, 0.2);
            border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
            animation-duration: 25s;
            animation-direction: alternate-reverse;
        }

        /* --- PAGE ANIMATION --- */
        @keyframes slideUpFade {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .departments-container {
            padding: 40px;
            max-width: 1400px;
            margin: 0 auto;
            animation: slideUpFade 0.6s ease-out;
        }

        /* --- HEADER & TITLE --- */
        .departments-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .departments-title {
            font-size: 32px;
            font-weight: 800;
            color: var(--text-main);
            margin: 0;
            letter-spacing: -1px;
        }

        /* --- CONTROLS (Search + Filter) --- */
        .controls-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--bg-card);
            padding: 6px 12px;
            border-radius: 100px;
            box-shadow: var(--shadow-card);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .controls-wrapper:focus-within {
            border-color: var(--gold);
            box-shadow: 0 8px 20px rgba(200, 168, 122, 0.15);
        }

        .search-group {
            display: flex;
            align-items: center;
            position: relative;
        }

        .search-icon {
            color: var(--text-sub);
            margin-left: 8px;
        }

        .search-box {
            border: none;
            background: transparent;
            padding: 10px 14px;
            font-size: 14px;
            color: var(--text-main);
            width: 220px; /* Slightly compact */
            outline: none;
            font-weight: 600;
        }

        .search-box::placeholder { color: var(--text-sub); opacity: 0.7; }

        .divider-vertical {
            width: 1px; height: 24px; background: var(--border-color); margin: 0 6px;
        }

        /* --- BUTTONS --- */
        .btn-action {
            padding: 8px 20px;
            border-radius: 100px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            border: none;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex; align-items: center; justify-content: center;
        }

        .btn-search {
            background-color: var(--primary);
            color: #fff;
        }

        .btn-search:hover {
            background-color: var(--gold);
            transform: translateY(-1px);
        }

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

        /* --- ACTIVE FILTERS --- */
        .active-filters-bar {
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .filter-tag {
            background: var(--bg-card);
            border: 1px solid var(--gold);
            color: var(--text-main);
            padding: 6px 14px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 700;
            display: flex; align-items: center; gap: 6px;
        }

        .clear-link {
            font-size: 12px; color: var(--text-sub);
            text-decoration: underline; cursor: pointer;
        }

        .clear-link:hover { color: var(--gold); }

        /* --- GRID LAYOUT --- */
        .departments-grid {
            display: grid;
            /* Reduced min-width to 270px to make cards smaller */
            grid-template-columns: repeat(auto-fill, minmax(270px, 1fr));
            gap: 24px;
        }

        /* --- EMPTY STATE --- */
        .no-data {
            grid-column: 1 / -1;
            text-align: center;
            padding: 60px;
            color: var(--text-sub);
            background: var(--bg-card);
            border-radius: 24px;
            border: 2px dashed var(--border-color);
        }

        /* --- PAGINATION --- */
        .pagination-container {
            margin-top: 50px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .page-info-text {
            color: var(--text-sub);
            font-size: 13px;
            font-weight: 500;
        }

        /* Style Laravel Pagination */
        .pagination-container nav {
            background: var(--bg-card);
            padding: 8px;
            border-radius: 100px;
            box-shadow: var(--shadow-card);
        }
    </style>

    <!-- Animation Layer -->
    <div class="bg-animation-layer">
        <div class="anim-shape shape-1"></div>
        <div class="anim-shape shape-2"></div>
    </div>

    <div class="departments-container">
        <!-- Header -->
        <div class="departments-header">
            <h1 class="departments-title">Department Directory</h1>
            
            <div class="controls-wrapper">
                <!-- Search Form -->
                <form method="GET" action="/departments" style="display: flex; align-items: center;">
                    @if(request('filter') === 'pending')
                        <input type="hidden" name="filter" value="pending">
                    @endif
                    <div class="search-group">
                        <svg class="search-icon" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" name="search" class="search-box" placeholder="Search city..." value="{{ request('search') }}">
                    </div>
                    <button type="submit" class="btn-action btn-search">Search</button>
                </form>
                <div class="divider-vertical"></div>
                <!-- Filter Toggle -->
                <form method="GET" action="/departments" style="display: inline;">
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

        <!-- Active Filters -->
        @if(request('filter') === 'pending' || request('search'))
            <div class="active-filters-bar">
                @if(request('filter') === 'pending')
                    <div class="filter-tag" style="border-color: #f57f17; color: #f57f17;">
                        <span>⚠️ Pending Approval</span>
                    </div>
                @endif
                @if(request('search'))
                     <div class="filter-tag">
                        <span>🔍 "{{ request('search') }}"</span>
                    </div>
                @endif
                <a href="/departments" class="clear-link">Clear Filters</a>
            </div>
        @endif

        <!-- Grid -->
        <div class="departments-grid">
            @forelse($departments as $department)
                <x-department-card :department="$department" />
            @empty
                <div class="no-data">
                    <div style="font-size: 40px; margin-bottom: 20px; opacity: 0.5;">🏠</div>
                    <h3 style="color: var(--text-main); margin-bottom: 8px;">No Departments Found</h3>
                    <p>
                        @if(request('filter') === 'pending')
                            No pending departments found.
                        @else
                            The database is empty or no results match your search.
                        @endif
                    </p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="pagination-container">
            <div class="page-info-text">
                Showing {{ $departments->firstItem() }} to {{ $departments->lastItem() }} of {{ $departments->total() }} results
            </div>
            {{ $departments->links() }}
        </div>
    </div>

</x-layout>
