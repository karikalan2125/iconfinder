@forelse ($list as $row)
    <div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-6 px-3 pb-3">
        <div class="card px-3 py-4 cards cursor h-100 {{ $row->license_id == 2 ? 'premium-card' : '' }}" data-id="{{ $row->id }}" data-icon-url="{{ $row->icon_url }}" data-icon-name="{{ $row->icon_name }}">
            @if($row->license_id == 2)
                <div class="text-end pt-0"><img src="{{ asset('asset/image/premium.png') }}" alt="premium" class="premium"></div>
            @endif
            <div class="text-center"><img src="{{ $row->icon_url }}" alt="" class=""></div>
            <h6 class="pt-4 text-center">{{ $row->icon_name }}</h6>
        </div>
    </div>
@empty
    <div>
        <h3 class="fw-bold opacity-75 pb-3">No icons found</h3>
        <span class="text-secondary font-sz">Try checking your spelling or use more general term. Also, you can explain to us the icon you need, and we'll draw it for free in one of the existing Iconfinder styles or any other (but paid). The free images are pixel perfect to fit your design and available in both png and vector. Download icons in all formats or edit them for your designs.</span>
    </div>
@endforelse
