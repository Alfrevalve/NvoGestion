@if(isset($breadcrumbs) && $breadcrumbs instanceof \Illuminate\Support\Collection && $breadcrumbs->count() > 0)
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            @foreach($breadcrumbs as $breadcrumb)
                @if ($breadcrumb instanceof \stdClass && isset($breadcrumb->title))
                    @if (isset($breadcrumb->url) && !$loop->last)
                        <li class="breadcrumb-item">
                            <a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a>
                        </li>
                    @else
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ $breadcrumb->title }}
                        </li>
                    @endif
                @endif
            @endforeach
        </ol>
    </nav>
@endif
