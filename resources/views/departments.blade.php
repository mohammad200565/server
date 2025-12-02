<x-layout title="Departments">
    <style>
        .departments-container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .departments-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .departments-title {
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

        .departments-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
            margin-top: 20px;
        }

        .department-card {
            background-color: #f5f5f5;
            border: 2px solid #c8a87a;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(93, 64, 55, 0.1);
            transition: all 0.3s ease;
        }

        .department-card-link:hover .department-card {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(93, 64, 55, 0.15);
        }

        .department-image-placeholder {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .department-location {
            color: #5d4037;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .department-specs {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .spec-item {
            background-color: #c8a87a;
            color: #5d4037;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }

        .department-rent {
            color: #5d4037;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .department-status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .department-status.furnished {
            background-color: #4caf50;
            color: white;
        }

        .department-status.unfurnished {
            background-color: #f44336;
            color: white;
        }

        .department-status.partially furnished {
            background-color: #ff9800;
            color: white;
        }

        .verification-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
        }

        .verification-badge.verified {
            background-color: #4caf50;
            color: white;
        }

        .verification-badge.rejected {
            background-color: #f44336;
            color: white;
        }

        .verification-badge.pending {
            background-color: #ff9800;
            color: white;
        }

        .no-departments {
            text-align: center;
            color: #5d4037;
            font-size: 18px;
            margin-top: 50px;
            grid-column: 1 / -1;
        }

        .department-card-link {
            text-decoration: none;
            color: inherit;
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
            background-color: #c8a87a;
            padding: 5px 10px;
            border-radius: 4px;
        }
    </style>

    <div class="departments-container">
        <div class="departments-header">
            <h1 class="departments-title">Departments</h1>
            
            <div class="search-filter-container">
                <!-- Pending Filter Form -->
                <form method="GET" action="/departments" style="display: inline;">
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    <button 
                        type="submit" 
                        name="filter" 
                        value="{{ request('filter') === 'pending' ? '' : 'pending' }}" 
                        class="filter-btn {{ request('filter') === 'pending' ? 'active' : '' }}"
                    >
                        {{ request('filter') === 'pending' ? 'Show All Departments' : 'Show Pending Only' }}
                    </button>
                </form>
            </div>
        </div>

        @if(request('filter') === 'pending')
            <div class="active-filters">
                <span class="filter-info">
                    Active filter: Pending Departments Only
                </span>
                <a href="/departments" class="clear-filter">Clear Filter</a>
            </div>
        @endif
        
        <div class="departments-grid">
            @forelse($departments as $department)
                <x-department-card :department="$department" />
            @empty
                <div class="no-departments">
                    @if(request('filter') === 'pending')
                        No pending departments found.
                    @else
                        No departments found in the database.
                    @endif
                </div>
            @endforelse

            @if($departments->hasPages())
                <div class="pagination-container" style="margin-top: 30px; display: flex; justify-content: center;">
                    {{ $departments->withQueryString()->links('vendor.pagination.default') }}
                </div>
            @endif
        </div>
    </div>
</x-layout>