<x-layout title="Department Details">

    <style>
        /* 
           PAGE STYLES
           Adapting to global theme variables for Dark Mode support
        */

        .department-detail-container { 
            max-width: 1100px; 
            margin: 0 auto; 
            padding: 40px; 
        }

        .btn-back { 
            display: inline-flex; 
            align-items: center; 
            gap: 8px; 
            color: var(--text-sub); 
            text-decoration: none; 
            font-weight: 600; 
            font-size: 14px; 
            margin-bottom: 24px; 
            transition: color 0.2s ease; 
        }

        .btn-back:hover { color: var(--primary); }

        .department-detail-card { 
            background-color: var(--bg-card); 
            border-radius: var(--radius-xl); /* Using global radius variable */
            padding: 40px; 
            box-shadow: var(--shadow-card); 
            border: 1px solid var(--border-color); 
        }

        /* --- Header --- */
        .department-header { 
            display: flex; 
            align-items: flex-start; 
            gap: 30px; 
            margin-bottom: 40px; 
            padding-bottom: 30px; 
            border-bottom: 1px solid var(--border-color); 
        }

        /* Image Wrapper */
        .department-header-image-wrapper {
            position: relative;
            flex-shrink: 0;
            cursor: pointer;
        }

        .department-header-image {
            width: 240px; height: 180px; 
            border-radius: 16px; 
            object-fit: cover;
            border: 4px solid var(--bg-card); /* Adaptive border */
            box-shadow: var(--shadow-header);
            display: block;
        }

        .department-fallback-rect {
            width: 240px; height: 180px; 
            border-radius: 16px;
            background: radial-gradient(circle at center, var(--primary-soft) 0%, var(--primary) 100%);
            display: flex; 
            align-items: center; 
            justify-content: center; 
            flex-shrink: 0;
            border: 4px solid var(--bg-card); 
            box-shadow: var(--shadow-header);
            color: rgba(255,255,255,0.8);
        }

        .department-fallback-rect svg { width: 60px; height: 60px; opacity: 0.25; color: white; }

        /* --- Header Info --- */
        .department-info { flex: 1; }

        .department-title { 
            color: var(--text-main); 
            font-size: 28px; 
            font-weight: 800; 
            margin: 0 0 10px 0; 
            letter-spacing: -0.5px; 
        }

        .department-location-block { 
            font-size: 15px; 
            color: var(--text-sub); 
            line-height: 1.6; 
            margin-bottom: 20px; 
        }

        .location-icon { margin-right: 6px; }

        .department-rent-large { 
            font-size: 32px; 
            font-weight: 800; 
            color: var(--primary); 
            letter-spacing: -1px; 
            margin-top: 15px; 
        }

        .department-rent-large span { font-size: 16px; font-weight: 600; color: var(--text-sub); }

        .header-badges { display: flex; gap: 10px; margin-bottom: 15px; }

        .badge-pill { 
            padding: 6px 14px; 
            border-radius: 20px; 
            font-size: 12px; 
            font-weight: 700; 
            text-transform: uppercase; 
            letter-spacing: 0.5px; 
        }

        /* Status Colors - using rgba for better blending */
        .bg-verified { background: rgba(46, 125, 50, 0.15); color: #2e7d32; }
        .bg-pending { background: rgba(245, 127, 23, 0.15); color: #f57f17; }
        .bg-rejected { background: rgba(198, 40, 40, 0.15); color: #c62828; }
        .bg-status { background: var(--bg-body); color: var(--text-sub); border: 1px solid var(--border-color); }

        /* Dark Mode Text Adjustments */
        :root.dark .bg-verified { color: #81c784; }
        :root.dark .bg-pending { color: #ffb74d; }
        :root.dark .bg-rejected { color: #e57373; }

        /* --- Details Grid --- */
        .department-details-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); 
            gap: 20px; 
            margin-bottom: 40px; 
        }

        .detail-card { 
            background: var(--bg-body); 
            padding: 20px; 
            border-radius: 12px; 
            text-align: center; 
            border: 1px solid var(--border-color); 
        }

        .detail-label { 
            font-size: 11px; 
            text-transform: uppercase; 
            color: var(--text-sub); 
            font-weight: 700; 
            letter-spacing: 0.5px; 
            margin-bottom: 8px; 
        }

        .detail-value { 
            font-size: 18px; 
            font-weight: 800; 
            color: var(--text-main); 
        }

        /* --- Description --- */
        .description-section { margin-bottom: 40px; }

        .section-heading { 
            font-size: 18px; 
            font-weight: 800; 
            color: var(--text-main); 
            margin-bottom: 15px; 
            display: flex; 
            align-items: center; 
            gap: 10px; 
        }

        .section-heading::before { 
            content: ''; 
            width: 4px; height: 20px; 
            background: var(--gold); 
            border-radius: 2px; 
        }

        .description-content { 
            font-size: 15px; 
            line-height: 1.7; 
            color: var(--text-main); 
            background: var(--bg-body); 
            padding: 25px; 
            border-radius: 12px; 
            border: 1px solid var(--border-color); 
        }

        /* --- Images Grid --- */
        .images-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); 
            gap: 16px; 
            margin-bottom: 40px; 
        }

        .image-item {
            position: relative; height: 180px; border-radius: 12px;
            overflow: hidden; cursor: pointer; box-shadow: var(--shadow-soft);
            transition: transform 0.3s ease;
            border: 1px solid var(--border-color);
        }

        .image-item:hover { transform: scale(1.03); z-index: 2; border-color: var(--gold); }

        .department-image { width: 100%; height: 100%; object-fit: cover; }

        /* Image Hover Overlay */
        .image-zoom-hover {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            border-radius: 12px; background: rgba(0,0,0,0.3); color: white;
            display: flex; align-items: center; justify-content: center; font-size: 24px;
            opacity: 0; transition: opacity 0.3s ease; pointer-events: none;
        }

        .department-header-image-wrapper:hover .image-zoom-hover,
        .image-item:hover .image-zoom-hover { opacity: 1; }

        .department-header-image-wrapper .image-zoom-hover { border-radius: 16px; }

        /* --- Verification Actions --- */
        .verification-actions { 
            background: var(--bg-body); 
            padding: 20px; 
            border-radius: 16px; 
            display: flex; 
            justify-content: flex-end; 
            gap: 15px; 
            border: 1px solid var(--border-color); 
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
            background-color: var(--bg-card); 
            color: #c62828; 
            border: 1px solid #ef9a9a; 
        }

        .btn-reject:hover { background-color: #ffebee; }

        /* Dark mode reject hover fix */
        :root.dark .btn-reject:hover { background-color: rgba(198, 40, 40, 0.1); }

        /* --- Image Modal --- */
        .image-modal {
            display: none; position: fixed; z-index: 2000; left: 0; top: 0;
            width: 100%; height: 100%; background-color: rgba(10, 5, 2, 0.95);
            justify-content: center; align-items: center; backdrop-filter: blur(8px);
            animation: fadeIn 0.3s;
        }

        .modal-content-wrapper { display: flex; justify-content: center; align-items: center; width: 100%; height: 100%; }

        .modal-image { 
            max-width: 85vw; max-height: 85vh; 
            border-radius: 8px; 
            box-shadow: 0 20px 50px rgba(0,0,0,0.5); 
            animation: zoomIn 0.3s; 
        }

        .close-modal { 
            position: absolute; top: 20px; right: 35px; 
            color: #f1f1f1; font-size: 40px; font-weight: bold; 
            transition: 0.3s; cursor: pointer; 
        }

        .close-modal:hover { color: var(--gold); }

        /* Modal Nav */
        .modal-nav {
            position: absolute; top: 50%; transform: translateY(-50%);
            background: rgba(255,255,255,0.1); color: white; border: none;
            font-size: 32px; padding: 10px 15px; cursor: pointer;
            transition: background 0.2s; user-select: none; border-radius: 8px;
        }

        .modal-nav:hover { background: rgba(255,255,255,0.2); color: var(--gold); }

        .modal-prev { left: 20px; }
        .modal-next { right: 20px; }
        
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes zoomIn { from { transform: scale(0.8); } to { transform: scale(1); } }
    </style>

    <div class="department-detail-container">

        <a href="/departments" class="btn-back">← Back to Directory</a>

        <div class="department-detail-card">
            
            <div class="department-header">
                <!-- Header Image -->
                @if($department->images->isNotEmpty())
                    <div class="department-header-image-wrapper gallery-item">
                        <img src="{{ asset('storage/' . $department->images->first()->path) }}" alt="Department Image" class="department-header-image">
                        <div class="image-zoom-hover">🔍</div>
                    </div>
                @else
                    <div class="department-fallback-rect">
                        <svg fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M19 9.3V4h-3v2.6L12 3 2 12h3v8h5v-6h4v6h5v-8h3l-9-8.7zM10 10c0-1.1.9-2 2-2s2 .9 2 2H10z"/></svg>
                    </div>
                @endif
                
                <!-- Header Info -->
                 <div class="department-info">
                    <div class="header-badges">
                        <span class="badge-pill @if($department->verification_state === 'verified') bg-verified @elseif($department->verification_state === 'rejected') bg-rejected @else bg-pending @endif">{{ ucfirst($department->verification_state) }}</span>
                        <span class="badge-pill bg-status">{{ ucfirst($department->status) }}</span>
                    </div>

                    <h1 class="department-title">{{ $department->location['city'] ?? 'Unknown City' }} Apartment</h1>
                    
                    <div class="department-location-block">
                        <span class="location-icon">📍</span>
                        {{ $department->location['district'] ?? 'N/A' }}, {{ $department->location['street'] ?? 'Street N/A' }}<br>
                        {{ $department->location['governorate'] ?? 'Governorate' }}
                    </div>

                    <div class="department-rent-large">${{ number_format($department->rentFee) }}<span>/mo</span></div>
                </div>
            </div>

            <!-- Details Grid -->
            <div class="department-details-grid">
                <div class="detail-card"><div class="detail-label">Area Size</div><div class="detail-value">{{ $department->area }} <small>m²</small></div></div>
                <div class="detail-card"><div class="detail-label">Bedrooms</div><div class="detail-value">{{ $department->bedrooms }}</div></div>
                <div class="detail-card"><div class="detail-label">Bathrooms</div><div class="detail-value">{{ $department->bathrooms }}</div></div>
                <div class="detail-card"><div class="detail-label">Floor Level</div><div class="detail-value">{{ $department->floor }}</div></div>
            </div>

            <div class="description-section">
                <h3 class="section-heading">About this Department</h3>
                <div class="description-content">{{ $department->description ?? 'No description provided for this department.' }}</div>
            </div>

            <!-- Image Gallery -->
            @if($department->images && $department->images->count() > 0)
                <div class="description-section">
                    <h3 class="section-heading">Gallery ({{ $department->images->count() }})</h3>
                    <div class="images-grid">
                        @foreach($department->images as $image)
                            <div class="image-item gallery-item">
                                <img src="{{ Storage::url($image->path) }}" alt="Department Image" class="department-image">
                                <div class="image-zoom-hover">🔍</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Verification Actions -->
             <div class="verification-actions">
                 @if($department->verification_state === 'pending')
                    <form action="{{ route('departments.reject', $department) }}" method="POST">@csrf @method('PUT')<button type="submit" class="action-btn btn-reject">✗ Reject</button></form>
                    <form action="{{ route('departments.verify', $department) }}" method="POST">@csrf @method('PUT')<button type="submit" class="action-btn btn-verify">✓ Verify Department</button></form>
                @elseif($department->verification_state === 'rejected')
                    <form action="{{ route('departments.verify', $department) }}" method="POST">@csrf @method('PUT')<button type="submit" class="action-btn btn-verify">✓ Re-Verify Department</button></form>
                @else
                    <form action="{{ route('departments.reject', $department) }}" method="POST">@csrf @method('PUT')<button type="submit" class="action-btn btn-reject">✗ Revoke Verification</button></form>
                @endif
            </div>
        </div>

        <!-- Image Modal -->
        <div id="imageModal" class="image-modal">
            <span class="close-modal" onclick="closeImageModal()">&times;</span>
            <button class="modal-nav modal-prev" onclick="showPrevImage()">&#10094;</button>
            <div class="modal-content-wrapper">
                <img class="modal-image" id="modalImage">
            </div>
            <button class="modal-nav modal-next" onclick="showNextImage()">&#10095;</button>
        </div>

    </div>

    <script>
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');
        
        let galleryImages = [];
        let currentImageIndex;

        // Gather all gallery images when the page loads
        document.addEventListener('DOMContentLoaded', () => {
            const galleryItems = document.querySelectorAll('.gallery-item');
            galleryItems.forEach((item, index) => {
                const img = item.querySelector('img');
                if (img) {
                    galleryImages.push(img.src);
                    item.addEventListener('click', () => openImageModal(index));
                }
            });
        });

        function openImageModal(index) {
            if (galleryImages.length === 0) return;
            currentImageIndex = index;
            updateModalImage();
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function updateModalImage() {
            modalImg.src = galleryImages[currentImageIndex];
        }

        function closeImageModal() {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Navigation functions
        function showNextImage() {
            currentImageIndex = (currentImageIndex + 1) % galleryImages.length;
            updateModalImage();
        }

        function showPrevImage() {
            currentImageIndex = (currentImageIndex - 1 + galleryImages.length) % galleryImages.length;
            updateModalImage();
        }
        
        // Add keyboard navigation
        document.addEventListener('keydown', function(event) {
            if (modal.style.display === 'flex') {
                if (event.key === 'Escape') closeImageModal();
                if (event.key === 'ArrowRight') showNextImage();
                if (event.key === 'ArrowLeft') showPrevImage();
            }
        });

        // Close modal on background click
        modal.addEventListener('click', function(event) {
            if (event.target === modal || event.target.classList.contains('modal-content-wrapper')) {
                closeImageModal();
            }
        });
    </script>

</x-layout>
