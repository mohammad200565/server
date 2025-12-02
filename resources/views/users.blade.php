<x-layout title="Users">
    <style>
        .users-container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .users-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .users-title {
            color: #5d4037;
            text-align: center;
            margin: 0;
        }

        .search-filter-container {
            display: flex;
            gap: 15px;
            align-items: center;
            flex-wrap: wrap;
        }

        .search-box {
            padding: 10px 15px;
            border: 2px solid #c8a87a;
            border-radius: 6px;
            background-color: white;
            color: #5d4037;
            font-size: 14px;
            width: 250px;
        }

        .search-box:focus {
            outline: none;
            border-color: #5d4037;
        }

        .search-btn {
            background-color: #c8a87a;
            color: #5d4037;
            border: 2px solid #c8a87a;
            padding: 10px 15px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .search-btn:hover {
            background-color: #e8ba78ff;
            border-color: #e8ba78ff;
        }

        .filter-btn {
            background-color: #c8a87a;
            color: #5d4037;
            border: 2px solid #c8a87a;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .filter-btn:hover {
            background-color: #e8ba78ff;
            border-color: #e8ba78ff;
        }

        .filter-btn.active {
            background-color: #5d4037;
            color: #f5f5f5;
            border-color: #5d4037;
        }

        .clear-filter {
            background-color: transparent;
            color: #5d4037;
            border: 2px solid #c8a87a;
            padding: 10px 15px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
        }

        .clear-filter:hover {
            background-color: #c8a87a;
            color: #5d4037;
        }

        .users-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .user-card {
            background-color: #f5f5f5;
            border: 2px solid #c8a87a;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(93, 64, 55, 0.1);
        }

        .user-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #a8a78d;
            margin-bottom: 15px;
        }

        .user-name {
            color: #5d4037;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .verification-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
        }

        .verified {
            background-color: #4caf50;
            color: white;
        }

        .rejected {
            background-color: #f44336;
            color: white;
        }

        .pending {
            background-color: #ff9800;
            color: white;
        }

        .no-users {
            text-align: center;
            color: #5d4037;
            font-size: 18px;
            margin-top: 50px;
            grid-column: 1 / -1;
        }

        .active-filters {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .filter-info {
            color: #5d4037;
            font-size: 14px;
            background-color: #a8a78d;
            padding: 5px 10px;
            border-radius: 4px;
        }

        .user-phone {
            color: #5d4037;
            font-size: 14px;
            margin-top: 8px;
        }
    </style>

    <div class="users-container">
        <div class="users-header">
            <h1 class="users-title">Users</h1>
            
            <div class="search-filter-container">
                <!-- Search Form -->
                <form method="GET" action="{{ route('users.index') }}" style="display: flex; gap: 10px;">
                    @if(request('filter') === 'pending')
                        <input type="hidden" name="filter" value="pending">
                    @endif
                    <input 
                        type="text" 
                        name="search" 
                        class="search-box" 
                        placeholder="Search by name..." 
                        value="{{ request('search') }}"
                    >
                    <button type="submit" class="search-btn">
                        Search
                    </button>
                </form>
                
                <!-- Pending Filter Form -->
                <form method="GET" action="{{ route('users.index') }}" style="display: inline;">
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    <button 
                        type="submit" 
                        name="filter" 
                        value="{{ request('filter') === 'pending' ? '' : 'pending' }}" 
                        class="filter-btn {{ request('filter') === 'pending' ? 'active' : '' }}"
                    >
                        {{ request('filter') === 'pending' ? 'Show All Users' : 'Show Pending Only' }}
                    </button>
                </form>
            </div>
        </div>

        <!-- Active Filters Display -->
        @if(request('search') || request('filter') === 'pending')
            <div class="active-filters">
                <span class="filter-info">
                    Active filters:
                    @if(request('search'))
                        Search: "{{ request('search') }}"
                    @endif
                    @if(request('filter') === 'pending')
                        {{ request('search') ? ' | ' : '' }}Pending Users Only
                    @endif
                </span>
                <a href="{{ route('users.index') }}" class="clear-filter">Clear All Filters</a>
            </div>
        @endif
        
        <div class="users-grid">
            @forelse($users as $user)
                <x-user-card :user="$user" />
            @empty
                <div class="no-users">
                    @if(request('search') || request('filter') === 'pending')
                        No users found matching your criteria.
                    @else
                        No users found in the database.
                    @endif
                </div>
            @endforelse
            
            @if($users->hasPages())
                <div class="pagination-container" style="margin-top: 30px; display: flex; justify-content: center;">
                    {{ $users->withQueryString()->links('vendor.pagination.default') }}
                </div>
            @endif
        </div>
    </div>
</x-layout>