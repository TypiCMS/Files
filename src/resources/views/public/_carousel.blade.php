@if ($images->count() > 0)
<div class="carousel-container">
    <div class="carousel @if($images->count() > 1)carousel-swiper @endif swiper-container">
        <div class="swiper-wrapper">
            @foreach ($images as $image)
            <img class="carousel-image swiper-slide" src="{!! $image->present()->thumbSrc(2880, 1920, [], 'name') !!}" alt="">
            @endforeach
        </div>
    </div>
    @if($images->count() > 1)
    <div class="swiper-pagination"></div>
    @endif
</div>
@endif
