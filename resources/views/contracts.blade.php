<x-layout title="Contracts">

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

        /* --- PAGE SPECIFIC STYLES --- */
        :root {
            --radius-xl: 24px;
            --radius-pill: 50px;
        }
        
        /* Animation for page load */
        @keyframes slideUpFade {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .contracts-container {
            padding: 40px;
            max-width: 1400px;
            margin: 0 auto;
            animation: slideUpFade 0.6s ease-out;
        }

        /* --- Header & Controls --- */
        .contracts-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            flex-wrap: wrap;
            gap: 24px;
        }

        .contracts-title {
            font-size: 32px;
            font-weight: 800;
            color: var(--text-main);
            margin: 0;
            letter-spacing: -1px;
        }

        .controls-wrapper {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            background: var(--bg-card);
            padding: 8px;
            border-radius: var(--radius-pill);
            box-shadow: var(--shadow-soft);
            border: 1px solid var(--border-color);
        }

        /* --- Search Input --- */
        .search-group { position: relative; }

        .search-box {
            border: none;
            background: transparent;
            padding: 12px 20px;
            font-size: 14px;
            color: var(--text-main);
            width: 260px;
            outline: none;
            font-weight: 500;
        }

        .search-box::placeholder { color: var(--text-sub); opacity: 0.6; }

        /* --- Buttons --- */
        .btn-action {
            padding: 10px 24px;
            border-radius: var(--radius-pill);
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            border: none;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-search {
            background-color: var(--primary);
            color: var(--bg-card); /* Inverted text for contrast */
        }

        .btn-search:hover { 
            background-color: var(--primary-hover);
            color: var(--text-main);
        }

        /* --- Status Filter Bar --- */
        .status-filters {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }

        .status-btn {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-sub);
            padding: 8px 18px;
            border-radius: var(--radius-pill);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .status-btn:hover {
            border-color: var(--gold);
            color: var(--primary);
        }

        .status-btn.active {
            background: var(--primary);
            color: var(--bg-card);
            border-color: var(--primary);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        /* --- Active Filters --- */
        .active-filters-bar {
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .filter-tag {
            background: var(--bg-card);
            border: 1px solid var(--gold);
            color: var(--primary);
            padding: 6px 16px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
        }

        .clear-link {
            font-size: 12px;
            color: var(--text-sub);
            text-decoration: underline;
            cursor: pointer;
        }

        /* --- Contracts Grid --- */
        .contracts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
            gap: 30px;
        }

        /* =========================================
           CARD COMPONENT STYLES
           ========================================= */

        .rent-card-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .rent-card {
            background-color: var(--bg-card);
            border-radius: var(--radius-xl);
            padding: 24px;
            box-shadow: var(--shadow-card);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            gap: 20px;
            position: relative;
            height: 100%;
        }

        .rent-card:hover {
            transform: translateY(-5px);
            border-color: var(--gold);
        }

        /* Card Header */
        .rent-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 15px;
        }

        .rent-id {
            font-size: 16px;
            font-weight: 800;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .rent-id::before { content: '📄'; font-size: 18px; }

        /* --- UNIFORM STATUS BADGES --- */
        .rent-status {
            /* Fix Width & Alignment */
            min-width: 90px;
            height: 26px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            
            padding: 0 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .rent-status.onRent { background: rgba(21, 101, 192, 0.1); color: #1565c0; }
        .rent-status.pending { background: rgba(245, 127, 23, 0.1); color: #f57f17; }
        .rent-status.completed { background: rgba(46, 125, 50, 0.1); color: #2e7d32; }
        .rent-status.cancelled { background: rgba(198, 40, 40, 0.1); color: #c62828; }

        :root.dark .rent-status.onRent { color: #64b5f6; }
        :root.dark .rent-status.pending { color: #ffb74d; }
        :root.dark .rent-status.completed { color: #81c784; }
        :root.dark .rent-status.cancelled { color: #e57373; }

        /* Parties Section */
        .rent-parties {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--bg-body);
            border: 1px solid var(--border-color);
            padding: 15px;
            border-radius: 12px;
        }

        .party-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .party-info:last-child { text-align: right; }

        .party-label {
            font-size: 10px;
            text-transform: uppercase;
            color: var(--text-sub);
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .party-name {
            font-weight: 700;
            color: var(--text-main);
            font-size: 14px;
        }

        .rent-arrow { color: var(--gold); font-size: 18px; }

        /* Department Info */
        .department-info {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--text-sub);
            padding: 0 4px;
        }

        /* Details Grid */
        .rent-details {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 10px;
            background: var(--bg-body);
            padding: 15px;
            border-radius: 12px;
            border: 1px solid var(--border-color);
        }

        .detail-label { font-size: 10px; color: var(--text-sub); margin-bottom: 4px; font-weight: 600;}
        .detail-value { font-size: 13px; font-weight: 700; color: var(--text-main); }
        
        .detail-value.warning { color: #f57f17; }
        .detail-value.completed { color: #2e7d32; }
        .detail-value.cancelled { color: #c62828; }

        .rent-footer {
            margin-top: auto;
            border-top: 1px solid var(--border-color);
            padding-top: 15px;
            font-size: 11px;
            color: var(--text-sub);
            text-align: right;
        }

        .no-data {
            grid-column: 1 / -1;
            text-align: center;
            padding: 80px;
            color: var(--text-sub);
            font-style: italic;
        }

        /* --- Pagination --- */
        .custom-paginator-wrapper {
            margin-top: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--bg-card);
            color: var(--text-main);
            font-weight: 700;
            font-size: 14px;
            text-decoration: none;
            border: 1px solid var(--border-color);
            transition: all 0.2s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .page-link:hover:not(.disabled) {
            background: var(--gold);
            color: var(--bg-card);
            border-color: var(--gold);
            transform: translateY(-2px);
        }

        .page-link.active {
            background: var(--primary);
            color: var(--bg-card);
            border-color: var(--primary);
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }

        .page-link.disabled {
            opacity: 0.5;
            cursor: default;
            background: var(--bg-body);
        }

        .page-info-text {
            width: 100%;
            text-align: center;
            margin-bottom: 10px;
            color: var(--text-sub);
            font-size: 13px;
        }
    </style>

    <!-- Animation Layer -->
    <div class="bg-animation-layer">
        <div class="anim-shape shape-1"></div>
        <div class="anim-shape shape-2"></div>
    </div>

    <div class="contracts-container">
        <!-- Header -->
        <div class="contracts-header">
            <h1 class="contracts-title">Rental Contracts</h1>
            
            <div class="controls-wrapper">
                <form method="GET" action="{{ route('contracts.index') }}" style="display: flex; align-items: center;">
                    <div class="search-group">
                        <input 
                            type="text" 
                            name="search" 
                            class="search-box" 
                            placeholder="Search by name or ID..." 
                            value="{{ request('search') }}"
                        >
                    </div>
                    <button type="submit" class="btn-action btn-search">Search</button>
                </form>
            </div>
        </div>

        <div class="status-filters">
            <form method="GET" action="{{ route('contracts.index') }}" style="display: contents;">
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                
                <button type="submit" name="filter" value="" class="status-btn {{ !request('filter') ? 'active' : '' }}">
                    All
                </button>
                <button type="submit" name="filter" value="onRent" class="status-btn {{ request('filter') === 'onRent' ? 'active' : '' }}">
                    Active
                </button>
                <button type="submit" name="filter" value="pending" class="status-btn {{ request('filter') === 'pending' ? 'active' : '' }}">
                    Pending
                </button>
                <button type="submit" name="filter" value="completed" class="status-btn {{ request('filter') === 'completed' ? 'active' : '' }}">
                    Completed
                </button>
                <button type="submit" name="filter" value="cancelled" class="status-btn {{ request('filter') === 'cancelled' ? 'active' : '' }}">
                    Cancelled
                </button>
            </form>
        </div>

        @if(request('search'))
            <div class="active-filters-bar">
                <div class="filter-tag">
                    🔍 "{{ request('search') }}"
                </div>
                <a href="{{ route('contracts.index') }}" class="clear-link">Clear Search</a>
            </div>
        @endif

        <div class="contracts-grid">
            @forelse($rents as $rent)
                <x-contract-card :rent="$rent" />
            @empty
                <div class="no-data">
                    <div style="font-size: 40px; margin-bottom: 20px;">📄</div>
                    @if(request('search') || request('filter'))
                        No contracts found matching your filters.
                    @else
                        No contracts found in the database.
                    @endif
                </div>
            @endforelse
        </div>

        <div style="margin-top: 50px;">
            <div class="page-info-text">
                Showing {{ $rents->firstItem() }} to {{ $rents->lastItem() }} of {{ $rents->total() }} results
            </div>
            {{ $rents->links() }}
        </div>
    </div>

</x-layout>
