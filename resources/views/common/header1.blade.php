<div class="header">
    <div class="container">
        <div class="row justify-content-center align-self-center py-5">
            <div class="col-xl-8 col-lg-8 col-md-10 col-sm-10 col-11 align-slef-center text-center pt-5">
                <h1 class="text-white fw-bold">
                    Access <span id="icon-count">3,960,500</span> vector icons
                  </h1>
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
                                        <h6 class="fw-bold pb-3">Category </h6>
                                            @foreach ($category as $show_cat)
                                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-6 pb-2">
                                                <ul class="list-unstyled">
                                                    <li><a class="dropdown-item" href="{{ url('icons/category-set/' . $show_cat->category_url_key) }}"><h6>{{ $show_cat->category_name }}</h6></a></li>
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
                    @if ($errors->any())
                        <div class="toast-container position-fixed top-0 end-0 p-3">
                            <div class="toast show align-items-center text-bg-danger fade border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
                                <div class="d-flex">
                                    <div class="toast-body">
                                        {{ $errors->first('search') }}
                                    </div>
                                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                            </div>
                        </div>
                    @endif
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

document.addEventListener("DOMContentLoaded", function() {
    const element = document.getElementById('icon-count');
    const targetNumber = 3960500;
    const duration = 1500; // duration of the animation in milliseconds
    const frameRate = 60; // frames per second
    const increment = targetNumber / (duration / (1000 / frameRate));

    let currentNumber = 0;

    const updateCount = () => {
      currentNumber += increment;
      if (currentNumber < targetNumber) {
        element.textContent = Math.floor(currentNumber).toLocaleString();
        requestAnimationFrame(updateCount);
      } else {
        element.textContent = targetNumber.toLocaleString();
      }
    };

    updateCount();
  });
</script>
