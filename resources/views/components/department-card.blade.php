@props(['department'])

<style>
    /* --- Main Card & Link --- */
    .department-card-link { text-decoration: none; display: block; color: inherit; }
    .department-card {
        background-color: #ffffff;
        border-radius: 16px;
        box-shadow: 0 10px 40px -15px rgba(93, 64, 55, 0.1);
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        overflow: hidden;
    }
    .department-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px -10px rgba(93, 64, 55, 0.15);
    }
    .dept-image-wrapper {
        position: relative;
        overflow: hidden;
        aspect-ratio: 4 / 3;
        background-color: #f0e6d2;
    }
    .dept-actual-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    .department-card:hover .dept-actual-image { transform: scale(1.08); }
    .dept-fallback-modern {
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at center, #9a8a78 0%, #6f554b 100%);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: rgba(255, 255, 255, 0.8);
    }
    .dept-fallback-icon { width: 35%; max-width: 70px; height: auto; opacity: 0.2; }
    .dept-fallback-text { font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 8px; }

    /* --- ✨ FINAL FIX: High-Contrast Opaque Badge --- */
    .floating-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        z-index: 2;
        width: fit-content; 
        display: inline-flex; 
        align-items: center;
        padding: 6px 12px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 700;
        /* Removed text-shadow, border, backdrop-filter, and default color */
    }
    /* New High-Contrast, Two-Tone Styles */
    .floating-badge.verified {
        background-color: #e8f5e9; /* Light Green */
        color: #2e7d32;           /* Dark Green */
    }
    .floating-badge.rejected {
        background-color: #ffebee; /* Light Red */
        color: #c62828;           /* Dark Red */
    }
    .floating-badge.pending {
        background-color: #fff8e1; /* Light Yellow */
        color: #f57f17;           /* Dark Amber */
    }

    /* --- Card Body & Content --- */
    .dept-body { padding: 20px; }
    .dept-header-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
    .dept-price { font-size: 20px; font-weight: 800; color: #5d4037; }
    .dept-price .period { font-size: 13px; font-weight: 500; color: #999; }
    .status-pill-small { padding: 4px 10px; border-radius: 6px; font-size: 10px; font-weight: 700; text-transform: uppercase; }
    .status-pill-small.available { background-color: #e8f5e9; color: #2e7d32; }
    .status-pill-small.rented { background-color: #ffebee; color: #c62828; }
    .dept-location { font-size: 17px; font-weight: 700; color: #5d4037; margin: 0 0 15px 0; line-height: 1.3; }
    .dept-location .district { font-weight: 500; color: #8d6e63; }
    .dept-divider { height: 1px; background: #f0f0f0; margin-bottom: 15px; }
    .dept-specs-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; }
    .spec-box { text-align: center; }
    .spec-val { font-weight: 800; font-size: 15px; color: #5d4037; display: block; margin-bottom: 2px; }
    .spec-label { font-size: 11px; color: #8d6e63; }
</style>

<a href="/departments/{{$department->id}}" class="department-card-link">
    <div class="department-card">
        
        <div class="dept-image-wrapper">
            
            <div class="floating-badge {{ $department->verification_state }}">
                @if($department->verification_state === 'verified') <span>Verified</span>
                @elseif($department->verification_state === 'rejected') <span>Rejected </span>
                @else <span>Pending</span> 
                @endif
            </div>

            @if($department->images->isNotEmpty())
                <img src="{{ Storage::url($department->images->first()->path) }}" 
                     alt="Department in {{ $department->location['city'] ?? 'city' }}" 
                     class="dept-actual-image">
            @else
                <div class="dept-fallback-modern">
                    <svg class="dept-fallback-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8h5z"></path></svg>
                    <div class="dept-fallback-text">No Image</div>
                </div>
            @endif
        </div>

        <div class="dept-body">
            
            <div class="dept-header-row">
                <div class="dept-price">
                    ${{ number_format($department->rent_fee ?? $department->rentFee) }}
                    <span class="period">/day</span>
                </div>
                <div class="status-pill-small {{ strtolower($department->status) }}">
                    {{ ucfirst($department->status) }}
                </div>
            </div>

            <h3 class="dept-location">
                {{ $department->location['city'] ?? 'Unknown City' }}
                <span class="district">, {{ $department->location['district'] ?? '' }}</span>
            </h3>
            
            <div class="dept-divider"></div>

            <div class="dept-specs-grid">
                 <div class="spec-box"><div class="spec-val">{{ $department->area }}</div><div class="spec-label">m²</div></div>
                 <div class="spec-box"><div class="spec-val">{{ $department->bedrooms }}</div><div class="spec-label">Bed</div></div>
                 <div class="spec-box"><div class="spec-val">{{ $department->bathrooms }}</div><div class="spec-label">Bath</div></div>
                 <div class="spec-box"><div class="spec-val">{{ $department->floor }}</div><div class="spec-label">Floor</div></div>
            </div>
        </div>
    </div>
</a>
