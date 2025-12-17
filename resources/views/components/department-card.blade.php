@props(['department'])

<a href="/departments/{{$department->id}}" class="department-card-link">
    <div class="department-card">
        
        <!-- 1. Image / Header Section -->
        <div class="dept-image-wrapper">
            <!-- Verification Badge -->
            <div class="floating-badge {{ $department->verification_state }}">
                @if($department->verification_state === 'verified')
                    <span class="icon">✓</span> Verified
                @elseif($department->verification_state === 'rejected')
                    <span class="icon">✕</span> Rejected
                @else
                    <span class="icon">?</span> Pending
                @endif
            </div>

            <!-- Image Placeholder -->
            <div class="dept-placeholder-pattern">
                <div class="dept-icon-circle">
                    🏢
                </div>
            </div>
        </div>

        <!-- 2. Content Body -->
        <div class="dept-body">
            
            <!-- Price & Status Row -->
            <div class="dept-header-row">
                <div class="dept-price">
                    ${{ number_format($department->rent_fee ?? $department->rentFee) }}
                    <span class="period">/mo</span>
                </div>
                <div class="status-pill-small {{ strtolower($department->status) }}">
                    {{ ucfirst($department->status) }}
                </div>
            </div>

            <!-- Location -->
            <h3 class="dept-location">
                {{ $department->location['city'] ?? 'Unknown City' }}
                <span class="district">, {{ $department->location['district'] ?? '' }}</span>
            </h3>

            <!-- Divider -->
            <div class="dept-divider"></div>

            <!-- Specs Grid -->
            <div class="dept-specs-grid">
                <div class="spec-box">
                    <span class="spec-icon">📐</span>
                    <div class="spec-info">
                        <span class="spec-val">{{ $department->area }}</span>
                        <span class="spec-label">m²</span>
                    </div>
                </div>
                
                <div class="spec-box">
                    <span class="spec-icon">🛏️</span>
                    <div class="spec-info">
                        <span class="spec-val">{{ $department->bedrooms }}</span>
                        <span class="spec-label">Bed</span>
                    </div>
                </div>

                <div class="spec-box">
                    <span class="spec-icon">🚿</span>
                    <div class="spec-info">
                        <span class="spec-val">{{ $department->bathrooms }}</span>
                        <span class="spec-label">Bath</span>
                    </div>
                </div>

                <div class="spec-box">
                    <span class="spec-icon">🪜</span>
                    <div class="spec-info">
                        <span class="spec-val">{{ $department->floor }}</span>
                        <span class="spec-label">Floor</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</a>
