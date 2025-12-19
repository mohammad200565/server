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
        .departments-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; flex-wrap: wrap; gap: 24px; }
        .departments-title { font-size: 32px; font-weight: 800; color: var(--primary); margin: 0; letter-spacing: -1px; }
        .controls-wrapper { display: flex; align-items: center; gap: 16px; flex-wrap: wrap; background: white; padding: 8px; border-radius: var(--radius-pill); box-shadow: var(--shadow-soft); border: 1px solid rgba(0,0,0,0.03); }
        
        /* Search */
        .search-group { position: relative; }
        .search-box { border: none; background: transparent; padding: 12px 20px; font-size: 14px; color: var(--primary); width: 250px; outline: none; font-weight: 500; }
        .search-box::placeholder { color: #b0bec5; }
        
        /* Buttons */
        .btn-action { padding: 10px 24px; border-radius: var(--radius-pill); font-size: 13px; font-weight: 700; cursor: pointer; border: none; transition: all 0.3s ease; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; }
        .btn-search { background-color: var(--primary); color: white; }
        .btn-search:hover { background-color: #4a332a; }
        .btn-filter { background-color: transparent; color: var(--primary-soft); }
        .btn-filter:hover { background-color: var(--bg-body); color: var(--primary); }
        .btn-filter.active { background-color: var(--gold-light); color: var(--primary); }

        /* Filters */
        .active-filters-bar { margin-bottom: 30px; display: flex; align-items: center; gap: 12px; }
        .filter-tag { background: white; border: 1px solid var(--gold); color: var(--primary); padding: 6px 16px; border-radius: 8px; font-size: 12px; font-weight: 600; }
        .clear-link { font-size: 12px; color: #999; text-decoration: underline; cursor: pointer; }

        /* Grid */
        .departments-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 30px;
        }

        /* =========================================
           NEW MODERN CARD STYLES
           ========================================= */
        
        .department-card-link {
            text-decoration: none;
            display: block;
            color: inherit;
        }

        .department-card {
            background: var(--bg-card);
            border-radius: var(--radius-xl);
            overflow: hidden;
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(255,255,255,0.5);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .department-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-hover);
        }

        /* Image Wrapper */
        .dept-image-wrapper {
            height: 180px;
            position: relative;
            background-color: var(--gold-light);
        }

        .dept-placeholder-pattern {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #5d4037 0%, #8d6e63 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dept-icon-circle {
            width: 60px; height: 60px;
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(4px);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 30px;
            border: 1px solid rgba(255,255,255,0.3);
        }

        /* Badges */
        .floating-badge {
            position: absolute; top: 16px; right: 16px;
            padding: 6px 12px; border-radius: 20px;
            font-size: 11px; font-weight: 700; text-transform: uppercase;
            background: white;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            display: flex; align-items: center; gap: 4px;
            z-index: 2;
        }
        .floating-badge.verified { color: #2e7d32; }
        .floating-badge.rejected { color: #c62828; }
        .floating-badge.pending  { color: #f57f17; }

        /* Card Body */
        .dept-body {
            padding: 24px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .dept-header-row {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 8px;
        }

        .dept-price {
            font-size: 22px; font-weight: 800; color: var(--gold);
        }
        .dept-price .period {
            font-size: 13px; font-weight: 500; color: #999;
        }

        .status-pill-small {
            font-size: 10px; font-weight: 700; padding: 4px 10px;
            border-radius: 6px; text-transform: uppercase; letter-spacing: 0.5px;
            background: #f0f0f0; color: #666;
        }
        /* Status Colors */
        .status-pill-small.available { background: #e8f5e9; color: #2e7d32; }
        .status-pill-small.occupied  { background: #ffebee; color: #c62828; }

        .dept-location {
            font-size: 16px; font-weight: 700; color: var(--primary);
            margin: 0 0 16px 0; line-height: 1.4; text-align: left;
        }
        .dept-location .district {
            font-weight: 500; color: var(--primary-soft);
        }

        .dept-divider {
            height: 1px; background: #f0f0f0; margin-bottom: 16px;
        }

        /* Specs Grid */
        .dept-specs-grid {
            display: grid; grid-template-columns: repeat(4, 1fr);
            gap: 8px; margin-top: auto;
        }
        .spec-box {
            text-align: center; display: flex; flex-direction: column; align-items: center;
        }
        .spec-icon { font-size: 14px; margin-bottom: 4px; opacity: 0.7; }
        .spec-info { display: flex; flex-direction: column; line-height: 1; }
        .spec-val { font-weight: 700; font-size: 14px; color: var(--primary); }
        .spec-label { font-size: 10px; color: #aaa; margin-top: 2px; }

        .no-data { grid-column: 1 / -1; text-align: center; padding: 80px; color: #b0bec5; font-style: italic; }

        /* Pagination (Kept original) */
        .custom-paginator-wrapper { margin-top: 50px; display: flex; justify-content: center; align-items: center; gap: 8px; flex-wrap: wrap; }
        .page-link { display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 50%; background: white; color: var(--primary); font-weight: 700; font-size: 14px; text-decoration: none; border: 1px solid #eee; transition: all 0.2s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .page-link:hover:not(.disabled) { background: var(--gold); color: white; border-color: var(--gold); transform: translateY(-2px); }
        .page-link.active { background: var(--primary); color: white; border-color: var(--primary); box-shadow: 0 4px 10px rgba(93, 64, 55, 0.3); }
        .page-link.disabled { opacity: 0.5; cursor: default; background: #fcfcfc; }
        .page-info-text { width: 100%; text-align: center; margin-bottom: 10px; color: #999; font-size: 13px; }

    </style>

    <div class="departments-container">

        <!-- Header -->
        <div class="departments-header">
            <h1 class="departments-title">Department Directory</h1>
            
            <div class="controls-wrapper">
                <form method="GET" action="/departments" style="display: inline;">
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    
                    <button type="submit" name="filter" value="{{ request('filter') === 'pending' ? '' : 'pending' }}" 
                        class="btn-action btn-filter {{ request('filter') === 'pending' ? 'active' : '' }}">
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
                        No pending department found.
                    @else
                        No Departments found.
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
