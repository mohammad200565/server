<x-layout title="Department Details">

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
            --shadow-hover: 0 20px 40px -5px rgba(93, 64, 55, 0.15);
            --radius-xl: 24px;
            --radius-md: 16px;
            --radius-pill: 50px;
        }

        body {
            background-color: var(--bg-body);
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        }

        .department-detail-container {
            max-width: 1100px;
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
        .btn-back:hover {
            color: var(--primary);
        }

        /* --- Main Card --- */
        .department-detail-card {
            background-color: var(--bg-card);
            border-radius: var(--radius-xl);
            padding: 40px;
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(255,255,255,0.6);
        }

        /* --- Header Section --- */
        .department-header {
            display: flex;
            align-items: flex-start;
            gap: 30px;
            margin-bottom: 40px;
            padding-bottom: 30px;
            border-bottom: 1px solid #f0f0f0;
        }

        .department-image-placeholder-large {
            width: 140px;
            height: 140px;
            background: #fdfaf5;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 60px;
            flex-shrink: 0;
            border: 2px solid var(--gold-light);
        }

        .department-info {
            flex: 1;
        }

        .department-title {
            color: var(--primary);
            font-size: 28px;
            font-weight: 800;
            margin: 0 0 10px 0;
            letter-spacing: -0.5px;
        }

        /* Location Block */
        .department-location-block {
            font-size: 15px;
            color: var(--primary-soft);
            line-height: 1.6;
            margin-bottom: 20px;
        }
        
        .location-icon { margin-right: 6px; }

        /* Rent Price */
        .department-rent-large {
            font-size: 32px;
            font-weight: 800;
            color: var(--primary);
            letter-spacing: -1px;
            margin-top: 15px;
        }
        .department-rent-large span {
            font-size: 16px;
            font-weight: 600;
            color: #999;
        }

        /* Status Badge in Header */
        .header-badges {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }

        .badge-pill {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Status Colors */
        .bg-verified { background: #e8f5e9; color: #2e7d32; }
        .bg-pending { background: #fff8e1; color: #f57f17; }
        .bg-rejected { background: #ffebee; color: #c62828; }
        .bg-status { background: #f0f0f0; color: #666; }

        /* --- Details Grid --- */
        .department-details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .detail-card {
            background: #fcfcfc;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            border: 1px solid #f0f0f0;
        }

        .detail-label {
            font-size: 11px;
            text-transform: uppercase;
            color: #aaa;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .detail-value {
            font-size: 18px;
            font-weight: 800;
            color: var(--primary);
        }

        /* --- Description --- */
        .description-section {
            margin-bottom: 40px;
        }

        .section-heading {
            font-size: 18px;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .section-heading::before {
            content: '';
            width: 4px;
            height: 20px;
            background: var(--gold);
            border-radius: 2px;
        }

        .description-content {
            font-size: 15px;
            line-height: 1.7;
            color: var(--primary-soft);
            background: #fdfdfd;
            padding: 25px;
            border-radius: 12px;
            border: 1px solid #f0f0f0;
        }

        /* --- Images Grid --- */
        .images-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 40px;
        }

        .image-item {
            height: 180px;
            border-radius: 12px;
            overflow: hidden;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
            position: relative;
        }

        .image-item:hover {
            transform: scale(1.03);
            z-index: 2;
        }

        .department-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* --- Action Bar (Footer) --- */
        .verification-actions {
            background: #fcfcfc;
            padding: 20px;
            border-radius: 16px;
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            border: 1px solid #f0f0f0;
        }

        .action-btn {
            padding: 12px 24px;
            border-radius: var(--radius-pill);
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            border: none;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-verify {
            background-color: #2e7d32;
            color: white;
            box-shadow: 0 4px 12px rgba(46, 125, 50, 0.2);
        }
        .btn-verify:hover { background-color: #1b5e20; }

        .btn-reject {
            background-color: white;
            color: #c62828;
            border: 1px solid #ef9a9a;
        }
        .btn-reject:hover { background-color: #ffebee; }

        /* --- Image Modal --- */
        .image-modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.85);
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(5px);
        }

        .modal-content {
            max-width: 90%;
            max-height: 90%;
            border-radius: 8px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
        }

        .close-modal {
            position: absolute;
            top: 30px;
            right: 40px;
            color: white;
            font-size: 40px;
            font-weight: 300;
            cursor: pointer;
            transition: color 0.2s;
        }
        .close-modal:hover { color: var(--gold); }

    </style>

    <div class="department-detail-container">
        
        <!-- Back Link -->
        <a href="/departments" class="btn-back">
            ← Back to Directory
        </a>

        <div class="department-detail-card">
            
            <!-- Header -->
            <div class="department-header">
                <div class="department-image-placeholder-large">
                    🏠
                </div>
                
                <div class="department-info">
                    <div class="header-badges">
                        <!-- Verification Status -->
                        <span class="badge-pill 
                            @if($department->verification_state === 'verified') bg-verified
                            @elseif($department->verification_state === 'rejected') bg-rejected
                            @else bg-pending @endif">
                            {{ ucfirst($department->verification_state) }}
                        </span>

                        <!-- Property Status -->
                        <span class="badge-pill bg-status">
                            {{ ucfirst($department->status) }}
                        </span>
                    </div>

                    <h1 class="department-title">
                        {{ $department->location['city'] ?? 'Unknown City' }} Apartment
                    </h1>
                    
                    <div class="department-location-block">
                        <span class="location-icon">📍</span>
                        {{ $department->location['district'] ?? 'N/A' }}, 
                        {{ $department->location['street'] ?? 'Street N/A' }}<br>
                        {{ $department->location['governorate'] ?? 'Governorate' }}
                    </div>

                    <div class="department-rent-large">
                        ${{ number_format($department->rentFee) }}<span>/mo</span>
                    </div>
                </div>
            </div>

            <!-- Key Metrics Grid -->
            <div class="department-details-grid">
                <div class="detail-card">
                    <div class="detail-label">Area Size</div>
                    <div class="detail-value">{{ $department->area }} <small>m²</small></div>
                </div>
                <div class="detail-card">
                    <div class="detail-label">Bedrooms</div>
                    <div class="detail-value">{{ $department->bedrooms }}</div>
                </div>
                <div class="detail-card">
                    <div class="detail-label">Bathrooms</div>
                    <div class="detail-value">{{ $department->bathrooms }}</div>
                </div>
                <div class="detail-card">
                    <div class="detail-label">Floor Level</div>
                    <div class="detail-value">{{ $department->floor }}</div>
                </div>
            </div>

            <!-- Description -->
            <div class="description-section">
                <h3 class="section-heading">About this Property</h3>
                <div class="description-content">
                    {{ $department->description ?? 'No description provided for this property.' }}
                </div>
            </div>

            <!-- Image Gallery -->
            @if($department->images && $department->images->count() > 0)
                <div class="description-section">
                    <h3 class="section-heading">Gallery ({{ $department->images->count() }})</h3>
                    <div class="images-grid">
                        @foreach($department->images as $image)
                            <div class="image-item" onclick="openImageModal(this.querySelector('img'))">
                                <img src="{{ $image->path }}" 
                                     alt="Property Image" 
                                     class="department-image">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Verification Actions -->
            <div class="verification-actions">
                @if($department->verification_state === 'pending')
                    <form action="{{ route('departments.reject', $department) }}" method="POST">
                        @csrf @method('PUT')
                        <button type="submit" class="action-btn btn-reject">✗ Reject</button>
                    </form>
                    
                    <form action="{{ route('departments.verify', $department) }}" method="POST">
                        @csrf @method('PUT')
                        <button type="submit" class="action-btn btn-verify">✓ Verify Property</button>
                    </form>

                @elseif($department->verification_state === 'rejected')
                    <form action="{{ route('departments.verify', $department) }}" method="POST">
                        @csrf @method('PUT')
                        <button type="submit" class="action-btn btn-verify">✓ Re-Verify Property</button>
                    </form>

                @else
                    <form action="{{ route('departments.reject', $department) }}" method="POST">
                        @csrf @method('PUT')
                        <button type="submit" class="action-btn btn-reject">✗ Revoke Verification</button>
                    </form>
                @endif
            </div>

        </div>

        <!-- Modal -->
        <div id="imageModal" class="image-modal" onclick="closeImageModal()">
            <span class="close-modal">&times;</span>
            <img class="modal-content" id="modalImage">
        </div>

    </div>

    <script>
        function openImageModal(imgElement) {
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalImage');
            modal.style.display = 'flex';
            modalImg.src = imgElement.src;
            document.body.style.overflow = 'hidden'; // Prevent scrolling
        }

        function closeImageModal() {
            document.getElementById('imageModal').style.display = 'none';
            document.body.style.overflow = 'auto'; // Restore scrolling
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') closeImageModal();
        });
    </script>

</x-layout>
