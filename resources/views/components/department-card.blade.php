@props(['department'])

<style>
    /* Specific styles for the card image/fallback */
    .dept-actual-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .department-card:hover .dept-actual-image {
        transform: scale(1.05); /* Subtle zoom effect on hover */
    }

    /* Modern Fallback Style */
    .dept-fallback-modern {
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at center, #8d6e63 0%, #5d4037 100%);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }
    
    /* Decorative SVG in background */
    .dept-fallback-icon {
        width: 80px;
        height: 80px;
        opacity: 0.15;
        color: white;
        margin-bottom: 8px;
    }

    .dept-fallback-text {
        color: rgba(255,255,255,0.7);
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        z-index: 1;
    }
</style>

<a href="/departments/{{$department->id}}" class="department-card-link">
    <div class="department-card">
        
        <!-- 1. Image / Header Section -->
        <div class="dept-image-wrapper">
            
            <!-- Verification Badge (Overlays the image) -->
            <div class="floating-badge {{ $department->verification_state }}">
                @if($department->verification_state === 'verified')
                    <span class="icon">✓</span> Verified
                @elseif($department->verification_state === 'rejected')
                    <span class="icon">✕</span> Rejected
                @else
                    <span class="icon">?</span> Pending
                @endif
            </div>

            <!-- IMAGE LOGIC -->
            @if($department->images->isNotEmpty()) 
            <!-- Actual Image -->
            <img src="{{ Storage::url($department->images->first()->path) }}" 
                alt="Department in {{ $department->location['city'] ?? 'city' }}" 
                class="dept-actual-image">
            @else
                <!-- Modern Fallback Design -->
                <div class="dept-fallback-modern">
                    <!-- Elegant SVG Icon -->
                    <svg class="dept-fallback-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19 9.3V4h-3v2.6L12 3 2 12h3v8h5v-6h4v6h5v-8h3l-9-8.7zM10 10c0-1.1.9-2 2-2s2 .9 2 2H10z"/>
                    </svg>
                    <span class="dept-fallback-text">No Image Available</span>
                </div>
            @endif

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
