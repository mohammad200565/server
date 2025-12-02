<x-layout title="Department Details">
    <style>
        .department-detail-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 30px;
        }

        .btn-back {
            background-color: #c8a87a;
            color: #5d4037;
            border: 2px solid #c8a87a;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            margin-bottom: 20px;
            text-decoration: none;
            display: inline-block;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background-color: #9a9980;
            border-color: #9a9980;
            transform: translateY(-2px);
        }

        .department-detail-card {
            background-color: #f5f5f5;
            border: 2px solid #c8a87a;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(93, 64, 55, 0.1);
        }

        .department-header {
            display: flex;
            align-items: flex-start;
            gap: 30px;
            margin-bottom: 30px;
            border-bottom: 2px solid #c8a87a;
            padding-bottom: 20px;
        }

        .department-image-placeholder-large {
            font-size: 80px;
            background-color: #c8a87a;
            width: 150px;
            height: 150px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 4px solid #c8a87a;
        }

        .department-info {
            flex: 1;
        }

        .department-title {
            color: #5d4037;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .department-full-location {
            color: #5d4037;
            font-size: 16px;
            margin-bottom: 15px;
            line-height: 1.5;
        }

        .department-status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .department-details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .detail-item {
            margin-bottom: 15px;
        }

        .detail-label {
            color: #5d4037;
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 14px;
        }

        .detail-value {
            color: #5d4037;
            font-size: 16px;
            padding: 10px 14px;
            background-color: white;
            border-radius: 8px;
            border: 1px solid #c8a87a;
        }

        .description-section {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #c8a87a;
        }

        .description-title {
            color: #5d4037;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .description-content {
            color: #5d4037;
            font-size: 16px;
            line-height: 1.6;
            padding: 15px;
            background-color: white;
            border-radius: 8px;
            border: 1px solid #c8a87a;
        }
        .images-section {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #c8a87a;
        }

        .images-title {
            color: #5d4037;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .images-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
        }

        .image-item {
            height: 200px;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid #c8a87a;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .image-item:hover {
            transform: scale(1.05);
        }

        .department-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Image Modal Styles */
        .image-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(130, 126, 124, 0.9);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            max-width: 90%;
            max-height: 90%;
            border: 3px solid #c8a87a;
            border-radius: 8px;
        }

        .close-modal {
            position: absolute;
            top: 20px;
            right: 30px;
            color: white;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
        }

        .close-modal:hover {
            color: #c8a87a;
        }

        .verification-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #c8a87a;
        }

        .btn-verify {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }

        .btn-reject {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }

        .btn-pending {
            background-color: #ff9800;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }

        .verification-badge-detail {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .verification-badge-detail.verified {
            background-color: #4caf50;
            color: white;
        }

        .verification-badge-detail.rejected {
            background-color: #f44336;
            color: white;
        }

        .verification-badge-detail.pending {
            background-color: #ff9800;
            color: white;
        }
    </style>
    <div class="department-detail-container">
        <a href="/departments" class="btn-back">← Back to Departments</a>

        <div class="department-detail-card">
            <div class="department-header">
                <div class="department-image-placeholder-large">
                    🏠
                </div>
                
                <div class="department-info">
                    <h1 class="department-title">Department Details</h1>
                    
                    <div class="verification-badge-detail 
                        @if($department->verification_state === 'verified') verified
                        @elseif($department->verification_state === 'rejected') rejected
                        @else pending @endif">
                        @if($department->verification_state === 'verified')
                            ✓ Verified Department
                        @elseif($department->verification_state === 'rejected')
                            ✗ Rejected
                        @else
                            ⏳ Pending Verification
                        @endif
                    </div>

                    <div class="department-full-location">
                        <strong>Location:</strong><br>
                        {{ $department->location['country'] ?? 'N/A' }},<br>
                        {{ $department->location['governorate'] ?? 'N/A' }},<br>
                        {{ $department->location['city'] ?? 'N/A' }},<br>
                        {{ $department->location['district'] ?? 'N/A' }} Governorate,<br>
                        {{ $department->location['street'] ?? 'N/A' }}
                    </div>
                    
                    <div class="department-status-badge {{ $department->status }}">
                        {{ ucfirst($department->status) }}
                    </div>

                    <div class="department-rent-large" style="color: #5d4037; font-size: 24px; font-weight: bold;">
                        ${{ number_format($department->rentFee) }}/month
                    </div>
                </div>
            </div>

            <div class="department-details-grid">
                <div class="detail-item">
                    <div class="detail-label">Area</div>
                    <div class="detail-value">{{ $department->area }} m²</div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">Bedrooms</div>
                    <div class="detail-value">{{ $department->bedrooms }}</div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">Bathrooms</div>
                    <div class="detail-value">{{ $department->bathrooms }}</div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">Floor</div>
                    <div class="detail-value">{{ $department->floor }}</div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">Rent Fee</div>
                    <div class="detail-value">${{ number_format($department->rentFee, 2) }}</div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">Status</div>
                    <div class="detail-value">{{ ucfirst($department->status) }}</div>
                </div>
            </div>

            <div class="description-section">
                <div class="description-title">Description</div>
                <div class="description-content">
                    {{ $department->description }}
                </div>
            </div>
            @if($department->images && $department->images->count() > 0)
                <div class="images-section">
                    <div class="images-title">
                        Department Images ({{ $department->images->count() }})
                    </div>
                    <div class="images-grid">
                        @foreach($department->images as $image)
                            <div class="image-item">
                                <img src="{{ asset('departments_images/' . $image->path) }}" 
                                    alt="Department Image {{ $loop->iteration }}"
                                    class="department-image"
                                    onclick="openImageModal(this)">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            <div class="verification-actions">
                @if($department->verification_state === 'pending')
                    <form action="{{ route('departments.verify', $department) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn-verify">✓ Verify Department</button>
                    </form>
                    
                    <form action="{{ route('departments.reject', $department) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn-reject">✗ Reject Verification</button>
                    </form>
                @elseif($department->verification_state === 'rejected')
                    <form action="{{ route('departments.verify', $department) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn-verify">✓ Verify Department</button>
                    </form>
                @else
                    <form action="{{ route('departments.reject', $department) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn-reject">✗ Reject Verification</button>
                    </form>            
                    @endif
            </div>
        </div>
        <div id="imageModal" class="image-modal" onclick="closeImageModal()">
            <span class="close-modal" onclick="closeImageModal()">&times;</span>
            <img class="modal-content" id="modalImage">
        </div>

    </div>
    <script>
        function openImageModal(imgElement) {
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalImage');
            modal.style.display = 'flex';
            modalImg.src = imgElement.src;
        }

        function closeImageModal() {
            document.getElementById('imageModal').style.display = 'none';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('imageModal');
            if (event.target === modal) {
                closeImageModal();
            }
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>
</x-layout>