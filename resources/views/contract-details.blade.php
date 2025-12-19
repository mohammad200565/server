@php
    use Carbon\Carbon;
    $today = now();
    $startDate = Carbon::parse($rent->startRent);
    $endDate = Carbon::parse($rent->endRent);
    
    // Calculate progress for timeline
    $totalDays = $startDate->diffInDays($endDate);
    $daysPassed = $startDate->diffInDays(min($today, $endDate));
    $progress = $totalDays > 0 ? min(100, max(0, ($daysPassed / $totalDays) * 100)) : 0;
    
    $daysRemaining = round($today->diffInDays($endDate, false));
@endphp

<x-layout title="Contract #{{ $rent->id }} Details">

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
            --radius-xl: 24px;
            --radius-md: 16px;
            --radius-pill: 50px;
        }

        body {
            background-color: var(--bg-body);
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        }

        .contract-detail-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 40px;
        }

        /* --- Back Button --- */
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--primary-soft);
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 24px;
            transition: color 0.2s ease;
        }
        .btn-back:hover { color: var(--primary); }

        /* --- Main Card --- */
        .contract-detail-card {
            background-color: var(--bg-card);
            border-radius: var(--radius-xl);
            padding: 40px;
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(255,255,255,0.6);
        }

        /* --- Header --- */
        .contract-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 1px solid #f0f0f0;
        }

        .contract-title {
            font-size: 32px;
            font-weight: 800;
            color: var(--primary);
            margin: 0;
            letter-spacing: -1px;
        }
        .contract-subtitle {
            color: #999;
            font-size: 14px;
            margin-top: 5px;
        }

        /* --- Status Badge --- */
        .status-badge-lg {
            padding: 8px 20px;
            border-radius: var(--radius-pill);
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .st-onRent { background: #e3f2fd; color: #1565c0; }
        .st-pending { background: #fff8e1; color: #f57f17; }
        .st-completed { background: #e8f5e9; color: #2e7d32; }
        .st-cancelled { background: #ffebee; color: #c62828; }

        /* --- Parties Section (Tenant -> Owner) --- */
        .parties-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fdfdfd;
            border: 1px solid #f0f0f0;
            border-radius: var(--radius-md);
            padding: 30px;
            margin-bottom: 40px;
            position: relative;
        }

        .party-card {
            flex: 1;
            text-align: center;
        }

        .party-role {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #aaa;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .party-name {
            font-size: 18px;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 4px;
            text-decoration: none;
            display: block;
        }
        .party-name:hover { color: var(--gold); }

        .party-detail {
            font-size: 13px;
            color: var(--primary-soft);
        }

        .contract-arrow {
            font-size: 24px;
            color: var(--gold);
            padding: 0 40px;
            opacity: 0.5;
        }

        /* --- Section Titles --- */
        .section-title {
            font-size: 18px;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .section-title::before {
            content: '';
            width: 4px;
            height: 20px;
            background: var(--gold);
            border-radius: 2px;
        }

        /* --- Terms Grid --- */
        .terms-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .term-card {
            background: #fcfcfc;
            padding: 20px;
            border-radius: 12px;
            border: 1px solid #f0f0f0;
            text-align: center;
        }

        .term-label {
            font-size: 12px;
            color: #aaa;
            font-weight: 600;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .term-value {
            font-size: 20px;
            font-weight: 800;
            color: var(--primary);
        }

        /* Value Colors */
        .val-money { color: var(--primary); }
        .val-good { color: #2e7d32; }
        .val-warn { color: #f57f17; }
        .val-bad { color: #c62828; }

        /* --- Timeline --- */
        .timeline-container {
            background: #fcfcfc;
            padding: 30px;
            border-radius: var(--radius-md);
            border: 1px solid #f0f0f0;
            margin-bottom: 40px;
        }

        .timeline-dates {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            font-weight: 600;
            color: var(--primary-soft);
            margin-bottom: 12px;
        }

        .progress-track {
            height: 10px;
            background: #eee;
            border-radius: 5px;
            overflow: hidden;
            margin-bottom: 12px;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--gold) 0%, var(--primary) 100%);
            border-radius: 5px;
            transition: width 1s ease;
        }

        .timeline-status {
            text-align: center;
            font-size: 13px;
            font-weight: 600;
        }

        /* --- Property Details --- */
        .property-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            background: #fdfaf5; /* Subtle gold tint bg */
            padding: 25px;
            border-radius: var(--radius-md);
            border: 1px solid rgba(200, 168, 122, 0.2);
        }

        .prop-item {
            margin-bottom: 10px;
        }
        .prop-label { font-size: 12px; color: #999; font-weight: 600; }
        .prop-val { font-size: 15px; font-weight: 700; color: var(--primary); }

        /* --- Footer Meta --- */
        .contract-footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            color: #aaa;
            font-size: 12px;
        }

        @media (max-width: 600px) {
            .parties-section { flex-direction: column; gap: 20px; }
            .contract-arrow { transform: rotate(90deg); padding: 10px 0; }
        }
    </style>

    <div class="contract-detail-container">
        
        <!-- Back Link -->
        <a href="{{ route('contracts.index') }}" class="btn-back">
            ← Back to Contracts
        </a>

        <div class="contract-detail-card">
            
            <!-- Header -->
            <div class="contract-header">
                <div>
                    <h1 class="contract-title">Contract #{{ $rent->id }}</h1>
                    <div class="contract-subtitle">Rental Agreement View</div>
                </div>
                
                <div class="status-badge-lg st-{{ $rent->status }}">
                    {{ ucfirst($rent->status) }}
                </div>
            </div>

            <!-- Parties (Tenant -> Owner) -->
            <div class="parties-section">
                <!-- Tenant -->
                <div class="party-card">
                    <div class="party-role">Tenant</div>
                    <a href="{{ route('users.show', $rent->user) }}" class="party-name">
                        {{ $rent->user->first_name }} {{ $rent->user->last_name }}
                    </a>
                    <div class="party-detail">
                        {{ $rent->user->phone ?? 'No Phone' }}
                    </div>
                </div>

                <!-- Divider -->
                <div class="contract-arrow">➜</div>

                <!-- Owner -->
                <div class="party-card">
                    <div class="party-role">Department Owner</div>
                    <a href="{{ route('users.show', $rent->department->user) }}" class="party-name">
                        {{ $rent->department->user->first_name }} {{ $rent->department->user->last_name }}
                    </a>
                    <div class="party-detail">
                        {{ $rent->department->user->phone ?? 'No Phone' }}
                    </div>
                </div>
            </div>

            <!-- Financial & Date Terms -->
            <div class="section-title">Terms & Conditions</div>
            <div class="terms-grid">
                
                <div class="term-card">
                    <div class="term-label">Monthly Rent</div>
                    <div class="term-value val-money">${{ number_format(0, 2) }}</div>
                </div>

                <div class="term-card">
                    <div class="term-label">Start Date</div>
                    <div class="term-value">{{ $startDate->format('M d, Y') }}</div>
                </div>

                <div class="term-card">
                    <div class="term-label">End Date</div>
                    <div class="term-value">{{ $endDate->format('M d, Y') }}</div>
                </div>

                <div class="term-card">
                    <div class="term-label">Status</div>
                    <div class="term-value 
                        {{ $daysRemaining < 0 ? 'val-bad' : ($daysRemaining < 30 ? 'val-warn' : 'val-good') }}">
                        @if($daysRemaining < 0)
                            Expired
                        @else
                            {{ $daysRemaining }} Days Left
                        @endif
                    </div>
                </div>
            </div>

            <!-- Timeline -->
            @if($rent->status === 'onRent' || $rent->status === 'pending')
                <div class="section-title">Timeline Progress</div>
                <div class="timeline-container">
                    <div class="timeline-dates">
                        <span>{{ $startDate->format('d M') }}</span>
                        <span>Today</span>
                        <span>{{ $endDate->format('d M') }}</span>
                    </div>
                    
                    <div class="progress-track">
                        <div class="progress-fill" style="width: {{ $progress }}%;"></div>
                    </div>

                    <div class="timeline-status">
                        @if($today < $startDate)
                            <span class="val-warn">Future Contract: Starts in {{ number_format($today->diffInDays($startDate),0) }} days</span>
                        @elseif($today > $endDate)
                            <span class="val-bad">Contract Ended</span>
                        @else
                            <span class="val-good">{{ number_format($progress, 0) }}% Completed</span>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Property Details Summary -->
            <div class="section-title">Department Information</div>
            <div class="property-grid">
                <div class="prop-item">
                    <div class="prop-label">Address</div>
                    <div class="prop-val">
                        {{ $rent->department->location['city'] ?? '' }}, 
                        {{ $rent->department->location['district'] ?? '' }}
                    </div>
                </div>
                <div class="prop-item">
                    <div class="prop-label">Specs</div>
                    <div class="prop-val">
                        {{ $rent->department->bedrooms }} Bed • {{ $rent->department->bathrooms }} Bath • {{ $rent->department->area }}m²
                    </div>
                </div>
                <div class="prop-item">
                    <div class="prop-label">Floor</div>
                    <div class="prop-val">{{ $rent->department->floor }}</div>
                </div>
                <div class="prop-item">
                    <div class="prop-label">Description</div>
                    <div class="prop-val" style="font-weight: 500; font-size: 13px;">
                        {{ Str::limit($rent->department->description, 60) }}
                    </div>
                </div>
            </div>

            <!-- Footer Meta -->
            <div class="contract-footer">
                <div>Created: {{ $rent->created_at->format('M d, Y H:i') }}</div>
                <div>Last Updated: {{ $rent->updated_at->format('M d, Y H:i') }}</div>
            </div>

        </div>
    </div>

</x-layout>
