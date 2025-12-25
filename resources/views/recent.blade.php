@use('App\Models\User')
@use('App\Models\Department')
@use('App\Models\Rent')

<x-layout title="Recent Activities">

    <style>
        /* --- ANIMATIONS --- */
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
            /* No background-color set here, so it uses your Layout's Light/Dark theme */
        }

        .anim-shape {
            position: absolute;
            filter: blur(70px);
            opacity: 0.4; /* Subtle opacity to blend with your theme */
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

        .dashboard-container {
            padding: 40px;
            max-width: 1600px;
            margin: 0 auto;
        }

        /* --- HEADER --- */
        .dashboard-header {
            margin-bottom: 40px;
            animation: slideUpFade 0.6s ease-out;
        }
        .header-title h1 {
            font-size: 32px;
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -1px;
            margin: 0;
        }
        .header-title p {
            color: var(--text-sub);
            margin-top: 8px;
            font-size: 16px;
        }

        /* --- 1. STAT CARDS --- */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            margin-bottom: 50px;
        }
        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 24px;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-card);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            opacity: 0;
            animation: slideUpFade 0.6s ease-out forwards;
            
            /* Slight transparency to show animation behind */
            background: rgba(var(--bg-card), 0.8);
            backdrop-filter: blur(8px); 
        }

        /* For this to work with CSS variables that are hex codes, we usually need RGB vars. 
           Since your layout uses Hex, we will rely on opacity or assume solid bg-card. 
           If you want true glassmorphism, update --bg-card to be rgba. 
           For now, I'll keep it simple: */
        .stat-card { background: var(--bg-card); }

        .stat-card:nth-child(1) { animation-delay: 0.1s; }
        .stat-card:nth-child(2) { animation-delay: 0.2s; }
        .stat-card:nth-child(3) { animation-delay: 0.3s; }
        .stat-card:nth-child(4) { animation-delay: 0.4s; }

        .stat-card:hover {
            transform: translateY(-8px);
            border-color: var(--gold);
            box-shadow: 0 20px 40px -10px rgba(0,0,0,0.15);
        }

        .stat-content-wrapper {
            position: relative;
            z-index: 2;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .stat-icon-wrapper {
            width: 64px; height: 64px;
            border-radius: 20px;
            display: flex; align-items: center; justify-content: center;
            font-size: 28px;
            color: white;
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
            transition: transform 0.4s ease;
        }
        .stat-card:hover .stat-icon-wrapper { transform: scale(1.1) rotate(5deg); }

        /* Icon Gradients */
        .grad-blue { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); box-shadow: 0 8px 16px rgba(79, 172, 254, 0.3); }
        .grad-pink { background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 99%, #fecfef 100%); box-shadow: 0 8px 16px rgba(255, 154, 158, 0.3); }
        .grad-green { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); box-shadow: 0 8px 16px rgba(67, 233, 123, 0.3); }
        .grad-orange { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); box-shadow: 0 8px 16px rgba(250, 112, 154, 0.3); }

        .stat-info { text-align: right; }
        .stat-value { font-size: 36px; font-weight: 800; color: var(--text-main); line-height: 1.1; margin-bottom: 4px; }
        .stat-label { font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-sub); }

        .stat-watermark {
            position: absolute; bottom: -20px; left: -20px;
            font-size: 120px; opacity: 0.05; color: var(--text-main);
            pointer-events: none; z-index: 1;
        }

        /* --- 2. LIST PANELS --- */
        .content-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            align-items: start;
        }
        @media (max-width: 1200px) { .content-grid { grid-template-columns: 1fr; } }

        .panel-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            display: flex;
            flex-direction: column;
            box-shadow: var(--shadow-card);
            height: 600px;
            opacity: 0;
            animation: slideUpFade 0.6s ease-out 0.5s forwards;
        }

        .panel-header {
            padding: 24px 28px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(var(--bg-card), 0.5);
            backdrop-filter: blur(5px);
            border-radius: 24px 24px 0 0;
            flex-shrink: 0;
        }
        .panel-title { font-size: 18px; font-weight: 800; color: var(--text-main); }
        .view-link {
            font-size: 12px; font-weight: 700; color: var(--gold);
            text-decoration: none; padding: 6px 12px; border-radius: 20px;
            background: rgba(200, 168, 122, 0.1); transition: all 0.2s;
        }
        .view-link:hover { background: var(--gold); color: white; }

        .panel-body {
            padding: 16px; flex: 1; overflow-y: auto;
            scrollbar-width: thin; scrollbar-color: var(--border-color) transparent;
        }
        .panel-body::-webkit-scrollbar { width: 6px; }
        .panel-body::-webkit-scrollbar-track { background: transparent; }
        .panel-body::-webkit-scrollbar-thumb { background-color: #ddd; border-radius: 20px; }

        /* --- LIST ROW & IMAGES --- */
        .list-row {
            display: flex; align-items: center; gap: 16px;
            padding: 12px 16px; border-radius: 16px;
            transition: all 0.2s cubic-bezier(0.25, 0.8, 0.25, 1);
            text-decoration: none; margin-bottom: 8px;
            border: 1px solid transparent;
        }
        .list-row:hover {
            background: var(--bg-body); transform: translateX(5px);
            border-color: var(--border-color); box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        }
        .row-media {
            width: 48px; height: 48px;
            border-radius: 14px;
            object-fit: cover;
            flex-shrink: 0;
            border: 2px solid var(--border-color);
            background: var(--bg-body);
        }
        .row-avatar-fallback {
            width: 48px; height: 48px;
            border-radius: 14px;
            background: var(--bg-body);
            color: var(--primary);
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: 18px; flex-shrink: 0;
            border: 2px solid var(--border-color);
        }
        .contract-icon-box {
            width: 48px; height: 48px;
            border-radius: 14px;
            background: linear-gradient(135deg, #7c4dff 0%, #b388ff 100%);
            color: white;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 10px rgba(124, 77, 255, 0.3);
            flex-shrink: 0;
        }

        .row-content { flex: 1; overflow: hidden; }
        .row-title { display: block; font-size: 15px; font-weight: 700; color: var(--text-main); margin-bottom: 2px; }
        .row-subtitle { font-size: 12px; font-weight: 500; color: var(--text-sub); }

        /* --- UNIFORM BADGE SIZING --- */
        .badge {
            /* 1. Set a minimum width */
            min-width: 85px; 
            
            /* 2. Use flexbox to center text vertically and horizontally */
            display: inline-flex;
            justify-content: center;
            align-items: center;
            
            /* 3. Set a fixed height */
            height: 26px;
            
            padding: 0 10px;
            border-radius: 6px;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .badge-verified, .badge-completed, .badge-active { background: rgba(46, 125, 50, 0.1); color: #2e7d32; border: 1px solid rgba(46, 125, 50, 0.2); }
        .badge-onRent { background: rgba(21, 101, 192, 0.1); color: #1565c0; border: 1px solid rgba(21, 101, 192, 0.2); }
        .badge-pending { background: rgba(239, 108, 0, 0.1); color: #ef6c00; border: 1px solid rgba(239, 108, 0, 0.2); }
        .badge-cancelled, .badge-rejected { background: rgba(198, 40, 40, 0.1); color: #c62828; border: 1px solid rgba(198, 40, 40, 0.2); }

        /* Dark Mode Badge Adjustments */
        :root.dark .badge-verified { color: #81c784; border-color: #81c784; }
        :root.dark .badge-onRent { color: #64b5f6; border-color: #64b5f6; }
        :root.dark .badge-pending { color: #ffb74d; border-color: #ffb74d; }
        :root.dark .badge-cancelled { color: #e57373; border-color: #e57373; }

        .price-tag {
            font-weight: 800; color: var(--primary);
            font-size: 14px; background: var(--bg-body);
            padding: 4px 8px; border-radius: 6px;
        }
    </style>

    <!-- Animation Layer (Behind Content) -->
    <div class="bg-animation-layer">
        <div class="anim-shape shape-1"></div>
        <div class="anim-shape shape-2"></div>
    </div>

    <div class="dashboard-container">
        
        <div class="dashboard-header">
            <div class="header-title">
                <h1>Overview</h1>
                <p>Welcome back! Here's what's happening today.</p>
            </div>
        </div>

        <!-- 1. STATS GRID -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-watermark">👥</div>
                <div class="stat-content-wrapper">
                    <div class="stat-icon-wrapper grad-blue">
                        <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value">{{ $totalUsers ?? User::count()-1 }}</div>
                        <div class="stat-label">Total Users</div>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-watermark">🏢</div>
                <div class="stat-content-wrapper">
                    <div class="stat-icon-wrapper grad-pink">
                        <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-3a1 1 0 011-1h2a1 1 0 011 1v3m-5 0h6"></path></svg>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value">{{ $totalDepartments ?? Department::count() }}</div>
                        <div class="stat-label">Departments</div>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-watermark">📄</div>
                <div class="stat-content-wrapper">
                    <div class="stat-icon-wrapper grad-green">
                        <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value">{{ $totalContracts ?? Rent::where('status', 'onRent')->count() }}</div>
                        <div class="stat-label">Active Contracts</div>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-watermark">⚠️</div>
                <div class="stat-content-wrapper">
                    <div class="stat-icon-wrapper grad-orange">
                        <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value" style="color: #ef6c00;">{{ $pendingUsers ?? User::where('verification_state', 'pending')->count() }}</div>
                        <div class="stat-label">Pending Review</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. CONTENT LISTS -->
        <div class="content-grid">
            
            <div class="panel-card">
                <div class="panel-header">
                    <div class="panel-title">New Users</div>
                    <a href="/users" class="view-link">View All</a>
                </div>
                <div class="panel-body">
                    @forelse($recentUsers as $user)
                        <a href="/users/{{$user->id}}" class="list-row">
                            @if($user->profileImage)
                                <img src="{{ asset('storage/' . $user->profileImage) }}" alt="{{ $user->first_name }}" class="row-media">
                            @else
                                <div class="row-avatar-fallback">
                                    {{ substr($user->first_name, 0, 1) }}
                                </div>
                            @endif
                            
                            <div class="row-content">
                                <span class="row-title">{{ $user->first_name }} {{ $user->last_name }}</span>
                                <span class="row-subtitle">{{ $user->created_at->diffForHumans() }}</span>
                            </div>
                            
                            <!-- Badges Uniform Size -->
                            <div class="badge badge-{{ $user->verification_state }}">
                                {{ $user->verification_state }}
                            </div>
                        </a>
                    @empty
                        <div style="text-align:center; padding: 40px; color: var(--text-sub);">No new users</div>
                    @endforelse
                </div>
            </div>

            <div class="panel-card">
                <div class="panel-header">
                    <div class="panel-title">Recent Departments</div>
                    <a href="/departments" class="view-link">View All</a>
                </div>
                <div class="panel-body">
                    @forelse($recentDepartments as $department)
                        <a href="/departments/{{$department->id}}" class="list-row">
                            @if($department->images && $department->images->count() > 0)
                                <img src="{{ asset('storage/' . $department->images->first()->path) }}" alt="Department" class="row-media">
                            @else
                                <div class="row-avatar-fallback" style="background: rgba(194, 24, 91, 0.1); color: #c2185b; border-color: transparent;">
                                    🏢
                                </div>
                            @endif
                            <div class="row-content">
                                <span class="row-title">{{ $department->location['city'] ?? 'City' }}</span>
                                <span class="row-subtitle">{{ $department->area }}m² • {{ $department->bedrooms }} Bed</span>
                            </div>
                            <div class="price-tag">
                                ${{ number_format($department->rent_fee) }}
                            </div>
                        </a>
                    @empty
                        <div style="text-align:center; padding: 40px; color: var(--text-sub);">No new units</div>
                    @endforelse
                </div>
            </div>

            <div class="panel-card">
                <div class="panel-header">
                    <div class="panel-title">Contracts</div>
                    <a href="/contracts" class="view-link">View All</a>
                </div>
                <div class="panel-body">
                    @forelse($recentContracts as $contract)
                        <a href="contracts/{{$contract->id}}" class="list-row">
                            <div class="contract-icon-box">
                                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div class="row-content">
                                <span class="row-title">Contract #{{ $contract->id }}</span>
                                <span class="row-subtitle">{{ $contract->user->first_name ?? 'Client' }}</span>
                            </div>
                            <div class="badge badge-{{ $contract->status }}">
                                {{ $contract->status }}
                            </div>
                        </a>
                    @empty
                        <div style="text-align:center; padding: 40px; color: var(--text-sub);">No recent contracts</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-layout>
