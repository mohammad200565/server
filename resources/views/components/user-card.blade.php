@props(['user'])

<a href="{{ route('users.show', $user) }}" class="user-card-link">
    <div class="user-card">
        @if($user->profile_image)
            <img src="{{ $user->profile_image }}" alt="{{ $user->first_name }} {{ $user->last_name }}" class="user-image">
        @else
            <div class="user-initials">
                {{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}
            </div>
        @endif
        
        <div class="user-name">
            {{ $user->first_name }} {{ $user->last_name }}
        </div>
        
        <div class="verification-badge 
            @if($user->verification_state === 'verified') verified
            @elseif($user->verification_state === 'rejected') rejected
            @else pending @endif">
            @if($user->verification_state === 'verified')
                Verified
            @elseif($user->verification_state === 'rejected')
                Rejected
            @else
                Pending
            @endif
        </div>
    </div>
</a>