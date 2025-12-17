@props(['department'])

<a href="/departments/{{$department->id}}" class="department-card-link">
    <div class="department-card">
        
        <!-- Department Image Placeholder -->
        <div class="department-image-placeholder">
            🏠
        </div>
        
        <!-- Title -->
        <div class="department-location">
            {{ $department->location['city'] ?? 'N/A' }}, 
            <span style="font-weight: 500; font-size: 0.9em; color: #888;">
                {{ $department->location['district'] ?? 'N/A' }}
            </span>
        </div>
        
        <!-- Specs -->
        <div class="department-specs">
            <div class="spec-item">
                <span class="spec-value">{{ $department->area }}</span>
                <span class="spec-label">m²</span>
            </div>
            <div class="spec-item">
                <span class="spec-value">{{ $department->bedrooms }}</span>
                <span class="spec-label">Bed</span>
            </div>
            <div class="spec-item">
                <span class="spec-value">{{ $department->bathrooms }}</span>
                <span class="spec-label">Bath</span>
            </div>
            <div class="spec-item">
                <span class="spec-value">{{ $department->floor }}</span>
                <span class="spec-label">Floor</span>
            </div>
        </div>
        
        <!-- Rent -->
        <div class="department-rent">
            ${{ number_format($department->rent_fee ?? $department->rentFee) }}/mo
        </div>
        
        <!-- Status -->
        <div>
             <div class="department-status {{ strtolower($department->status) }}">
                {{ ucfirst($department->status) }}
            </div>
        </div>
       
        <!-- Verification Badge -->
        <div>
            <div class="verification-badge 
                @if($department->verification_state === 'verified') verified
                @elseif($department->verification_state === 'rejected') rejected
                @else pending @endif">
                
                @if($department->verification_state === 'verified')
                    Verified
                @elseif($department->verification_state === 'rejected')
                    Rejected
                @else
                    Pending
                @endif
            </div>
        </div>

    </div>
</a>
