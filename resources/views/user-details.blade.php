<x-layout title="{{ $user->first_name }} {{ $user->last_name }} - User Details">

    <style>
        /* 
           PAGE STYLES 
           Using global variables from x-layout for automatic Dark Mode support
        */

        .user-detail-container { 
            max-width: 900px; 
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

        .btn-back:hover { 
            color: var(--primary); 
        }

        .user-detail-card { 
            background-color: var(--bg-card); 
            border-radius: var(--radius-card); /* Using global radius */
            padding: 40px; 
            box-shadow: var(--shadow-card); 
            border: 1px solid var(--border-color); 
        }

        .user-header { 
            display: flex; 
            align-items: center; 
            gap: 30px; 
            margin-bottom: 40px; 
            padding-bottom: 30px; 
            border-bottom: 1px solid var(--border-color); 
        }

        .user-info { flex: 1; }

        .user-name-large { 
            font-size: 32px; 
            font-weight: 800; 
            color: var(--text-main); 
            margin: 0 0 10px 0; 
            letter-spacing: -1px; 
        }

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

        /* Status Colors - kept hardcoded for semantic meaning, but adaptable opacity */
        .bg-verified { background: rgba(46, 125, 50, 0.1); color: #2e7d32; }
        .bg-pending { background: rgba(245, 127, 23, 0.1); color: #f57f17; }
        .bg-rejected { background: rgba(198, 40, 40, 0.1); color: #c62828; }

        /* Dark Mode Text Adjustments for Badges */
        :root.dark .bg-verified { color: #81c784; }
        :root.dark .bg-pending { color: #ffb74d; }
        :root.dark .bg-rejected { color: #e57373; }

        .user-image-wrapper { position: relative; cursor: pointer; }

        .user-detail-image, .user-detail-initials { 
            width: 120px; 
            height: 120px; 
            border-radius: 50%; 
            border: 4px solid var(--bg-card); 
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
            cursor: default; 
        }

        .image-zoom-hover { 
            position: absolute; 
            top: 0; left: 0; 
            width: 100%; height: 100%; 
            border-radius: 50%; 
            background: rgba(0,0,0,0.3); 
            color: white; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-size: 24px; 
            opacity: 0; 
            transition: opacity 0.3s ease; 
        }

        .user-image-wrapper:hover .image-zoom-hover { opacity: 1; }
        .id-image-wrapper:hover .image-zoom-hover { opacity: 1; border-radius: 8px; }

        .user-details-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); 
            gap: 20px; 
            margin-bottom: 40px; 
        }

        .detail-item { 
            background: var(--bg-body); 
            padding: 20px; 
            border-radius: 12px; 
            border: 1px solid var(--border-color); 
        }

        .detail-label { 
            font-size: 11px; 
            text-transform: uppercase; 
            color: var(--text-sub); 
            font-weight: 700; 
            letter-spacing: 0.5px; 
            margin-bottom: 6px; 
        }

        .detail-value { 
            font-size: 16px; 
            font-weight: 700; 
            color: var(--text-main); 
        }

        /* Wallet Card - Adaptive Gradient */
        .wallet-card { 
            background: linear-gradient(135deg, var(--gold-light) 0%, var(--bg-card) 100%); 
            border: 1px solid var(--gold); 
            grid-column: span 1; 
        }

        @media (min-width: 600px) { .wallet-card { grid-column: span 2; } }

        /* Specific Dark Mode override for Wallet to ensure it's not too bright */
        :root.dark .wallet-card {
            background: linear-gradient(135deg, rgba(212, 180, 131, 0.15) 0%, var(--bg-card) 100%);
            border-color: rgba(212, 180, 131, 0.3);
        }

        .wallet-header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
        }

        .wallet-amount { 
            font-size: 24px; 
            color: var(--gold); 
            font-weight: 800; 
        }

        .btn-add-funds { 
            background-color: var(--gold); 
            color: var(--bg-card); /* Text contrast */
            border: none; 
            padding: 6px 12px; 
            border-radius: 8px; 
            font-size: 12px; 
            font-weight: 700; 
            cursor: pointer; 
            transition: background 0.2s; 
        }

        .btn-add-funds:hover { 
            background-color: var(--gold-hover); 
        }

        /* ID Section */
        .id-section { margin-top: 40px; }

        .section-title { 
            font-size: 18px; 
            font-weight: 800; 
            color: var(--text-main); 
            margin-bottom: 20px; 
            display: flex; 
            align-items: center; 
            gap: 10px; 
        }

        .section-title::before { 
            content: ''; 
            width: 4px; height: 20px; 
            background: var(--gold); 
            border-radius: 2px; 
        }

        .id-image-container { 
            position: relative; 
            background: var(--bg-body); 
            border: 1px solid var(--border-color); 
            border-radius: 12px; 
            padding: 10px; 
            text-align: center; 
        }

        .id-image { 
            max-width: 100%; 
            max-height: 400px; 
            border-radius: 8px; 
            box-shadow: var(--shadow-header); 
            cursor: pointer; 
        }

        .no-id-placeholder { 
            color: var(--text-sub); 
            font-style: italic; 
            padding: 60px 20px; 
            background: var(--bg-body); 
            border-radius: 12px; 
            text-align: center; 
        }

        .no-id-placeholder div:first-child { font-size: 40px; margin-bottom: 15px; }

        /* Actions */
        .verification-actions { 
            margin-top: 40px; 
            padding-top: 30px; 
            border-top: 1px solid var(--border-color); 
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
            background-color: var(--bg-card); 
            color: #c62828; 
            border: 1px solid #ef9a9a; 
        }

        .btn-reject:hover { 
            background-color: var(--bg-body); 
        }

        /* Modal */
        .modal { 
            display: none; 
            position: fixed; 
            z-index: 1000; 
            left: 0; top: 0; 
            width: 100%; height: 100%; 
            overflow: auto; 
            background-color: rgba(0,0,0,0.5); 
            backdrop-filter: blur(4px); 
        }

        .modal-content { 
            background-color: var(--bg-card); 
            margin: 15% auto; 
            padding: 30px; 
            border: 1px solid var(--border-color); 
            width: 90%; 
            max-width: 400px; 
            border-radius: 24px; 
            box-shadow: var(--shadow-card); 
            position: relative; 
        }

        .close-modal { 
            color: var(--text-sub); 
            float: right; 
            font-size: 28px; 
            font-weight: bold; 
            cursor: pointer; 
            line-height: 1; 
        }

        .close-modal:hover { color: var(--primary); }

        .modal-form-group { margin-bottom: 20px; }

        .modal-form-group label { 
            display: block; 
            font-size: 12px; 
            font-weight: 700; 
            color: var(--text-sub); 
            margin-bottom: 8px; 
        }

        .modal-input { 
            width: 100%; 
            padding: 12px; 
            border: 1px solid var(--border-color); 
            background-color: var(--bg-body);
            color: var(--text-main);
            border-radius: 8px; 
            box-sizing: border-box; 
            font-size: 16px; 
        }
        
        .modal-input:focus {
            outline: none;
            border-color: var(--gold);
        }

        /* Image Modal */
        .image-modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0; top: 0;
            width: 100%; height: 100%;
            background-color: rgba(10, 5, 2, 0.9);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            animation: fadeIn 0.3s ease;
        }

        .image-modal-content {
            display: block;
            margin: auto;
            max-width: 90vw;
            max-height: 90vh;
            animation: zoomIn 0.3s ease;
            box-shadow: 0 0 30px rgba(0,0,0,0.5);
        }

        .close-image-modal {
            position: absolute;
            top: 20px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
            cursor: pointer;
        }

        .close-image-modal:hover { color: var(--gold); }

        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes zoomIn { from { transform: scale(0.8); } to { transform: scale(1); } }
    </style>

    <div class="user-detail-container">

        <a href="{{ route('users.index') }}" class="btn-back">← Back to Users</a>

        <div class="user-detail-card">
            <div class="user-header">
                
                <div class="user-image-wrapper" @if($user->profileImage) onclick="openImageModal('{{ asset('storage/' . $user->profileImage) }}')" @endif>
                    @if($user->profileImage)
                        <img src="{{ asset('storage/' . $user->profileImage) }}" alt="{{ $user->first_name }}" class="user-detail-image">
                        <div class="image-zoom-hover">🔍</div>
                    @else
                        <div class="user-detail-initials">{{ substr($user->first_name, 0, 1) }}</div>
                    @endif
                </div>
                
                <div class="user-info">
                    <h1 class="user-name-large">{{ $user->first_name }} {{ $user->last_name }}</h1>
                    <span class="status-badge-large @if($user->verification_state === 'verified') bg-verified @elseif($user->verification_state === 'rejected') bg-rejected @else bg-pending @endif">
                        @if($user->verification_state === 'verified') ✓ Verified User
                        @elseif($user->verification_state === 'rejected') ✗ Verification Rejected
                        @else ⏳ Pending Verification
                        @endif
                    </span>
                </div>
            </div>

             <div class="user-details-grid">
                <div class="detail-item"><div class="detail-label">Full Name</div><div class="detail-value">{{ $user->first_name }} {{ $user->last_name }}</div></div>
                <div class="detail-item"><div class="detail-label">Contact Number</div><div class="detail-value">{{ $user->phone ?? 'Not Provided' }}</div></div>
                <div class="detail-item"><div class="detail-label">Joined On</div><div class="detail-value">{{ $user->created_at->format('M d, Y') }}</div></div>
                <div class="detail-item"><div class="detail-label">Last Active</div><div class="detail-value">{{ $user->updated_at->diffForHumans() }}</div></div>
                
                <div class="detail-item wallet-card">
                    <div class="wallet-header">
                        <div>
                            <div class="detail-label" style="color: var(--primary);">Wallet Balance</div>
                            <div class="detail-value wallet-amount">${{ number_format($user->wallet_balance ?? 0, 2) }}</div>
                        </div>
                        <button type="button" class="btn-add-funds" onclick="openWalletModal()">+ Add Money</button>
                    </div>
                </div>
            </div>

            <div class="id-section">
                <h3 class="section-title">Identity Document</h3>
                <div class="id-image-container">
                    @if($user->personIdImage)
                        <div class="id-image-wrapper" onclick="openImageModal('{{ asset('storage/' . $user->personIdImage) }}')">
                            <img src="{{ asset('storage/' . $user->personIdImage) }}" alt="ID Document" class="id-image">
                             <div class="image-zoom-hover">🔍</div>
                        </div>
                        <div style="font-size:12px; color: var(--text-sub); margin-top:10px;">(Click image to enlarge)</div>
                    @else
                        <div class="no-id-placeholder">
                            <div>🚫</div>
                            <div>No identity document uploaded yet.</div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="verification-actions">
                 @if($user->verification_state === 'pending')
                    <form action="{{ route('users.reject', $user) }}" method="POST"> @csrf @method('PUT') <button type="submit" class="action-btn btn-reject">✗ Reject</button> </form>
                    <form action="{{ route('users.verify', $user) }}" method="POST"> @csrf @method('PUT') <button type="submit" class="action-btn btn-verify">✓ Verify User</button> </form>
                @elseif($user->verification_state === 'rejected')
                     <form action="{{ route('users.verify', $user) }}" method="POST"> @csrf @method('PUT') <button type="submit" class="action-btn btn-verify">✓ Re-Verify User</button> </form>
                @else
                    <form action="{{ route('users.reject', $user) }}" method="POST"> @csrf @method('PUT') <button type="submit" class="action-btn btn-reject">✗ Revoke Verification</button> </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Wallet Modal -->
    <div id="addFundsModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeWalletModal()">&times;</span>
            <h3 style="margin-top:0; color: var(--primary);">Add Funds</h3>
            <p style="font-size:14px; color: var(--text-sub); margin-bottom:20px;">Add balance to {{ $user->first_name }}'s wallet.</p>
            
            <form action="{{ route('users.update_balance', $user->id) }}" method="POST">
                @csrf @method('POST')
                <div class="modal-form-group">
                    <label>Amount ($)</label>
                    <input type="number" name="amount" step="0.01" min="1" class="modal-input" placeholder="0.00" required>
                </div>
                <div style="text-align: right;">
                    <button type="button" onclick="closeWalletModal()" style="padding: 10px 20px; background: var(--bg-body); border:1px solid var(--border-color); color: var(--text-sub); border-radius: 50px; cursor:pointer; margin-right: 10px; font-weight:700;">Cancel</button>
                    <button type="submit" style="padding: 10px 20px; background: var(--gold); color: var(--bg-card); border:none; border-radius: 50px; cursor:pointer; font-weight:700;">Confirm Add</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Image Modal -->
    <div id="imageModal" class="image-modal" onclick="closeImageModal()">
        <span class="close-image-modal" onclick="closeImageModal()">&times;</span>
        <img class="image-modal-content" id="modalImage">
    </div>

    <script>
        function openWalletModal() { document.getElementById('addFundsModal').style.display = 'block'; }
        function closeWalletModal() { document.getElementById('addFundsModal').style.display = 'none'; }
        
        window.onclick = function(event) {
            var walletModal = document.getElementById('addFundsModal');
            if (event.target == walletModal) { walletModal.style.display = "none"; }
        }

        const imageModal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');

        function openImageModal(src) {
            modalImage.src = src;
            imageModal.style.display = 'flex';
        }

        function closeImageModal() {
            imageModal.style.display = 'none';
        }

        imageModal.addEventListener('click', function(event) {
            if (event.target === imageModal) {
                closeImageModal();
            }
        });
    </script>

</x-layout>
