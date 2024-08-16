@extends('common.app')
@section('content')
@include('common/header2')
<section class="subcategory">
    <div class="container-fluid">
        <div class="row height_set">
            <div class="col-12">
                <div class="filter-txt" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample">
                    <div class="d-flex align-tems-center gap-2 pt-3">
                        <i class="fa fa-filter" aria-hidden="true"></i>
                        <h6>Filter</h6>
                    </div>
                </div>
                <h4 class="fw-bold ps-xl-4 ps-lg-4 ps-sm-3 ps-md-3 ps-0 py-3 opacity-75 text-sm-center text-md-center text-lg-start text-xl-start text-center">Icons</h4>
                <div class="row px-xl-4 px-lg-3 px-md-3 px-sm-2 px-2 py-3">
                    @foreach ($iconsGroupedByCategory as $group)
                    <div class="col-lg-3 col-xl-3 col-md-4 col-sm-4 col-6 px-xl-4 px-lg-3 px-md-2 px-sm-2 px-1">
                    <a href="{{url('icons/style-set/'.$cat_slug .'/'.$group['category']->category_url_key)}}">
                            <div class="card px-2 pt-4 pb-3 cards cursor">
                                <div class="container-fluid">
                                    <div class="row">
                                        @foreach ($group['icons'] as $icon)
                                        <div class="col-4 text-center pb-4 px-0">
                                            <img src="{{ $icon->icon_url }}" alt="icons">
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="d-flex align-items-center gap-2">
                            <h6 class="py-2">{{ $group['category']->category_name }}</h6>
                            <span class="text-secondary">({{ $group['count'] }} icons)</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection 
