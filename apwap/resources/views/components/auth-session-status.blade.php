@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-[#305F72] bg-[#E7DCCB]/20 border border-[#D1A38E]/30 rounded-lg p-3']) }}>
        {{ $status }}
    </div>
@endif
