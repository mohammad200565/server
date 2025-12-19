@props(['rent'])

@php
    use Carbon\Carbon;
    $today = now();
    
    // Logic: Handle snake_case vs camelCase
    $startDate = Carbon::parse($rent->start_rent ?? $rent->startRent);
    $endDate   = Carbon::parse($rent->end_rent ?? $rent->endRent);
    $amount    = $rent->rentFee;
    
    $thirdColumn = ['label' => '', 'value' => '', 'class' => ''];
    
    switch ($rent->status) {
        case 'onRent':
            $daysRemaining = round($today->diffInDays($endDate, false));
            $thirdColumn['label'] = 'Days Remaining';
            $thirdColumn['value'] = $daysRemaining > 0 ? $daysRemaining : 'Expired';
            $thirdColumn['class'] = $daysRemaining < 30 ? 'warning' : '';
            break;
        case 'pending':
            $daysUntilStart = round($today->diffInDays($startDate, false));
            $thirdColumn['label'] = 'Starts In';
            $thirdColumn['value'] = $daysUntilStart > 0 ? $daysUntilStart . ' days' : 'Starting Soon';
            $thirdColumn['class'] = $daysUntilStart < 7 ? 'warning' : '';
            break;
        case 'completed':
            $thirdColumn['label'] = 'Completed On';
            $thirdColumn['value'] = $endDate->format('M d, Y');
            $thirdColumn['class'] = 'completed';
            break;
        case 'cancelled':
            $thirdColumn['label'] = 'Cancelled';
            $thirdColumn['value'] = '❌';
            $thirdColumn['class'] = 'cancelled';
            break;
    }
@endphp

<a href="{{ route('contracts.show', $rent) }}" class="rent-card-link">
    <div class="rent-card">
        <div class="rent-header">
            <div class="rent-id">Rent Contract</div>
            <div class="rent-status {{ $rent->status }}">
                {{ ucfirst($rent->status) }}
            </div>
        </div>
        
        <div class="rent-parties">
            <div class="party-info">
                <div class="party-label">Tenant</div>
                <div class="party-name">
                    {{ $rent->user->first_name ?? 'Unknown' }} {{ $rent->user->last_name ?? '' }}
                </div>
            </div>
            
            <div class="rent-arrow">→</div>
            
            <div class="party-info">
                <div class="party-label">Owner</div>
                <div class="party-name">
                    {{ $rent->department->user->first_name ?? 'Unknown' }} {{ $rent->department->user->last_name ?? '' }}
                </div>
            </div>
        </div>
        
        <div class="department-info">
            <div class="department-location">
                🏠 {{ $rent->department->location['city'] ?? 'N/A' }}, 
                {{ $rent->department->location['district'] ?? 'N/A' }}
            </div>
        </div>
        
        <div class="rent-details">
            <div class="rent-period">
                <div class="detail-label">Rental Period</div>
                <div class="detail-value">
                    {{ $startDate->format('Y-m-d') }} / <br>
                    {{ $endDate->format('Y-m-d') }}
                </div>
            </div>
            
            <div class="rent-fee">
                <div class="detail-label">Monthly Rent</div>
                <div class="detail-value">${{ number_format($amount, 2) }}</div>
            </div>
            
            <div class="status-info">
                <div class="detail-label">{{ $thirdColumn['label'] }}</div>
                <div class="detail-value {{ $thirdColumn['class'] }}">
                    {{ $thirdColumn['value'] }}
                </div>
            </div>
        </div>
        
        <div class="rent-footer">
            <div class="created-date">
                Created: {{ $rent->created_at->format('M d, Y') }}
            </div>
        </div>
    </div>
</a>
