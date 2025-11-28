@props(['user'])

<a href="/users/{{$user->id}}" class="user-card-link">
    <div class="user-card">
        @if($user->profile_image)
            <img src="{{ asset('storage/' . $user->profile_image) }}" 
                 alt="{{ $user->first_name }} {{ $user->last_name }}" 
                 class="user-image">
        @else
            <div class="user-initials">
                {{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}
            </div>
        @endif
        
        <div class="user-name">
            {{ $user->first_name }} {{ $user->last_name }}
        </div>
        
        <div class="verification-badge 
            {{ $user->verification_state == 'verified' ? 'verified' : ($user->verification_state == 'rejected' ? 'rejected' : 'pending') }}">
            {{ ucfirst($user->verification_state) }}
        </div>
    </div>
</a>
