@props(['user'])

<a href="{{ route('users.show', $user) }}" class="user-card-link">

    <style>
        .user-card-link {
            text-decoration: none;
            display: block;
            height: 100%; /* Ensure uniform height in grids */
        }

        .user-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: var(--shadow-card);
            height: 100%;
        }

        /* Hover: Lift + Gold Border Glow */
        .user-card:hover {
            transform: translateY(-8px);
            border-color: var(--gold);
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.1);
        }

        /* --- 1. DECORATIVE HEADER --- */
        .card-header-bg {
            width: 100%;
            height: 90px;
            background: linear-gradient(135deg, rgba(93, 64, 55, 0.05), rgba(200, 168, 122, 0.15));
            position: absolute;
            top: 0; left: 0;
            z-index: 0;
        }

        /* --- 2. FLOATING AVATAR --- */
        .avatar-wrapper {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-top: 45px; /* Pushes half-way down the header */
            position: relative;
            z-index: 1;
            border: 4px solid var(--bg-card); /* Creates the 'cutout' effect */
            background: var(--bg-card);
            box-shadow: 0 8px 16px rgba(0,0,0,0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .avatar-img {
            width: 100%; height: 100%; object-fit: cover;
        }

        .avatar-initials {
            width: 100%; height: 100%;
            background: linear-gradient(135deg, var(--text-main), var(--primary));
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 28px;
            font-weight: 800;
            text-transform: uppercase;
        }

        /* --- 3. STATUS BADGE (Top Right) --- */
        .status-badge {
            position: absolute;
            top: 16px; right: 16px;
            z-index: 2;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background: var(--bg-card);
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        /* Status Colors */
        .st-verified { color: #2e7d32; border: 1px solid #e8f5e9; background: #f1f8e9; }
        .st-pending { color: #f57f17; border: 1px solid #fff3e0; background: #fff8e1; }
        .st-rejected { color: #c62828; border: 1px solid #ffebee; background: #ffebee; }
        
        /* Dark Mode Status */
        :root.dark .st-verified { background: rgba(46,125,50,0.2); border-color: transparent; color: #a5d6a7; }
        :root.dark .st-pending { background: rgba(239,108,0,0.2); border-color: transparent; color: #ffcc80; }

        /* --- 4. INFO CONTENT --- */
        .card-body {
            padding: 16px 20px 0;
            width: 100%;
            flex: 1;
            z-index: 1;
        }

        .user-name {
            color: var(--text-main);
            font-size: 18px;
            font-weight: 800;
            margin: 0 0 4px 0;
            letter-spacing: -0.5px;
        }

        .user-contact {
            color: var(--text-sub);
            font-size: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-bottom: 20px;
            opacity: 0.8;
        }

        /* --- 5. WALLET FOOTER --- */
        .card-footer {
            width: 100%;
            padding: 16px;
            background: linear-gradient(to right, rgba(0,0,0,0.02), rgba(0,0,0,0.04));
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .wallet-label {
            font-size: 11px;
            text-transform: uppercase;
            font-weight: 700;
            color: var(--text-sub);
            letter-spacing: 1px;
        }

        .wallet-amount {
            font-family: 'Plus Jakarta Sans', monospace; /* Monospace for numbers */
            font-size: 16px;
            font-weight: 800;
            color: var(--gold);
            background: rgba(200, 168, 122, 0.1);
            padding: 4px 10px;
            border-radius: 8px;
        }

    </style>

    <div class="user-card">
        
        <!-- Background Header -->
        <div class="card-header-bg"></div>

        <!-- Floating Status Badge -->
        <div class="status-badge st-{{ $user->verification_state }}">
            {{ ucfirst($user->verification_state) }}
        </div>

        <!-- Big Avatar Circle -->
        
        <div class="avatar-wrapper">
            @if($user->profileImage)
                <img src="{{ Storage::url( $user->profileImage) }} " alt="{{ $user->first_name }}" class="avatar-img">
            @else
                <div class="avatar-initials">
                    {{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}
                </div>
            @endif
        </div>

        <!-- Info Body -->
        <div class="card-body">
            <h3 class="user-name">
                {{ $user->first_name }} {{ $user->last_name }}
            </h3>
            
            <div class="user-contact">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                {{ $user->phone ?? 'No Phone' }}
            </div>
        </div>

        <!-- Wallet Footer -->
        <div class="card-footer">
            <span class="wallet-label">Balance</span>
            <span class="wallet-amount">${{ number_format($user->wallet_balance ?? 0, 2) }}</span>
        </div>

    </div>

</a>
