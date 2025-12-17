<x-layout title="Departments">

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

        .departments-container {
            padding: 40px;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* --- Header & Controls --- */
        .departments-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            flex-wrap: wrap;
            gap: 24px;
        }

        .departments-title {
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
        .search-group {
            position: relative;
        }

        .search-box {
            border: none;
            background: transparent;
            padding: 12px 20px;
            font-size: 14px;
            color: var(--primary);
            width: 250px;
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

        .btn-filter {
            background-color: transparent;
            color: var(--primary-soft);
        }
        .btn-filter:hover {
            background-color: var(--bg-body);
            color: var(--primary);
        }
        .btn-filter.active {
            background-color: var(--gold-light);
            color: var(--primary);
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

        /* --- Grid --- */
        .departments-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 30px;
        }

        /* --- CARD STYLING (Applied to your component) --- */
        .department-card-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .department-card {
            background-color: var(--bg-card);
            border-radius: var(--radius-xl);
            padding: 24px;
            box-shadow: var(--shadow-soft);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid rgba(255,255,255,0.5);
            display: flex;
            flex-direction: column;
            gap: 16px;
            position: relative;
            text-align: center;
        }

        .department-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-hover);
        }

        .department-image-placeholder {
            width: 80px;
            height: 80px;
            background: #fdfaf5;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            margin: 0 auto 10px;
            border: 1px solid var(--gold-light);
        }

        .department-location {
            font-size: 18px;
            font-weight: 800;
            color: var(--primary);
            line-height: 1.3;
        }

        /* Specs Grid */
        .department-specs {
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .spec-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: #fafafa;
            border: 1px solid #eee;
            border-radius: 12px;
            padding: 8px 12px;
            min-width: 60px;
        }

        .spec-value {
            font-weight: 800;
            font-size: 14px;
            color: var(--primary);
        }

        .spec-label {
            font-size: 10px;
            text-transform: uppercase;
            color: #999;
            font-weight: 600;
            margin-top: 2px;
        }

        .department-rent {
            font-size: 20px;
            font-weight: 800;
            color: var(--primary);
            margin: 5px 0;
        }

        /* Status & Badges */
        .department-status, .verification-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .department-status {
            background: #f0f0f0;
            color: #666;
            margin-bottom: 8px;
        }
        /* Color overrides for status */
        .department-status.furnished { background: #e8f5e9; color: #2e7d32; }
        .department-status.unfurnished { background: #ffebee; color: #c62828; }
        .department-status.partially { background: #fff8e1; color: #f57f17; }

        /* Verification Badge Colors */
        .verification-badge.verified { background: #e3f2fd; color: #1565c0; }
        .verification-badge.pending { background: #fff3e0; color: #e65100; }
        .verification-badge.rejected { background: #ffebee; color: #b71c1c; }


        .no-data {
            grid-column: 1 / -1;
            text-align: center;
            padding: 80px;
            color: #b0bec5;
            font-style: italic;
        }

        /* --- MANUAL PAGINATION STYLES --- */
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

    <div class="departments-container">

        <!-- Header -->
        <div class="departments-header">
            <h1 class="departments-title">Property Directory</h1>
            
            <div class="controls-wrapper">
                <form method="GET" action="/departments" style="display: inline;">
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    
                    <button 
                        type="submit" 
                        name="filter" 
                        value="{{ request('filter') === 'pending' ? '' : 'pending' }}" 
                        class="btn-action btn-filter {{ request('filter') === 'pending' ? 'active' : '' }}"
                    >
                        {{ request('filter') === 'pending' ? 'Show All' : 'Pending Review Only' }}
                    </button>
                </form>
            </div>
        </div>

        <!-- Active Filters -->
        @if(request('filter') === 'pending')
            <div class="active-filters-bar">
                <div class="filter-tag">⚠️ Pending Approval</div>
                <a href="/departments" class="clear-link">Clear Filter</a>
            </div>
        @endif

        <!-- Grid -->
        <div class="departments-grid">
            @forelse($departments as $department)
                <x-department-card :department="$department" />
            @empty
                <div class="no-data">
                    <div style="font-size: 40px; margin-bottom: 20px;">🏠</div>
                    @if(request('filter') === 'pending')
                        No pending properties found.
                    @else
                        No properties found.
                    @endif
                </div>
            @endforelse
        </div>

        <!-- Manual Pagination -->
        @if($departments->hasPages())
            <div style="margin-top: 50px;">
                <div class="page-info-text">
                    Showing {{ $departments->firstItem() }} to {{ $departments->lastItem() }} of {{ $departments->total() }} results
                </div>

                <div class="custom-paginator-wrapper">
                    @if ($departments->onFirstPage())
                        <span class="page-link disabled">‹</span>
                    @else
                        <a href="{{ $departments->previousPageUrl() }}" class="page-link">‹</a>
                    @endif

                    @foreach ($departments->getUrlRange(max(1, $departments->currentPage() - 2), min($departments->lastPage(), $departments->currentPage() + 2)) as $page => $url)
                        @if ($page == $departments->currentPage())
                            <span class="page-link active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($departments->hasMorePages())
                        <a href="{{ $departments->nextPageUrl() }}" class="page-link">›</a>
                    @else
                        <span class="page-link disabled">›</span>
                    @endif
                </div>
            </div>
        @endif
    </div>
</x-layout>
