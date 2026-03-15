@props(['content' => ''])

@php
    $clean = \App\Domain\Shared\Helpers\QuillSanitizer::clean($content ?? '');
@endphp

@if($clean)
    <div {{ $attributes->merge(['class' => 'prose dark:prose-invert']) }}>
        {!! $clean !!}
    </div>
@endif
