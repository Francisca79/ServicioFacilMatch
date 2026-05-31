@php
    $logoPath = public_path('storage/fotos/logo.jpeg');
    $logoUrl = file_exists($logoPath) ? asset('storage/fotos/logo.jpeg') : null;
@endphp

@if ($logoUrl)
    <img src="{{ $logoUrl }}" alt="SFM" class="w-25 h-25 rounded-lg object-cover shrink-0">
@else
    <div class="bg-blue-600 text-white w-10 h-10 rounded-lg flex items-center justify-center font-bold text-xl shrink-0">S</div>
@endif
