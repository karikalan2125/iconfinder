<section class="top-nav py-2">
    <div class="container-fluid">
        <div class="row align-self-center">
            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-4 text-center align-self-center">
                <a href="{{url('/')}}"><h4 class="text-primary fw-bold text-start ">Icons.Com</h4></a>
            </div>
            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-8" id="search-form">
                <form autocomplete="off" method="get" action="{{ route('icons.search') }}">
                    <div class="input-group">
                        <input class="form-control border-end-0 rounded-end-0" name="search" id="query" type="search" placeholder="Search" aria-label="Search" autocomplete="off" required value="{{ request()->input('search') }}">
                        <button class="search-btn btn p-0 border-start-0 rounded-end-2 srch_icon px-2 bg-white cursor"><i class="bi bi-search"></i></button>
                    </div>
                </form>
            </div>
            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-8 align-self-center">
                <div class="d-flex gap-xl-4 gap-lg-4 gap-md-3 gap-sm-1 gap-2 justify-content-start align-items-center jkfrjh">
                    <a href="{{url('icons')}}"><h6>Icon</h6></a>
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            Categories
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        @if(isset($category) && !empty($category))
                            @foreach ($category as $show_cat)
                            <li><a class="dropdown-item" href="{{ url('icons/category-set/' . $show_cat->category_url_key) }}">{{ $show_cat->category_name }}</a></li>
                            @endforeach
                            @else
                                <li><a class="dropdown-item" href="">No Categories</a></li>
                        @endif
                        </ul>
                    </div>
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            Styles
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        @if(isset($style) && !empty($style))
                            @foreach ($style as $row)
                            <li><a class="dropdown-item" href="{{ url('icons/style-set/' . $row->style_url_key) }}">{{ $row->style_name }}</a></li>
                            @endforeach
                            @else
                                <li><a class="dropdown-item" href="">No Categories</a></li>
                        @endif
                        </ul>
                    </div>
                </div>
                <div class="jkfrjhqwd text-end" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                </div>
            </div>
        </div>
    </div>
</section>


<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h2 id="offcanvasRightLabel" class="text-primary fw-bold">Icons.Com</h2>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <a href="{{url('icons')}}"><h4 class="py-2 ps-3">Icon</h4></a>
        <div class="dropdown">
            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                Categories
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            @if(isset($category) && !empty($category))
                @foreach ($category as $show_cat)
                <li><a class="dropdown-item" href="{{ url('icons/category-set/' . $show_cat->category_url_key) }}">{{ $show_cat->category_name }}</a></li>
                @endforeach
                @else
                    <li><a class="dropdown-item" href="">No Categories</a></li>
            @endif
            </ul>
        </div>
        <div class="dropdown">
            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                Styles
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            @if(isset($style) && !empty($style))
                @foreach ($style as $row)
                <li><a class="dropdown-item" href="{{ url('icons/style-set/' . $row->style_url_key) }}">{{ $row->style_name }}</a></li>
                @endforeach
                @else
                    <li><a class="dropdown-item" href="">No Categories</a></li>
            @endif
            </ul>
        </div>
  </div>
</div>
