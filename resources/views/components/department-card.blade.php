@props(['department'])

<a href="/departments/{{$department->id}}" class="department-card-link">

    <style>
        .department-card-link {
            text-decoration: none;
            display: block;
            height: 100%;
        }

        .department-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: var(--shadow-card);
            display: flex;
            flex-direction: column;
            height: 100%;
            position: relative;
        }

        .department-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.15);
            border-color: var(--gold);
        }

        /* --- IMAGE SECTION --- */
        .dept-image-wrapper {
            position: relative;
            width: 100%;
            padding-top: 66%; /* 3:2 Aspect Ratio */
            overflow: hidden;
            background-color: var(--bg-body);
        }

        .dept-actual-image {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .department-card:hover .dept-actual-image {
            transform: scale(1.1);
        }

        /* Fallback Design */
        .dept-fallback-modern {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: linear-gradient(135deg, var(--bg-body), var(--border-color));
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--text-sub);
        }
        .dept-fallback-icon { width: 40px; opacity: 0.3; margin-bottom: 8px; }

        /* --- FLOATING BADGES --- */
        .badge-overlay {
            position: absolute;
            top: 16px; left: 16px;
            z-index: 2;
            padding: 6px 14px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            backdrop-filter: blur(8px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        /* Verification Colors */
        .badge-verified { background: rgba(232, 245, 233, 0.9); color: #2e7d32; }
        .badge-pending  { background: rgba(255, 248, 225, 0.9); color: #f57f17; }
        .badge-rejected { background: rgba(255, 235, 238, 0.9); color: #c62828; }
        
        /* Dark Mode Badge Overrides */
        :root.dark .badge-verified { background: rgba(46, 125, 50, 0.8); color: #fff; }
        :root.dark .badge-pending  { background: rgba(245, 127, 23, 0.8); color: #fff; }
        :root.dark .badge-rejected { background: rgba(198, 40, 40, 0.8); color: #fff; }

        /* --- CARD CONTENT --- */
        .dept-body {
            padding: 24px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .dept-header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        /* Price Tag */
        .dept-price {
            font-size: 22px;
            font-weight: 800;
            color: var(--gold);
            letter-spacing: -0.5px;
        }
        .dept-price .period {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-sub);
        }

        /* Availability Status */
        .status-dot-label {
            display: flex; align-items: center; gap: 6px;
            font-size: 11px; font-weight: 700; text-transform: uppercase;
        }
        .dot-available { width: 8px; height: 8px; background: #2e7d32; border-radius: 50%; }
        .text-available { color: #2e7d32; }
        
        .dot-rented { width: 8px; height: 8px; background: #c62828; border-radius: 50%; }
        .text-rented { color: #c62828; }

        /* Dark mode status text */
        :root.dark .text-available { color: #81c784; }
        :root.dark .text-rented { color: #ef9a9a; }

        /* Location */
        .dept-location {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-main);
            margin: 0 0 4px 0;
            line-height: 1.4;
        }
        .dept-district {
            font-size: 13px;
            color: var(--text-sub);
            font-weight: 500;
            margin-bottom: 20px;
            display: block;
        }

        /* --- SPECS GRID (Icons) --- */
        .dept-divider {
            height: 1px;
            background: var(--border-color);
            margin-bottom: 16px;
            width: 100%;
        }

        .dept-specs-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
            margin-top: auto; /* Pushes to bottom */
        }

        .spec-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
        }

        .spec-icon {
            width: 20px; height: 20px;
            color: var(--text-sub);
            opacity: 0.7;
        }
        
        .spec-val {
            font-weight: 700;
            font-size: 13px;
            color: var(--text-main);
        }
        
        .spec-label {
            font-size: 10px;
            color: var(--text-sub);
            text-transform: uppercase;
            font-weight: 600;
        }
    </style>

    <div class="department-card">
        
        <!-- Image Section -->
        <div class="dept-image-wrapper">
            
            <!-- Floating Verification Badge -->
            <div class="badge-overlay badge-{{ $department->verification_state }}">
                {{ ucfirst($department->verification_state) }}
            </div>

            @if($department->images->isNotEmpty())
                <img src="{{ Storage::url($department->images->first()->path) }}" 
                     alt="Department in {{ $department->location['city'] ?? 'city' }}" 
                     class="dept-actual-image">
            @else
                <div class="dept-fallback-modern">
                    <svg class="dept-fallback-icon" fill="currentColor" viewBox="0 0 24 24"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8h5z"></path></svg>
                    <span>No Image</span>
                </div>
            @endif
        </div>

        <!-- Content Body -->
        <div class="dept-body">
            
            <div class="dept-header-row">
                <div class="dept-price">
                    ${{ number_format($department->rent_fee ?? $department->rentFee) }}
                    <span class="period">/day</span>
                </div>
                
                <!-- Availability Indicator -->
                <div class="status-dot-label">
                    <span class="dot-{{ strtolower($department->status) === 'available' ? 'available' : 'rented' }}"></span>
                    <span class="text-{{ strtolower($department->status) === 'available' ? 'available' : 'rented' }}">
                        {{ ucfirst($department->status) }}
                    </span>
                </div>
            </div>

            <div class="dept-location">
                {{ $department->location['city'] ?? 'Unknown City' }}
            </div>
            <span class="dept-district">
                {{ $department->location['district'] ?? 'District' }}
            </span>

            <div class="dept-divider"></div>

            <!-- Specs with Icons -->
            <div class="dept-specs-grid">
                <!-- Area -->
                <div class="spec-box" title="Area">
                    <svg class="spec-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                    </svg>
                    <span class="spec-val">{{ $department->area }}</span>
                    <span class="spec-label">m²</span>
                </div>

                <!-- Bedrooms -->
                <div class="spec-box" title="Bedrooms">
                    <svg class="spec-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                        <!-- Simple Bed Icon Path Override -->
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="spec-val">{{ $department->bedrooms }}</span>
                    <span class="spec-label">Bed</span>
                </div>

                <!-- Bathrooms -->
                <div class="spec-box" title="Bathrooms">
                    <svg class="spec-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                    <span class="spec-val">{{ $department->bathrooms }}</span>
                    <span class="spec-label">Bath</span>
                </div>

                <!-- Floor -->
                <div class="spec-box" title="Floor">
                    <svg class="spec-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-3a1 1 0 011-1h2a1 1 0 011 1v3m-5 0h6" />
                    </svg>
                    <span class="spec-val">{{ $department->floor }}</span>
                    <span class="spec-label">Floor</span>
                </div>
            </div>

        </div>
    </div>
</a>
