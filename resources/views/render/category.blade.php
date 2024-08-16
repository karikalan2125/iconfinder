@forelse($all_icons as $row)
    <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4 col-6 px-xl-5 px-lg-4 px-md-3 px-sm-3 px-2 scroll_height pb-2">
        <a href="{{ url('icons/style-set/' . $row->style->style_url_key) }}">
            <div class="card p-4 cards cursor pb-0">
                <div class="container-fluid px-0">
                    <div class="row ">
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