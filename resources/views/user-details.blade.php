<x-layout title="{{ $user->first_name }} {{ $user->last_name }} - User Details">
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
        .user-detail-container {
            max-width: 900px;
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
        .btn-back:hover { color: var(--primary); }
        /* --- Main Card --- */
        .user-detail-card {
            background-color: var(--bg-card);
            border-radius: var(--radius-xl);
            padding: 40px;
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(255,255,255,0.6);
        }
        /* --- Header Section --- */
        .user-header {
            display: flex;
            align-items: center;
            gap: 30px;
            margin-bottom: 40px;
            padding-bottom: 30px;
            border-bottom: 1px solid #f0f0f0;
        }
        .user-image-wrapper {
            position: relative;
        }
        .user-detail-image, .user-detail-initials {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            object-fit: cover;
        }
        .user-detail-initials {
            background-color: var(--gold-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            font-weight: 800;
        }
        .user-info {
            flex: 1;
        }
        .user-name-large {
            font-size: 32px;
            font-weight: 800;
            color: var(--primary);
            margin: 0 0 10px 0;
            letter-spacing: -1px;
        }
        /* --- Status Badge --- */
        .status-badge-large {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: var(--radius-pill);
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .bg-verified { background: #e8f5e9; color: #2e7d32; }
        .bg-pending { background: #fff8e1; color: #f57f17; }
        .bg-rejected { background: #ffebee; color: #c62828; }
        
        /* --- Details Grid --- */
        .user-details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        .detail-item {
            background: #fcfcfc;
            padding: 20px;
            border-radius: 12px;
            border: 1px solid #f0f0f0;
        }
        .detail-label {
            font-size: 11px;
            text-transform: uppercase;
            color: #aaa;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }
        .detail-value {
            font-size: 16px;
            font-weight: 700;
            color: var(--primary);
        }

        /* --- Wallet Specific Styles (NEW) --- */
        .wallet-card {
            background: linear-gradient(135deg, #fffbe6 0%, #fff 100%);
            border: 1px solid #ffe58f;
            grid-column: span 1; /* Fits naturally in grid */
        }
        @media (min-width: 600px) {
            .wallet-card { grid-column: span 2; } /* Make it wider on larger screens if desired */
        }
        .wallet-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .wallet-amount {
            font-size: 24px;
            color: #d48806;
            font-weight: 800;
        }
        .btn-add-funds {
            background-color: #d48806;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-add-funds:hover { background-color: #ad6800; }

        /* --- ID Document Section --- */
        .id-section {
            margin-top: 40px;
        }
        .section-title {
            font-size: 18px;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .section-title::before {
            content: '';
            width: 4px;
            height: 20px;
            background: var(--gold);
            border-radius: 2px;
        }
        .id-image-wrapper {
            background: #fdfdfd;
            border: 2px dashed #e0e0e0;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
        }
        .id-image {
            max-width: 100%;
            max-height: 400px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .no-id-placeholder {
            color: #ccc;
            font-style: italic;
            padding: 40px;
        }
        /* --- Action Bar (Footer) --- */
        .verification-actions {
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid #f0f0f0;
            display: flex;
            justify-content: flex-end;
            gap: 15px;
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

        .modal {
            display: none; 
            position: fixed; 
            z-index: 1000; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgba(0,0,0,0.4); 
            backdrop-filter: blur(4px);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; 
            padding: 30px;
            border: 1px solid #888;
            width: 90%;
            max-width: 400px;
            border-radius: var(--radius-xl);
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
            position: relative;
        }
        .close-modal {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            line-height: 1;
        }
        .close-modal:hover { color: #000; }
        .modal-form-group { margin-bottom: 20px; }
        .modal-form-group label { display: block; font-size: 12px; font-weight: 700; color: #555; margin-bottom: 8px; }
        .modal-input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; font-size: 16px; }
    </style>

    <div class="user-detail-container">
        
        <a href="{{ route('users.index') }}" class="btn-back">
            ← Back to Users
        </a>

        <div class="user-detail-card">
            
            <div class="user-header">
                <div class="user-image-wrapper">
                    @if($user->profile_image)
                        <img src="{{$user->profile_image}}" 
                             alt="{{ $user->first_name }}" 
                             class="user-detail-image">
                    @else
                        <div class="user-detail-initials">
                            {{ substr($user->first_name, 0, 1) }}
                        </div>
                    @endif
                </div>
                
                <div class="user-info">
                    <h1 class="user-name-large">{{ $user->first_name }} {{ $user->last_name }}</h1>
                    
                    <span class="status-badge-large 
                        @if($user->verification_state === 'verified') bg-verified
                        @elseif($user->verification_state === 'rejected') bg-rejected
                        @else bg-pending @endif">
                        
                        @if($user->verification_state === 'verified')
                            ✓ Verified User
                        @elseif($user->verification_state === 'rejected')
                            ✗ Verification Rejected
                        @else
                            ⏳ Pending Verification
                        @endif
                    </span>
                </div>
            </div>

            <div class="user-details-grid">
                <div class="detail-item">
                    <div class="detail-label">Full Name</div>
                    <div class="detail-value">{{ $user->first_name }} {{ $user->last_name }}</div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">Contact Number</div>
                    <div class="detail-value">{{ $user->phone ?? 'Not Provided' }}</div>
                </div>

                
                <div class="detail-item">
                    <div class="detail-label">Joined On</div>
                    <div class="detail-value">{{ $user->created_at->format('M d, Y') }}</div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">Last Active</div>
                    <div class="detail-value">{{ $user->updated_at->diffForHumans() }}</div>
                </div>
                <div class="detail-item wallet-card">
                    <div class="wallet-header">
                        <div>
                            <div class="detail-label" style="color: #d48806;">Wallet Balance</div>
                            <div class="detail-value wallet-amount">
                                ${{ number_format($user->wallet_balance ?? 0, 2) }}
                            </div>
                        </div>
                        <button type="button" class="btn-add-funds" onclick="openWalletModal()">
                            + Add Money
                        </button>
                    </div>
                </div>
            </div>

            <div class="id-section">
                <h3 class="section-title">Identity Document</h3>
                
                <div class="id-image-wrapper">
                    @if($user->person_id_image)
                        <img src="{{$user->person_id_image}}" 
                             alt="ID Document" 
                             class="id-image"
                             onclick="window.open(this.src, '_blank')">
                        <div style="font-size:12px; color:#aaa; margin-top:10px;">(Click to view full size)</div>
                    @else
                        <div class="no-id-placeholder">
                            🚫 No identity document uploaded yet.
                        </div>
                    @endif
                </div>
            </div>

            <div class="verification-actions">
                @if($user->verification_state === 'pending')
                    <form action="{{ route('users.reject', $user) }}" method="POST">
                        @csrf @method('POST')
                        <button type="submit" class="action-btn btn-reject">✗ Reject</button>
                    </form>
                    
                    <form action="{{ route('users.verify', $user) }}" method="POST">
                        @csrf @method('PUT')
                        <button type="submit" class="action-btn btn-verify">✓ Verify User</button>
                    </form>
                @elseif($user->verification_state === 'rejected')
                    <form action="{{ route('users.verify', $user) }}" method="POST">
                        @csrf @method('PUT')
                        <button type="submit" class="action-btn btn-verify">✓ Re-Verify User</button>
                    </form>
                @else
                    <form action="{{ route('users.reject', $user) }}" method="POST">
                        @csrf @method('PUT')
                        <button type="submit" class="action-btn btn-reject">✗ Revoke Verification</button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <div id="addFundsModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeWalletModal()">&times;</span>
            <h3 style="margin-top:0; color: var(--primary);">Add Funds</h3>
            <p style="font-size:14px; color:#666; margin-bottom:20px;">Add balance to {{ $user->first_name }}'s wallet.</p>
            
            <form action="{{ route('users.update_balance', $user->id) }}" method="POST">
                @csrf
                @method('POST')
                
                <div class="modal-form-group">
                    <label>Amount ($)</label>
                    <input type="number" name="amount" step="0.01" min="1" class="modal-input" placeholder="0.00" required>
                </div>
                
                <div style="text-align: right;">
                    <button type="button" onclick="closeWalletModal()" style="padding: 10px 20px; background: #eee; border:none; border-radius: 50px; cursor:pointer; margin-right: 10px; font-weight:700;">Cancel</button>
                    <button type="submit" style="padding: 10px 20px; background: #d48806; color:white; border:none; border-radius: 50px; cursor:pointer; font-weight:700;">Confirm Add</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openWalletModal() {
            document.getElementById('addFundsModal').style.display = 'block';
        }
        function closeWalletModal() {
            document.getElementById('addFundsModal').style.display = 'none';
        }
        window.onclick = function(event) {
            var modal = document.getElementById('addFundsModal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</x-layout>
