@extends('common.app')
@section('content')
@include('common/header1')
<section>
    <div>
        <img src="{{asset('asset/image/bg.png')}}" alt="" class="w-100">
    </div>
    <div class="text-center py-3">
        <h1 class=" fw-bold">Add magic to<span class="text-primary fw-bold">YOUR DESIGN</span><br>in 30 seconds</h1>
    </div>
</section>
<section class="static-contents">
    <div class="container">
        <div class="row pb-4">
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 text-center">
                <div data-aos="fade-right" data-aos-duration="1000">
                    <img src="{{asset('asset/image/home.gif')}}" alt="" class="w-75">
                    <h6 class="fw-bold py-3">The most relevant Assets</h6>
                    <span class="font-sz">Choose the most relevant assets from all the various styles available to compliment your design.</span>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 text-center">
                <div data-aos="zoom-in-up" data-aos-duration="1000">
                    <img src="{{asset('asset/image/color.gif')}}" alt="" class="w-75">
                    <h6 class="fw-bold  py-3">Select and Customize</h6>
                    <span class="font-sz">Use our SVG and Lottie Editors to quickly tweak colors, background, apply presets,and make quick edits on the go.</span>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 text-center">
                <div data-aos="fade-left" data-aos-duration="1000">
                    <img src="{{asset('asset/image/image_format.gif')}}" alt="" class="w-75">
                    <h6 class="fw-bold  py-3">Implement across Platforms</h6>
                    <span class="font-sz">Implement SVGs and Lottie animations in just a few clicks. They work like magic across Web, iOS, Android, TV, and WatchOS.</span>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="icons_hme py-4">
    <h2 class="fw-bold text-center">FREE ICON PACKS</h2>
    <div class="container" data-aos="zoom-in" data-aos-duration="1000">
        <div class="row py-3  px-xl-5 px-lg-5 px-md-3 px-sm-3 px-3 ">
            @forelse($hme_category as $row)
            <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4 col-6 px-xl-4 px-lg-4 px-md-3 px-sm-3 px-1 pb-2">
                <a href="{{ url('icons/style-set/' . $row->style_url_key) }}">
                    <div class="card p-4 pb-0 cards cursor">
                        <div class="container-fluid px-0">
                            <div class="row">
                            @foreach($row->icon as $rows)
                                <div class="col-6 text-center">
                                    <div class=" pb-5">
                                        <img src="{{$rows->icon_url}}" alt="icons" >
                                    </div>
                                </div>
                            @endforeach
                            </div>
                        </div>
                    </div>
                </a>
                <h6 class="py-2">{{$row->style_name}}</h6>
            </div>
            @empty
            <h2 class="text-center fw-bold">No Categories Available</h2>
            @endforelse
        </div>
    </div>
    <a href="{{url('/icons')}}"><h4 class="fw-bold text-primary text-center">See More<i class="fa fa-angle-right" aria-hidden="true"></i></h4></a>
</section>
<section class="clr-bg">
    <div class="container">
        <div class="row py-xl-5 py-lg-5 py-md-5 py-sm-4 py-3">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 order-xl-0 order-lg-0 order-md-0 order-sm-0 order-1 text-start py-5">
                <h1 class="fw-bold" data-aos="fade-right" data-aos-duration="1000">Extensive, made easy.</h1>
                <h4 class="pt-3 lh-base" data-aos="fade-down" data-aos-duration="1000">Filter through the world’s largest marketplace for icons with flexibility and ease. Made up by submissions from top designers around the world, and curated by our team.</h4>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 order-xl-0 order-lg-0 order-md-0 order-sm-0 order-0 text-center">
                <div>
                    <img src="{{asset('asset/image/image2.png')}}" alt="" class="w-50">
                </div>
            </div>
        </div>
    </div>
    <div id = "loading_indicator"> </div>
</section>
<section>
    <div class="container pt-5">
        <div class="text-center px-xl-5 px-lg-5 px-md-5 px-sm-4 px-2">
            <h2 class="fw-bold">UNLOCK THE WHOLE NEW WORLD OF CREATIVITY</h>
            <h6 class="py-3 lh-base">We are building the world's most powerful Design Ecosystem. Millions of assets, simple yet Powerful integrations, and the future of motion right at your fingertips.</h6>
        </div>
        <div class="px-xl-4 px-lg-4 px-md-4 px-sm-3 px-2">
            <div class="row justify-content-center pt-4" data-aos="zoom-in-up" data-aos-duration="1000">
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-6 text-center">
                    <img src="{{asset('asset/image/image3.png')}}" alt="" class="w-50">
                    <h6 class="fw-bold pt-3">3.2 Million+ Assets</h6>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-6 text-center" data-aos="zoom-in-up"  data-aos-duration="1000">
                    <img src="{{asset('asset/image/image4.png')}}" alt="" class="w-50">
                    <h6 class="fw-bold pt-3">Powerful Integrations</h6>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-6 text-center" data-aos="zoom-in-up" data-aos-duration="1000">
                    <img src="{{asset('asset/image/image5.png')}}" alt="" class="w-50">
                    <h6 class="fw-bold pt-3">Worry free licenses</h6>
                </div>
            </div>
            <div class="row justify-content-center py-5" data-aos="zoom-in-down" data-aos-duration="1000">
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-6 text-center">
                    <img src="{{asset('asset/image/image6.png')}}" alt="" class="w-50">
                    <h6 class="fw-bold pt-3">Be with creative trends</h6>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-6 text-center" data-aos="zoom-in-down"  data-aos-duration="1000">
                    <img src="{{asset('asset/image/image7.png')}}" alt="" class="w-50">
                    <h6 class="fw-bold pt-3">Advance Color Editor</h6>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-6 text-center" data-aos="zoom-in-down" data-aos-duration="1000">
                    <img src="{{asset('asset/image/image8.png')}}" alt="" class="w-50">
                    <h6 class="fw-bold pt-3">Control your account</h6>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
