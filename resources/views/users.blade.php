<x-layout title="Users">

    <style>
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
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
        }

        .users-container {
            padding: 40px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .users-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 50px; flex-wrap: wrap; gap: 24px; }
        .users-title { font-size: 32px; font-weight: 800; color: var(--primary); margin: 0; letter-spacing: -1px; }
        .controls-wrapper { display: flex; align-items: center; gap: 16px; flex-wrap: wrap; background: white; padding: 8px; border-radius: var(--radius-pill); box-shadow: var(--shadow-soft); border: 1px solid rgba(0,0,0,0.03); }
        .search-group { position: relative; }
        .search-box { border: none; background: transparent; padding: 12px 20px; font-size: 14px; color: var(--primary); width: 280px; outline: none; font-weight: 500; }
        .search-box::placeholder { color: #b0bec5; }
        .divider-vertical { width: 1px; height: 24px; background-color: #eee; }
        .btn-action { padding: 10px 24px; border-radius: var(--radius-pill); font-size: 13px; font-weight: 700; cursor: pointer; border: none; transition: all 0.3s ease; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; }
        .btn-search { background-color: var(--primary); color: white; }
        .btn-search:hover { background-color: #4a332a; }
        .btn-filter { background-color: transparent; color: var(--primary-soft); }
        .btn-filter:hover { background-color: var(--bg-body); color: var(--primary); }
        .btn-filter.active { background-color: var(--gold-light); color: var(--primary); }
        
        .active-filters-bar { margin-bottom: 30px; display: flex; align-items: center; gap: 12px; }
        .filter-tag { background: white; border: 1px solid var(--gold); color: var(--primary); padding: 6px 16px; border-radius: 8px; font-size: 12px; font-weight: 600; display: flex; align-items: center; gap: 8px; }
        .clear-link { font-size: 12px; color: #999; text-decoration: underline; cursor: pointer; }

        .users-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
        }

        .user-card-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .user-card {
            background-color: var(--bg-card);
            border-radius: var(--radius-xl);
            padding: 30px 20px;
            text-align: center;
            box-shadow: var(--shadow-soft);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid rgba(255,255,255,0.5);
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100%;
        }

        .user-card-link:hover .user-card {
            transform: translateY(-8px);
            box-shadow: var(--shadow-hover);
        }

        .user-image-wrapper {
            position: relative;
            margin-bottom: 18px;
        }

        .user-image {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .user-initials {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background-color: var(--gold);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: 700;
            border: 4px solid white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .user-info { width: 100%; }
        
        .user-name {
            color: var(--primary);
            font-size: 18px;
            font-weight: 800;
            margin: 0 0 6px 0;
            display: block;
        }

        .user-contact {
            color: #999;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 16px;
        }

        .status-pill {
            display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px;
            border-radius: 20px; font-size: 11px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.5px; margin-top: auto;
        }
        .st-verified { background: #e8f5e9; color: #2e7d32; }
        .st-pending { background: #fff8e1; color: #f57f17; }
        .st-rejected { background: #ffebee; color: #c62828; }
        
        .dot { width: 6px; height: 6px; border-radius: 50%; }
        .st-verified .dot { background: #2e7d32; }
        .st-pending .dot { background: #f57f17; }
        .st-rejected .dot { background: #c62828; }

        .no-users { grid-column: 1 / -1; text-align: center; padding: 80px; color: #b0bec5; font-style: italic; }

        .custom-paginator-wrapper { margin-top: 50px; display: flex; justify-content: center; gap: 8px; }
        .page-link { display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 50%; background: white; color: var(--primary); text-decoration: none; border: 1px solid #eee; transition: all 0.2s; }
        .page-link:hover:not(.disabled) { background: var(--gold); color: white; border-color: var(--gold); }
        .page-link.active { background: var(--primary); color: white; }
        .page-link.disabled { opacity: 0.5; background: #fcfcfc; }
        .page-info-text { text-align: center; margin-bottom: 10px; color: #999; font-size: 13px; }
</style>

    <div class="users-container">
        
        <div class="users-header">
            <h1 class="users-title">Users Directory</h1>
            
            <div class="controls-wrapper">
                <form method="GET" action="{{ route('users.index') }}" style="display: flex; align-items: center;">
                    @if(request('filter') === 'pending')
                        <input type="hidden" name="filter" value="pending">
                    @endif
                    
                    <div class="search-group">
                        <input type="text" name="search" class="search-box" placeholder="Find user by name..." value="{{ request('search') }}">
                    </div>
                    <button type="submit" class="btn-action btn-search">Search</button>
                </form>

                <div class="divider-vertical"></div>

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

        @if(request('search') || request('filter') === 'pending')
            <div class="active-filters-bar">
                <span style="font-size:13px; font-weight:600; color:var(--primary-soft);">Active Filters:</span>
                @if(request('search'))
                    <div class="filter-tag">🔍 "{{ request('search') }}"</div>
                @endif
                @if(request('filter') === 'pending')
                    <div class="filter-tag">⚠️ Pending Users</div>
                @endif
                <a href="{{ route('users.index') }}" class="clear-link">Clear All</a>
            </div>
        @endif

        <div class="users-grid">
            @forelse($users as $user)
                
                <x-user-card :user="$user" />

            @empty
                <div class="no-users">
                    <div style="font-size: 40px; margin-bottom: 20px;">🕵️‍♂️</div>
                    @if(request('search') || request('filter') === 'pending')
                        No users found matching your search.
                    @else
                        No users found in the database.
                    @endif
                </div>
            @endforelse
        </div>

        <div style="margin-top: 50px;">
            <div class="page-info-text">
                Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} results
            </div>

            {{ $users->links() }}
        </div>

        
    </div>
</x-layout>
