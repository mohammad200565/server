@props(['department'])

<a href="/departments/{{$department->id}}" class="department-card-link">
    <div class="department-card">
        <!-- Department Image Placeholder -->
        <div class="department-image-placeholder">
            🏠
        </div>
        
        <div class="department-location">
            {{ $department->location['city'] ?? 'N/A' }}, {{ $department->location['district'] ?? 'N/A' }}
        </div>
        
        <div class="department-specs">
            <span class="spec-item">{{ $department->area }}m²</span>
            <span class="spec-item">{{ $department->bedrooms }} BD</span>
            <span class="spec-item">{{ $department->bathrooms }} BA</span>
            <span class="spec-item">Floor {{ $department->floor }}</span>
        </div>
        
        <div class="department-rent">
            ${{ number_format($department->rentFee) }}/month
        </div>
        
        <div class="department-status {{ $department->status }}">
            {{ ucfirst($department->status) }}
        </div>
    </div>
</a>