@use('App\Models\User')
@use('App\Models\Department')
@use('App\Models\Rent')

<x-layout title="Recent Activities">

    <style>
        /* Modern Reset & Variables */
        :root {
            --primary: #5d4037;
            --primary-soft: #8d6e63;
            --gold: #c8a87a;
            --gold-light: #f0e6d2;
            --bg-body: #f9f8f6; /* Warm creamy background */
            --bg-card: #ffffff;
            --shadow-soft: 0 10px 40px -10px rgba(93, 64, 55, 0.08);
            --shadow-hover: 0 20px 40px -5px rgba(93, 64, 55, 0.15);
            --radius-xl: 24px;
            --radius-md: 16px;
        }

        body {
            background-color: var(--bg-body);
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        }

        .dashboard-container {
            padding: 40px;
            max-width: 1600px;
            margin: 0 auto;
        }

        /* --- Header Section --- */
        .dashboard-header {
            margin-bottom: 50px;
            position: relative;
        }

        .dashboard-title {
            font-size: 32px;
            font-weight: 800;
            color: var(--primary);
            margin: 0;
            letter-spacing: -1px;
        }

        .dashboard-subtitle {
            color: var(--primary-soft);
            font-size: 16px;
            margin-top: 8px;
            font-weight: 500;
        }

        /* --- Stats Row (Hero) --- */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 24px;
            margin-bottom: 60px;
        }

        .stat-card {
            background: var(--bg-card);
            border-radius: var(--radius-xl);
            padding: 30px;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-soft);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid rgba(255,255,255,0.5);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 160px;
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-hover);
        }

        /* Subtle gradient decorative blob */
        .stat-card::before {
            content: '';
            position: absolute;
            top: -20px;
            right: -20px;
            width: 100px;
            height: 100px;
            background: radial-gradient(circle, var(--gold-light) 0%, transparent 70%);
            border-radius: 50%;
            opacity: 0.6;
            transition: transform 0.4s ease;
        }
        
        .stat-card:hover::before {
            transform: scale(1.5);
        }

        .stat-label {
            font-size: 14px;
            font-weight: 700;
            color: var(--primary-soft);
            text-transform: uppercase;
            letter-spacing: 1px;
            z-index: 1;
        }

        .stat-value {
            font-size: 48px;
            font-weight: 800;
            color: var(--primary);
            line-height: 1;
            z-index: 1;
            margin-top: auto; /* Push to bottom */
            letter-spacing: -2px;
        }

        /* --- Main Content Grid --- */
        .content-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        @media (max-width: 1200px) {
            .content-grid { grid-template-columns: 1fr; }
        }

        .section-column {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding: 0 10px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .section-title span {
            background: var(--gold-light);
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-size: 16px;
        }

        .view-all {
            font-size: 12px;
            font-weight: 700;
            color: var(--gold);
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: color 0.3s;
        }
        .view-all:hover { color: var(--primary); }

        /* --- Modern List Cards --- */
        .list-card {
            background: var(--bg-card);
            border-radius: var(--radius-md);
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 18px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.02);
            border: 1px solid rgba(0,0,0,0.02);
            transition: all 0.3s ease;
            position: relative;
        }

        .list-card:hover {
            transform: translateX(5px);
            box-shadow: 0 8px 30px rgba(93, 64, 55, 0.08);
            border-color: var(--gold-light);
        }

        .icon-box {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .icon-user { background: #e3f2fd; color: #1565c0; }
        .icon-dept { background: #fce4ec; color: #c2185b; }
        .icon-contract { background: #e8f5e9; color: #2e7d32; }

        .card-info {
            flex: 1;
        }

        .card-main-text {
            font-weight: 700;
            color: var(--primary);
            font-size: 15px;
            display: block;
            margin-bottom: 4px;
            text-decoration: none;
        }

        .card-sub-text {
            font-size: 13px;
            color: var(--primary-soft);
            display: block;
            margin-bottom: 6px;
        }

        .card-meta {
            font-size: 11px;
            font-weight: 600;
            color: #b0bec5;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* --- Modern Status Pills --- */
        .status-dot {
            height: 8px;
            width: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 6px;
        }
        .status-text {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }
        
        .st-verified, .st-completed { color: #2e7d32; } .dot-verified, .dot-completed { background: #2e7d32; }
        .st-pending { color: #f57f17; } .dot-pending { background: #f57f17; }
        .st-onRent { color: #1565c0; } .dot-onRent { background: #1565c0; }

        .price-tag {
            background: var(--gold);
            color: white;
            padding: 2px 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
        }

    </style>

    <div class="dashboard-container">
        
        <div class="dashboard-header">
            <h1 class="dashboard-title">Dashboard</h1>
            <div class="dashboard-subtitle">Welcome back, here's what happened recently.</div>
        </div>

        <!-- Hero Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Total Users</div>
                <div class="stat-value">{{ $totalUsers ?? User::count()-1 }}</div>
            </div>
            <!-- FIXED LABEL: Departments -->
            <div class="stat-card">
                <div class="stat-label">Departments</div>
                <div class="stat-value">{{ $totalDepartments ?? Department::count() }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Active Contracts</div>
                <div class="stat-value">{{ $totalContracts ?? Rent::where('status', 'onRent')->count() }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label" style="color: #f57f17;">Pending Review</div>
                <div class="stat-value" style="color: #f57f17;">{{ $pendingUsers ?? User::where('verification_state', 'pending')->count() }}</div>
            </div>
        </div>

        <!-- 3 Column Layout -->
        <div class="content-grid">
            
            <!-- Users Column -->
            <div class="section-column">
                <div class="section-header">
                    <div class="section-title"><span>👤</span> New Users</div>
                    <a href="/users" class="view-all">View All</a>
                </div>
                
                @forelse($recentUsers as $user)
                    <div class="list-card">
                        <div class="icon-box icon-user">
                           {{ substr($user->first_name, 0, 1) }}
                        </div>
                        <div class="card-info">
                            <a href="/users/{{$user->id}}" class="card-main-text">
                                {{ $user->first_name }} {{ $user->last_name }}
                            </a>
                            <div class="card-meta">
                                <span>
                                    <span class="status-dot dot-{{ $user->verification_state }}"></span>
                                    <span class="status-text st-{{ $user->verification_state }}">{{ $user->verification_state }}</span>
                                </span>
                                <span>{{ $user->created_at->diffForHumans(null, true) }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="text-align:center; padding: 20px; color: #aaa;">No new users</div>
                @endforelse
            </div>

            <!-- Departments Column -->
            <div class="section-column">
                <div class="section-header">
                    <!-- FIXED TITLE: Departments -->
                    <div class="section-title"><span>🏠</span> Departments</div>
                    <a href="/departments" class="view-all">View All</a>
                </div>

                @forelse($recentDepartments as $department)
                    <div class="list-card">
                        <div class="icon-box icon-dept">🏠</div>
                        <div class="card-info">
                            <a href="/departments/{{$department->id}}" class="card-main-text">
                                {{ $department->location['city'] ?? 'City' }}
                            </a>
                            <span class="card-sub-text">
                                {{ $department->area }}m² • {{ $department->bedrooms }} Beds
                            </span>
                            <div class="card-meta">
                                <span class="price-tag">${{ number_format($department->rent_fee) }}</span>
                                <span>{{ $department->created_at->diffForHumans(null, true) }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="text-align:center; padding: 20px; color: #aaa;">No new departments</div>
                @endforelse
            </div>

            <!-- Contracts Column -->
            <div class="section-column">
                <div class="section-header">
                    <div class="section-title"><span>📄</span> Contracts</div>
                    <a href="/contracts" class="view-all">View All</a>
                </div>

                @forelse($recentContracts as $contract)
                    <div class="list-card">
                        <div class="icon-box icon-contract">✓</div>
                        <div class="card-info">
                            <a href="contracts/{{$contract->id}}" class="card-main-text">
                                Contract #{{ $contract->id }}
                            </a>
                            <span class="card-sub-text">
                                {{ $contract->user->first_name ?? 'Client' }} 
                            </span>
                            <div class="card-meta">
                                <span>
                                    <span class="status-dot dot-{{ $contract->status }}"></span>
                                    <span class="status-text st-{{ $contract->status }}">{{ $contract->status }}</span>
                                </span>
                                <span style="font-weight: 700; color: var(--primary);">${{ number_format($contract->rent_fee) }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="text-align:center; padding: 20px; color: #aaa;">No recent contracts</div>
                @endforelse
            </div>

        </div>
    </div>
</x-layout>
