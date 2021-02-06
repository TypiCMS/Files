@if ($images = $model->imagesFromCollection($collection ?? 'default') and $images->count() > 0)
<div class="carousel-container">
    <div class="carousel @if ($model->images->count() > 1)carousel-swiper @endif swiper-container">
        <div class="swiper-wrapper">
            @foreach ($images as $image)
            <img class="carousel-image swiper-slide" src="{!! $image->present()->image(2880, 1920) !!}" alt="">
            @endforeach
        </div>
    </div>
    @if ($images->count() > 1)
    <div class="swiper-pagination"></div>
    @endif
</div>
@endif
