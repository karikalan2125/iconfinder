<section class="filter">
    <h4 class="fw-bold ps-4 py-3">Filter</h4>
    <div>
        <h5 class="font-blue fw-bold text-center py-4">License</h5>
        <div class="ps-4">
            @if(isset($license) && !empty($license))
                <div class="form-check pb-3 ">
                    <input class="form-check-input cursor" value="all" type="radio"  data-slug="all" name="flexRadioDefault" id="license" checked>
                    <label class="form-check-label cursor" for="license" >
                        All
                    </label>
                </div>
                @foreach ($license as $index => $row)
                <div class="form-check pb-3" style="{{$row->license_name == "free" ? 'display:block;' : 'display:none'}}">
                    <input class="form-check-input cursor" value="{{$row->license_id}}" data-slug="{{$row->license_name}}" type="radio" name="flexRadioDefault" id="{{$row->license_name}}">
                    <label class="form-check-label cursor" for="{{$row->license_name}}">
                        {{ $row->license_name }}
                    </label>
                </div>
                @endforeach
            @else
                <li><a class="dropdown-item" href="">No Categories</a></li>
            @endif
        </div>
    </div>
    <div>
        <h5 class="font-blue fw-bold text-center py-4">Style</h5>
        <div class="ps-4">
            @if(isset($style) && !empty($style))
                <div class="form-check pb-3">
                    <input class="form-check-input cursor" value="all"  type="radio" data-slug="all" name="flexRadioDefault1" id="Style" checked>
                    <label class="form-check-label cursor" for="Style">
                        All
                    </label>
                </div>
                @foreach ($style as $index => $row)
                <div class="form-check pb-3">
                    <input class="form-check-input cursor" value="{{$row->style_id}}"  type="radio" data-slug="{{$row->style_name}}" name="flexRadioDefault1" id="{{$row->style_name}}">
                    <label class="form-check-label cursor" for="{{$row->style_name}}">
                        {{ $row->style_name }}
                    </label>
                </div>
                @endforeach
            @else
                <li><a class="dropdown-item" href="">No Categories</a></li>
            @endif
        </div>
    </div>
    <div>
        <h5 class="font-blue fw-bold text-center pb-4">Icon Type</h5>
        <div class="ps-4">
            @if(isset($icon_type) && !empty($icon_type))
                <div class="form-check pb-3">
                    <input class="form-check-input cursor" type="radio" value="all" data-slug="all" name="flexRadioDefault2" id="icon" checked>
                    <label class="form-check-label cursor" for="icon">
                        All
                    </label>
                </div>
                @foreach ($icon_type as $index => $row1)
                <div class="form-check pb-3">
                    <input class="form-check-input cursor" type="radio" value="{{$row1->icon_type_id}}" data-slug="{{$row1->icon_type_name}}"  name="flexRadioDefault2" id="{{$row1->icon_type_name}}">
                    <label class="form-check-label cursor" for="{{$row1->icon_type_name}}">
                        {{ $row1->icon_type_name }}
                    </label>
                </div>
                @endforeach
            @else
                <li><a class="dropdown-item" href="">No Categories</a></li>
            @endif
        </div>
    </div>
    <div>
        <h5 class="font-blue fw-bold text-center py-4">Sort By</h5>
        <div class="ps-4">
            @if(isset($sort_type) && !empty($sort_type))
                <div class="form-check pb-3">
                    <input class="form-check-input cursor" type="radio" data-slug="all" value="all" name="flexRadioDefault3" id="sortby" checked>
                    <label class="form-check-label cursor" for="Style">
                        All
                    </label>
                </div>
                @foreach ($sort_type as $index => $row2)
                <div class="form-check pb-3">
                    <input class="form-check-input cursor" type="radio" value="{{$row2->sort_by_id}}"  data-slug="{{$row2->sort_by_name}}" name="flexRadioDefault3" id="{{$row2->sort_by_name}}">
                    <label class="form-check-label cursor" for="{{$row2->sort_by_name}}">
                        {{ $row2->sort_by_name }}
                    </label>
                </div>
                @endforeach
            @else
                <li><a class="dropdown-item" href="">No Categories</a></li>
            @endif
        </div>
    </div>
</section>

<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
  <div class="offcanvas-header">
    <h2 class="offcanvas-title fw-bold" id="offcanvasExampleLabel">Filter</h2>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
  <div>
        <h5 class="font-blue fw-bold text-center pb-4">License</h5>
        <div  class="ps-4">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="License" id="License1" checked>
                <label class="form-check-label" for="License1" >
                    All
                </label>
            </div>
            <div class="form-check py-3">
                <input class="form-check-input" type="radio" name="License" id="License2" >
                <label class="form-check-label" for="License2">
                    Free
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="License" id="License3" >
                <label class="form-check-label" for="License3">
                    Premium
                </label>
            </div>
        </div>
    </div>
    <div>
        <h5 class="font-blue fw-bold text-center py-4">Style</h5>
        <div class="ps-4">
            @if(isset($style) && !empty($style))
                @foreach ($style as $index => $row)
                <div class="form-check pb-3">
                    <input class="form-check-input" type="radio" name="Style" id="Style{{ $index }}"
                        @if ($index == 0) checked @endif>
                    <label class="form-check-label" for="Style{{ $index }}">
                        {{ $row->style_name }}
                    </label>
                </div>
                @endforeach
            @else
                <li><a class="dropdown-item" href="">No Categories</a></li>
            @endif
        </div>
    </div>
    <div>
        <h5 class="font-blue fw-bold text-center pb-4">Icon Type</h5>
        <div  class="ps-4">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="Icon_Type" id="Icon_Type1" checked>
                <label class="form-check-label" for="Icon_Type1">
                    All
                </label>
            </div>
            <div class="form-check py-3">
                <input class="form-check-input" type="radio" name="Icon_Type" id="Icon_Type2" >
                <label class="form-check-label" for="Icon_Type2">
                    Animation
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="Icon_Type" id="Icon_Type3" >
                <label class="form-check-label" for="Icon_Type3">
                    Static
                </label>
            </div>
        </div>
    </div>
    <div>
        <h5 class="font-blue fw-bold text-center py-4">Sort By</h5>
        <div  class="ps-4">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="Sort_By" id="Sort_By1" checked>
                <label class="form-check-label" for="Sort_By1">
                    All
                </label>
            </div>
            <div class="form-check py-3">
                <input class="form-check-input" type="radio" name="Sort_By" id="Sort_By2" >
                <label class="form-check-label" for="Sort_By2">
                    Popular
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="Sort_By" id="Sort_By3" >
                <label class="form-check-label" for="Sort_By3">
                    Recent
                </label>
            </div>
        </div>
    </div>
  </div>
</div>
