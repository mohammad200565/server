<x-layout title="Contracts">

    <style>
        /* --- Shared Theme Variables --- */
        :root {
            --primary: #5d4037;
            --primary-soft: #8d6e63;
            --gold: #c8a87a;
            --gold-light: #f0e6d2;
            --bg-body: #f9f8f6;
            --bg-card: #ffffff;
            --shadow-soft: 0 10px 40px -10px rgba(93, 64, 55, 0.08);
            --shadow-hover: 0 20px 40px -5px rgba(93, 64, 55, 0.15);
            --radius-xl: 24px;
            --radius-md: 16px;
            --radius-pill: 50px;
        }

        body {
            background-color: var(--bg-body);
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        }

        .contracts-container {
            padding: 40px;
            max-width: 1400px;
            margin: 0 auto;
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
            color: var(--primary);
            margin: 0;
            letter-spacing: -1px;
        }

        .controls-wrapper {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            background: white;
            padding: 8px;
            border-radius: var(--radius-pill);
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(0,0,0,0.03);
        }

        /* --- Search Input --- */
        .search-group { position: relative; }
        
        .search-box {
            border: none;
            background: transparent;
            padding: 12px 20px;
            font-size: 14px;
            color: var(--primary);
            width: 260px;
            outline: none;
            font-weight: 500;
        }
        .search-box::placeholder { color: #b0bec5; }

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
            color: white;
        }
        .btn-search:hover { background-color: #4a332a; }

        /* --- Status Filter Bar --- */
        .status-filters {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }

        .status-btn {
            background: white;
            border: 1px solid #eee;
            color: var(--primary-soft);
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
            color: white;
            border-color: var(--primary);
            box-shadow: 0 4px 12px rgba(93, 64, 55, 0.2);
        }

        /* --- Active Filters --- */
        .active-filters-bar {
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .filter-tag {
            background: white;
            border: 1px solid var(--gold);
            color: var(--primary);
            padding: 6px 16px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
        }

        .clear-link {
            font-size: 12px;
            color: #999;
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
            box-shadow: var(--shadow-soft);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid rgba(255,255,255,0.5);
            display: flex;
            flex-direction: column;
            gap: 20px;
            position: relative;
            height: 100%;
        }

        .rent-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
            border-color: rgba(200, 168, 122, 0.3);
        }

        /* Card Header */
        .rent-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #f5f5f5;
            padding-bottom: 15px;
        }

        .rent-id {
            font-size: 16px;
            font-weight: 800;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .rent-id::before { content: '📄'; font-size: 18px; }

        .rent-status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }
        .rent-status.onRent { background: #e3f2fd; color: #1565c0; }
        .rent-status.pending { background: #fff8e1; color: #f57f17; }
        .rent-status.completed { background: #e8f5e9; color: #2e7d32; }
        .rent-status.cancelled { background: #ffebee; color: #c62828; }

        /* Parties Section */
        .rent-parties {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fdfdfc;
            border: 1px solid #f0f0f0;
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
            color: #aaa;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .party-name {
            font-weight: 700;
            color: var(--primary);
            font-size: 14px;
        }

        .rent-arrow { color: var(--gold); font-size: 18px; }

        /* Department Info */
        .department-info {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--primary-soft);
            padding: 0 4px;
        }

        /* Details Grid */
        .rent-details {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 10px;
            background: #fcfbf9;
            padding: 15px;
            border-radius: 12px;
        }

        .detail-label { font-size: 10px; color: #aaa; margin-bottom: 4px; font-weight: 600;}
        .detail-value { font-size: 13px; font-weight: 700; color: var(--primary); }
        
        .detail-value.warning { color: #f57f17; }
        .detail-value.completed { color: #2e7d32; }
        .detail-value.cancelled { color: #c62828; }

        .rent-footer {
            margin-top: auto;
            border-top: 1px solid #f5f5f5;
            padding-top: 15px;
            font-size: 11px;
            color: #bbb;
            text-align: right;
        }

        .no-data {
            grid-column: 1 / -1;
            text-align: center;
            padding: 80px;
            color: #b0bec5;
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
            background: white;
            color: var(--primary);
            font-weight: 700;
            font-size: 14px;
            text-decoration: none;
            border: 1px solid #eee;
            transition: all 0.2s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .page-link:hover:not(.disabled) {
            background: var(--gold);
            color: white;
            border-color: var(--gold);
            transform: translateY(-2px);
        }

        .page-link.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
            box-shadow: 0 4px 10px rgba(93, 64, 55, 0.3);
        }

        .page-link.disabled {
            opacity: 0.5;
            cursor: default;
            background: #fcfcfc;
        }

        .page-info-text {
            width: 100%;
            text-align: center;
            margin-bottom: 10px;
            color: #999;
            font-size: 13px;
        }
    </style>

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

        <!-- Status Filter Tabs -->
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

        <!-- Active Search Indicator -->
        @if(request('search'))
            <div class="active-filters-bar">
                <div class="filter-tag">
                    🔍 "{{ request('search') }}"
                </div>
                <a href="{{ route('contracts.index') }}" class="clear-link">Clear Search</a>
            </div>
        @endif

        <!-- Contracts Grid -->
        <div class="contracts-grid">
            @forelse($rents as $rent)
                
                <!-- ✅ Render the component using its exact filename: contract-card -->
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

        <!-- MANUAL PAGINATION -->
        @if($rents->hasPages())
            <div style="margin-top: 50px;">
                
                <div class="page-info-text">
                    Showing {{ $rents->firstItem() }} to {{ $rents->lastItem() }} of {{ $rents->total() }} contracts
                </div>
                <div class="custom-paginator-wrapper">
                    
                    {{-- Previous Button --}}
                    @if ($rents->onFirstPage())
                        <span class="page-link disabled">‹</span>
                    @else
                        <a href="{{ $rents->previousPageUrl() }}" class="page-link">‹</a>
                    @endif

                    {{-- Number Links --}}
                    @foreach ($rents->getUrlRange(max(1, $rents->currentPage() - 2), min($rents->lastPage(), $rents->currentPage() + 2)) as $page => $url)
                        @if ($page == $rents->currentPage())
                            <span class="page-link active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                        @endif
                    @endforeach

                    {{-- Next Button --}}
                    @if ($rents->hasMorePages())
                        <a href="{{ $rents->nextPageUrl() }}" class="page-link">›</a>
                    @else
                        <span class="page-link disabled">›</span>
                    @endif
                </div>
            </div>
        @endif

    </div>
</x-layout>
