@foreach ($list as $row)
    <div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-6 px-3 pb-3">
        <div class="card px-3 py-4 cards cursor {{ $row->license_id == 2 ? 'premium-card' : '' }}" data-id="{{ $row->id }}" data-icon-url="{{ $row->icon_url }}" data-icon-name="{{ $row->icon_name }}" >
            {{-- @if($row->license_id == 2)
                <div class="text-end pt-0"><img src="{{asset('asset/image/premium.png')}}" alt="premium" class="premium"></div>
            @endif --}}
            <div class="text-center"><img src="{{ $row->icon_url }}" alt="" class=""></div>
            <h6 class="pt-4 text-center">{{ $row->icon_name }}</h6>
        </div>
    </div>
@endforeach
