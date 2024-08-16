<div class="header">
    <div class="container">
        <div class="row justify-content-center align-self-center py-5">
            <div class="col-xl-8 col-lg-8 col-md-10 col-sm-10 col-11 align-slef-center text-center pt-5">
                <h1 class="text-white fw-bold">Access 3,960,500 vector icons</h1>
                <h5 class="text-white py-xl-4 py-lg-4 py-md-4 py-sm-3  py-3">The largest database of free icons available in PNG, SVG, EPS, PSD</h5>
                <div class="w-100 position-relative" role="search" id="search">
                <form autocomplete="off" method="get" action="{{ route('icons.search') }}">
                    <div class="input-group">
                        <div class="dropdown w-100" style="display:contents!important;">
                            <div>
                                <button class="btn bg-white dropdown-toggle rounded-end-0 all-type fw-bold text-primary w-100" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    All
                                </button>
                                <ul class="dropdown-menu mega-menu p-xl-4 p-lg-4 p-sm-4 p-md-4 p-2 w-100" aria-labelledby="dropdownMenuButton1">
                                    <div class="row">
                                        @if(isset($category) && !empty($category))
                                        <h6 class="fw-bold pb-2">Category </h6>
                                            @foreach ($category as $show_cat)
                                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-6">
                                                <ul class="list-unstyled">
                                                    <li><a class="dropdown-item" href="{{ url('icons/category-set/' . $show_cat->category_url_key) }}"><h6>{{ $show_cat->category_name }}</h6></a></li>
                                                </ul>
                                            </div>
                                            @endforeach
                                        @else
                                            <li><a class="dropdown-item" href="">No Categories</a></li>
                                        @endif
                                    </div>
                                    <div class="row pt-2">
                                        @if(isset($style) && !empty($style))
                                        <h6 class="fw-bold pb-2">Style</h6>
                                            @foreach ($style as $row)
                                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-6">
                                                <ul class="list-unstyled">
                                                    <li><a class="dropdown-item" href="{{ url('icons/style-set/' . $row->style_url_key) }}"><h6>{{ $row->style_name }}</h6></a></li>
                                                </ul>
                                            </div>
                                            @endforeach
                                        @else
                                            <li><a class="dropdown-item" href="">No Categories</a></li>
                                        @endif
                                    </div>
                                </ul>
                            </div>
                        </div>
                        <input class="form-control border-end-0 rounded-end-0" name="search" id="query" type="search" placeholder="Search for icons.." aria-label="Search" autocomplete="off" required value="{{ request()->input('search') }}">
                        <button class="search-btn btn border-start-0 rounded-end-2 srch_icon p-1 bg-white cursor">
                            <div class="card border-0"><i class="bi bi-search"></i></div>
                        </button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>