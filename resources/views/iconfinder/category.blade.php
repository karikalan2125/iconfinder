@extends('common.app')
@section('content')
@include('common/header2')
<section>
    <div class="container pt-4">
        <div class="text-center px-xl-5 px-lg-5 px-md-5 px-sm-4 px-2 ">
            <h2 class="fw-bold text-primary">FREE ICON PACKS</h2>
            <h4 class="py-3">We are building the world's most powerful Design Ecosystem. Millions of assets, simple yet Powerful integrations, and the future of motion right at your fingertips.</h4>
        </div>
        <div id="load-more" hidden>{{$totalRecords}}</div>
        <div class="load" hidden>false</div>
        <div class="row py-3" id="src">
            @forelse($all_icons as $row)
                <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4 col-6 px-xl-5 px-lg-4 px-md-3 px-sm-3 px-2 scroll_height pb-2">
                    <a href="{{ url('icons/style-set/' . $row->style->style_url_key) }}">
                        <div class="card p-4 cards cursor pb-0">
                            <div class="container-fluid px-0">
                                <div class="row">
                                @foreach($row->random_icons as $rows)
                                    <div class="col-6 text-center pb-5"><img src="{{ $rows->icon_url }}" alt="icons"></div>
                                @endforeach
                                </div>
                            </div>
                        </div>
                    </a>
                    <h6 class="py-2">{{ $row->style->style_name }}</h6>
                </div>
            @empty
                <h2 class="text-center fw-bold">No Categories Available</h2>
            @endforelse
        </div>
    </div>
</section>
@endsection
@section('customscript')
<script>
    var baseUrl = "{{ url('/') }}";
</script>

<script src="{{asset('asset/js/category.js')}}"></script>
@endsection
