@props(['user'])

<!-- We wrap the card in an anchor tag to make the whole card clickable -->
<a href="{{ route('users.show', $user) }}" class="user-card-link">
    <div class="user-card">
        
        <!-- Image / Initials Section -->
        <div class="user-image-wrapper">
            @if($user->profile_image)
                <img src="{{ $user->profile_image }}" 
                     alt="{{ $user->first_name }}" 
                     class="user-image">
            @else
                <!-- Fallback to Initials if no image -->
                <div class="user-initials">
                    {{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}
                </div>
            @endif
        </div>

        <!-- Info Section -->
        <div class="user-info">
            <h3 class="user-name">
                {{ $user->first_name }} {{ $user->last_name }}
            </h3>
            <div class="user-contact">
                {{ $user->phone ?? 'No phone number' }}
            </div>
        </div>

        <!-- Status Section (Using your dynamic CSS classes) -->
        <div class="status-pill st-{{ $user->verification_state }}">
            <span class="dot"></span>
            {{ ucfirst($user->verification_state) }}
        </div>
    </div>
</a>
