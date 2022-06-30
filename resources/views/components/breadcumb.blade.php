@foreach ($breadcrumbs as $breadcrumb)
<li class="breadcrumb-item">
    <span class="bullet bg-primary w-5px h-2px"></span>
</li>
@if (isset($breadcrumb['url']))
<li class="breadcrumb-item text-primary">
    <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a>
</li>
@else
<li class="breadcrumb-item text-dark">{{ $breadcrumb['title'] }}</li>
@endif
@endforeach