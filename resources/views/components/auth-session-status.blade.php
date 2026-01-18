@props(['status'])

@if ($status)
    <div class="alert alert-success" style="margin-bottom: var(--spacing-md);">
        <i class="fas fa-check-circle"></i>
        <div style="flex: 1;">
            <p style="margin: 0; font-weight: 500;">{{ $status }}</p>
        </div>
    </div>
@endif
