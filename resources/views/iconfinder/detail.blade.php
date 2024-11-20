@extends('common.app')
@section('content')
@include('common/header2')
<section class="detail">
    <div class="container-fluid">
        <div class="row">
            <div class="col-2">
            @include('common/sidebar')
            </div>
            <div class="col-xl-10 col-lg-10 col-sm-12 col-md-12 col-12 scroll-bdy">
                <div class="filter-txt" >
                    <div class="d-flex align-tems-center gap-2 pt-3" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample">
                        <i class="fa fa-filter" aria-hidden="true"></i>
                        <h6>Filter</h6>
                    </div>
                </div>
                <h4 class="fw-bold ps-xl-4 ps-lg-4 ps-sm-3 ps-md-3 ps-0 py-3 opacity-75 text-sm-center text-md-center text-lg-start text-xl-start text-center">{{$cat_id->category_name}}</h4>
                <div class="row px-xl-4 px-lg-3 px-md-3 px-sm-2 px-2 py-3" id="filter_res">
                    <div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-6 px-3 pb-3">
                        <div class="card px-3 py-4 cards cursor {{ $Icon_dtl->license_id == 2 ? 'premium-card' : '' }}" data-id="{{ $Icon_dtl->id }}" data-icon-url="{{ $Icon_dtl->icon_url }}" data-icon-name="{{ $Icon_dtl->icon_name }}" >
                            {{-- @if($Icon_dtl->license_id == 2)
                                <div class="text-end pt-0"><img src="{{asset('asset/image/premium.png')}}" alt="premium" class="premium"></div>
                            @endif --}}
                            <div class="text-center"><img src="{{ $Icon_dtl->icon_url }}" alt="" class=""></div>
                            <h6 class="pt-4 text-center">{{ $Icon_dtl->icon_name }}</h6>
                        </div>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="text-end pt-2 pe-2">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-xl-5 col-lg-5 col-md-4 col-sm-4 col-12 text-center pb-3" id="size">
                                        <div class="modal-image-container">
                                            <div class="skeleton-loader" id="skeletonLoader">
                                                <div class="skeleton-item"></div>
                                            </div>
                                            <div id="modal-icon-img" class="detail-img"></div>
                                        </div>
                                    </div>
                                    <div class="col-xl-7 col-lg-7 col-md-8 col-sm-8 col-12 align-self-center">
                                        <h5 id="modal-icon-name" class="text-secondary fw-bold pb-4"></h5>
                                        <div class="row">
                                            <div class="d-flex justify-content-between align-items-center py-3 w-100">
                                                <!-- Size Control -->
                                                <div class="size-control d-flex justify-content-center align-items-center gap-3">
                                                    <button class="btn btn-outline-secondary" id="decrease" onclick="changeSize(-16)">-</button>
                                                    <span id="size-display" class="fw-bold">256px</span>
                                                    <button class="btn btn-outline-secondary" id="increase" onclick="changeSize(16)">+</button>
                                                </div>

                                                <!-- Color Picker -->
                                                <div class="color-picker d-flex align-items-center gap-2">
                                                    <label class="fw-bold">Customize</label>
                                                    <div class="custom-color">
                                                        <input type="color" id="customColorPicker" value="#000000">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex gap-3 pt-3" id="downloadicons">
                                            <div class="card cardd border-0 py-2 rounded-0 cursor" id="downloadpng">
                                                <div class="d-flex text-white justify-content-center">
                                                    <i class="fa-solid fa-file-image"></i>
                                                    <span class="ps-2 font-sz">DOWNLOAD AS PNG</span>
                                                </div>
                                            </div>
                                            <div class="card cardd border-0 py-2 rounded-0 cursor" id="downloadjpeg" data-icon-name="{{ $Icon_dtl->icon_name }}" data-img="{{ $Icon_dtl->icon_url }}">
                                                <div class="d-flex text-white justify-content-center">
                                                    <i class="fa-solid fa-file-image"></i>
                                                    <span class="ps-2 font-sz">DOWNLOAD AS JPEG</span>
                                                </div>
                                            </div>
                                            <div class="card cardd border-0 py-2 rounded-0 cursor" id="downloadsvg" data-icon-name="{{ $Icon_dtl->icon_name }}" data-img="{{ $Icon_dtl->icon_url }}">
                                                <div class="d-flex text-white justify-content-center">
                                                    <i class="fas fa-download"></i>
                                                    <span class="ps-2 font-sz">DOWNLOAD AS SVG</span>
                                                </div>
                                            </div>
                                            <div class="card  cardd border-0 py-2 rounded-0 cursor" onclick="copyImageURL('{{ $Icon_dtl->icon_url }}')">
                                                <div class="d-flex text-white justify-content-center">
                                                    <i class="fa-regular fa-copy"></i>
                                                    <span class="ps-2 font-sz">COPY LINK</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="mx-5">
                            <div class="related-icons">
                                <h5 class="text-opacity-75 text-center fw-bold pb-3">You may also like</h5>
                                <div class="owl-carousel owl-theme px-5 pb-3">
                                    @foreach ($relatedIcons as $relatedIcon)
                                    <div class="item pe-2">
                                        <div class="card px-xl-3 px-lg-3 px-md-2 px-sm-2 px-1 py-xl-4 py-lg-4 py-md-4 py-sm-3 py-2 owl-card cursor" data-id="{{ $relatedIcon->id }}" data-icon-url="{{ $relatedIcon->icon_url }}" data-icon-name="{{ $relatedIcon->icon_name }}">
                                            <div class="align-self-center">
                                                <img src="{{ $relatedIcon->icon_url }}" alt="" class="">
                                            </div>
                                            <h6 class="pt-4 text-center">{{ $relatedIcon->icon_name }}</h6>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div id="loadingSpinner" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0 bg-transparent">
        <div class="d-flex justify-content-center p-5">
          <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id = "loading_indicator"> </div>
@endsection
@section('customscript')
<script>
    var base_url = '{{ url("/") }}/';
    var cat_slug ='{{$cat_slug}}';
</script>
<script src="{{asset('asset/js/detail.js')}}"></script>
@endsection

