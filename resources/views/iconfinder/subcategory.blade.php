@extends('common.app')
@section('content')
@include('common/header2')
<section class="subcategory">
    <div class="container-fluid">
        <div class="row height_set" >
            <div class="col-xl-10 col-lg-10 col-sm-12 col-md-12 col-12">
                <h4 class="fw-bold ps-xl-4 ps-lg-4 ps-sm-3 ps-md-3 ps-0 py-3 opacity-75 text-sm-center text-md-center text-lg-start text-xl-start text-center">Icons</h4>
                @if (!empty($Icon) && count($Icon) )
                <div class="row px-xl-4 px-lg-3 px-md-3 px-sm-2 px-2 py-3">
                    <div class="col-lg-3 col-xl-3 col-md-4 col-sm-4 col-6 px-xl-4 px-lg-3 px-md-2 px-sm-2 px-1 ">
                        <a href="{{url('icons/category-set/'.$sub_category->category_url_key.'/'.$sub_category->category_url_key)}}">
                            <div class="card px-2 pt-4 pb-3 cards cursor ">
                                <div class="container-fluid">
                                    <div class="row">
                                        @foreach($Icon as $icons)
                                            <div class="col-4 text-center pb-4 px-0"><img src="{{$icons->icon_url}}" alt="icons" ></div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="d-flex align-items-center gap-2"><h6 class="py-2">{{$sub_category->category_name}}</h6><span class="text-secondary">({{$Icon_count}} icons)</span></div>
                    </div>
                </div>
                @else
                <div>
                    <h3 class="fw-bold opacity-75 pb-3">No icons found</h3>
                    <span class="text-secondary font-sz">Try checking your spelling or use more general term. Also, you can explain to us the icon you need, and we'll draw it for free in one of the existing Iconfinder styles or any other (but paid). The free images are pixel perfect to fit your design and available in both png and vector. Download icons in all formats or edit them for your designs.</span>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
<div id = "loading_indicator"> </div>
@endsection
