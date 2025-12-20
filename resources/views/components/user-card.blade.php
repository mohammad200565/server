@props(['user'])

<a href="{{ route('users.show', $user) }}" class="user-card-link">
    <div class="user-card">
        
        <div class="user-image-wrapper">
            @if($user->profile_image)
                <img src="{{ $user->profile_image }}" 
                     alt="{{ $user->first_name }}" 
                     class="user-image">
            @else
                <div class="user-initials">
                    {{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}
                </div>
            @endif
        </div>

        <div class="user-info">
            <h3 class="user-name">
                {{ $user->first_name }} {{ $user->last_name }}
            </h3>
            
            <div class="user-contact">
                {{ $user->phone ?? 'No phone number' }}
            </div>

            <div class="user-balance" style="color: #d48806; font-weight: 700; font-size: 13px; margin-top: 4px;">
                <span style="opacity: 0.7; font-weight: 500;">Bal:</span> 
                ${{ number_format($user->wallet_balance ?? 0, 2) }}
            </div>
        </div>

        <div class="status-pill st-{{ $user->verification_state }}">
            <span class="dot"></span>
            {{ ucfirst($user->verification_state) }}
        </div>

    </div>
</a>
