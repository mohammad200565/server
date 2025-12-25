@props(['rent'])

@php
    use Carbon\Carbon;
    $today = now();
    
    $startDate = Carbon::parse($rent->start_rent ?? $rent->startRent);
    $endDate   = Carbon::parse($rent->end_rent ?? $rent->endRent);
    $amount    = $rent->rentFee;
    
    // Default Values
    $dateLabel = 'End Date';
    $dateValue = $endDate->format('M d, Y');
    $statusMsg = ['label' => 'Status', 'value' => 'Unknown', 'class' => ''];

    // Dynamic Logic
    switch ($rent->status) {
        case 'onRent':
            $daysRemaining = round($today->diffInDays($endDate, false));
            $statusMsg['label'] = 'Time Left';
            $statusMsg['value'] = $daysRemaining > 0 ? $daysRemaining . ' Days' : 'Expired';
            $statusMsg['class'] = $daysRemaining < 30 ? 'text-warning' : 'text-good';
            break;

        case 'pending':
            $daysUntilStart = round($today->diffInDays($startDate, false));
            $statusMsg['label'] = 'Starts In';
            $statusMsg['value'] = $daysUntilStart > 0 ? $daysUntilStart . ' Days' : 'Soon';
            $statusMsg['class'] = 'text-warning';
            break;

        case 'completed':
            $statusMsg['label'] = 'Completed';
            $statusMsg['value'] = 'Successfully';
            $statusMsg['class'] = 'text-good';
            break;

        case 'cancelled':
            // SHOW CANCELLED DATE INSTEAD OF END DATE
            $dateLabel = 'Cancelled On';
            $dateValue = $rent->updated_at->format('M d, Y'); 
            
            $statusMsg['label'] = 'Status';
            $statusMsg['value'] = 'Terminated';
            $statusMsg['class'] = 'text-danger';
            break;
    }
@endphp

<a href="{{ route('contracts.show', $rent) }}" class="rent-card-link">

    <style>
        .rent-card-link { text-decoration: none; display: block; height: 100%; }

        .rent-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            transition: all 0.3s ease;
            position: relative;
            box-shadow: var(--shadow-card);
            height: 100%;
        }

        .rent-card:hover {
            transform: translateY(-4px);
            border-color: var(--gold);
            box-shadow: 0 12px 24px rgba(0,0,0,0.08);
        }

        /* Header */
        .card-header { display: flex; justify-content: space-between; align-items: flex-start; }
        .contract-id { font-family: monospace; font-weight: 700; color: var(--text-main); font-size: 16px; }
        .contract-label { font-size: 10px; text-transform: uppercase; color: var(--text-sub); display: block; }
        
        .status-badge {
            padding: 4px 10px; border-radius: 50px; font-size: 10px; font-weight: 800; text-transform: uppercase;
        }
        .st-onRent { background: rgba(21, 101, 192, 0.1); color: #1565c0; }
        .st-pending { background: rgba(245, 127, 23, 0.1); color: #f57f17; }
        .st-completed { background: rgba(46, 125, 50, 0.1); color: #2e7d32; }
        .st-cancelled { background: rgba(198, 40, 40, 0.1); color: #c62828; }
        
        /* Dark Mode Badge Fixes */
        :root.dark .st-onRent { background: rgba(21, 101, 192, 0.2); color: #90caf9; }
        :root.dark .st-pending { background: rgba(239, 108, 0, 0.2); color: #ffcc80; }
        :root.dark .st-completed { background: rgba(46, 125, 50, 0.2); color: #a5d6a7; }
        :root.dark .st-cancelled { background: rgba(198, 40, 40, 0.2); color: #ef9a9a; }

        /* Connection Visual */
        .parties-visual {
            display: flex; align-items: center; justify-content: space-between;
            background: var(--bg-body); padding: 12px; border-radius: 12px;
            position: relative;
        }
        .parties-visual::before {
            content: ''; position: absolute; top: 50%; left: 40px; right: 40px; height: 1px;
            border-top: 2px dashed var(--border-color); z-index: 0;
        }
        .party-node { position: relative; z-index: 1; text-align: center; background: var(--bg-body); padding: 0 4px; }
        .party-name { display: block; font-size: 12px; font-weight: 700; color: var(--text-main); max-width: 80px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .party-role { display: block; font-size: 9px; color: var(--text-sub); text-transform: uppercase; }
        .connection-icon { color: var(--gold); font-size: 14px; background: var(--bg-body); padding: 0 4px; position: relative; z-index: 1;}

        /* Data Grid (2x2) */
        .info-grid {
            display: grid; grid-template-columns: 1fr 1fr; gap: 12px 16px;
            border-top: 1px solid var(--border-color); padding-top: 16px;
        }
        .info-item { display: flex; flex-direction: column; }
        .label { font-size: 10px; text-transform: uppercase; color: var(--text-sub); font-weight: 600; margin-bottom: 2px; }
        .value { font-size: 13px; font-weight: 700; color: var(--text-main); }
        
        /* Colors */
        .text-warning { color: #f57f17; }
        .text-good { color: #2e7d32; }
        .text-danger { color: #c62828; }
        :root.dark .text-warning { color: #ffb74d; }
        :root.dark .text-good { color: #81c784; }
        :root.dark .text-danger { color: #ef9a9a; }

    </style>

    <div class="rent-card">
        
        <div class="card-header">
            <div>
                <span class="contract-label">Contract</span>
                <span class="contract-id">#{{ $rent->id }}</span>
            </div>
            <div class="status-badge st-{{ $rent->status }}">
                {{ ucfirst($rent->status) }}
            </div>
        </div>

        <div class="parties-visual">
            <div class="party-node">
                <span class="party-name">{{ $rent->user->first_name ?? 'Tenant' }}</span>
                <span class="party-role">Tenant</span>
            </div>
            <div class="connection-icon">➜</div>
            <div class="party-node">
                <span class="party-name">{{ $rent->department->user->first_name ?? 'Owner' }}</span>
                <span class="party-role">Owner</span>
            </div>
        </div>

        <div class="info-grid">
            <!-- Row 1: Start & End/Cancel Dates -->
            <div class="info-item">
                <span class="label">Start Date</span>
                <span class="value">{{ $startDate->format('M d, Y') }}</span>
            </div>
            <div class="info-item" style="text-align: right;">
                <span class="label">{{ $dateLabel }}</span>
                <span class="value" style="{{ $rent->status === 'cancelled' ? 'color: var(--text-danger);' : '' }}">
                    {{ $dateValue }}
                </span>
            </div>

            <!-- Row 2: Fee & Status -->
            <div class="info-item">
                <span class="label">Monthly Fee</span>
                <span class="value">${{ number_format($amount) }}</span>
            </div>
            <div class="info-item" style="text-align: right;">
                <span class="label">{{ $statusMsg['label'] }}</span>
                <span class="value {{ $statusMsg['class'] }}">
                    {{ $statusMsg['value'] }}
                </span>
            </div>
        </div>

    </div>
</a>
