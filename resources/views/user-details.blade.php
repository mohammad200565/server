<x-layout title="{{ $user->first_name }} {{ $user->last_name }} - User Details">
    <style>
        .user-detail-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
        }

        .user-detail-card {
            background-color: #f5f5f5;
            border: 2px solid #c8a87a;
            border-radius: 30px; /* Increased from 12px for smoother look */
            padding: 30px;
            box-shadow: 0 4px 8px rgba(93, 64, 55, 0.1);
        }

        .user-header {
            display: flex;
            align-items: center;
            gap: 30px;
            margin-bottom: 30px;
            border-bottom: 2px solid #a8a78d;
            padding-bottom: 20px;
        }

        .user-detail-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #c8a87a;
        }

        .user-detail-initials {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background-color: #c8a87a;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #5d4037;
            font-size: 48px;
            font-weight: bold;
            border: 4px solid #c8a87a;
        }

        .user-info {
            flex: 1;
        }

        .user-detail-name {
            color: #5d4037;
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .user-detail-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .verified {
            background-color: #4caf50;
            color: white;
        }

        .rejected {
            background-color: #f44336;
            color: white;
        }

        .pending {
            background-color: #ff9800;
            color: white;
        }

        .user-details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
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
            padding: 10px 14px; /* Increased padding */
            background-color: white;
            border-radius: 8px; /* Increased from 4px for smoother look */
            border: 1px solid #a8a78d;
        }

        .id-image-section {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #a8a78d;
        }

        .id-image-title {
            color: #5d4037;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 15px;
            text-align: center;
        }

        .id-image-container {
            text-align: center;
        }

        .id-image {
            max-width: 100%;
            max-height: 400px;
            border: 3px solid #a8a78d;
            border-radius: 12px; /* Increased from 8px for smoother look */
            box-shadow: 0 4px 8px rgba(93, 64, 55, 0.2);
        }

        .no-id-image {
            text-align: center;
            color: #5d4037;
            font-style: italic;
            padding: 20px;
            background-color: white;
            border: 1px solid #a8a78d;
            border-radius: 8px; /* Increased from 4px for smoother look */
        }

        .verification-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #a8a78d;
        }

        .btn-verify {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px; /* Increased from 6px for smoother look */
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }

        .btn-reject {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px; /* Increased from 6px for smoother look */
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }

        .btn-pending {
            background-color: #ff9800;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px; /* Increased from 6px for smoother look */
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }

        .btn-back {
            background-color: #c8a87a; /* Hazel background */
            color: #5d4037;
            border: 2px solid #c8a87a;
            padding: 12px 24px;
            border-radius: 8px; /* Increased from 6px for smoother look */
            cursor: pointer;
            font-size: 14px;
            margin-bottom: 20px;
            text-decoration: none;
            display: inline-block;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background-color: #c8a87a;
            border-color: #c8a87a;
            transform: translateY(-2px);
        }

        .user-card-link {
            text-decoration: none;
            color: inherit;
        }

        .user-card-link:hover .user-card {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(93, 64, 55, 0.15);
            transition: all 0.3s ease;
        }
    </style>

    <div class="user-detail-container">
        <a href="{{ route('users.index') }}" class="btn-back">← Back to Users</a>

        <div class="user-detail-card">
            <div class="user-header">
                @if($user->profile_image)
                    <img src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->first_name }} {{ $user->last_name }}" class="user-detail-image">
                @else
                    <div class="user-detail-initials">
                        {{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}
                    </div>
                @endif
                
                <div class="user-info">
                    <h1 class="user-detail-name">{{ $user->first_name }} {{ $user->last_name }}</h1>
                    <div class="user-detail-badge 
                        @if($user->verification_state === 'verified') verified
                        @elseif($user->verification_state === 'rejected') rejected
                        @else pending @endif">
                        @if($user->verification_state === 'verified')
                            ✓ Verified User
                        @elseif($user->verification_state === 'rejected')
                            ✗ Rejected
                        @else
                            ⏳ Pending Verification
                        @endif
                    </div>
                </div>
            </div>

            <div class="user-details-grid">
                <div class="detail-item">
                    <div class="detail-label">First Name</div>
                    <div class="detail-value">{{ $user->first_name }}</div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">Last Name</div>
                    <div class="detail-value">{{ $user->last_name }}</div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">Phone Number</div>
                    <div class="detail-value">{{ $user->phone ?? 'N/A' }}</div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">Registration Date</div>
                    <div class="detail-value">{{ $user->created_at->format('M d, Y') }}</div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">Last Updated</div>
                    <div class="detail-value">{{ $user->updated_at->format('M d, Y') }}</div>
                </div>
            </div>

            <!-- Person ID Image Section -->
            <div class="id-image-section">
                <div class="id-image-title">Person ID Document</div>
                <div class="id-image-container">
                    @if($user->person_id_image)
                        <img src="{{ asset('storage/' . $user->person_id_image) }}" alt="Person ID Document" class="id-image">
                    @else
                        <div class="no-id-image">No ID document uploaded</div>
                    @endif
                </div>
            </div>

            <!-- Verification Actions -->
            @if($user->verification_state === 'pending')
                <div class="verification-actions">
                    <form action="{{ route('users.verify', $user) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn-verify">✓ Verify User</button>
                    </form>
                    
                    <form action="{{ route('users.reject', $user) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn-reject">✗ Reject Verification</button>
                    </form>
                </div>
            @elseif($user->verification_state === 'rejected')
                <div class="verification-actions">
                    <form action="{{ route('users.verify', $user) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn-verify">✓ Verify User</button>
                    </form>
                </div>
            @else
                <div class="verification-actions">
                    <form action="{{ route('users.reject', $user) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn-reject">✗ Reject Verification</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</x-layout>