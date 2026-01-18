@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'form-error']) }} style="list-style: none; padding: 0; margin: var(--spacing-xs) 0 0 0;">
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif
