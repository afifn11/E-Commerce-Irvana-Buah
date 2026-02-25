@props(['status'])
@if ($status)
    <div {{ $attributes->merge(['class' => 'alert alert-success']) }}>
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:16px;height:16px;flex-shrink:0;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        {{ $status }}
    </div>
@endif
