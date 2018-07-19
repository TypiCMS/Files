@if ($images->count() > 0)
<div class="news-images-container">
    <div class="news-images @if($images->count() > 1)news-images-swiper @endif container-slides swiper-container">
        <div class="slides-list swiper-wrapper">
            @foreach ($images as $image)
            <img class="news-image swiper-slide" src="{!! $image->present()->thumbSrc(2880, 1920, [], 'name') !!}" alt="" width="1440" height="960">
            @endforeach
        </div>
    </div>
    @if($images->count() > 1)
    <div class="swiper-pagination limited-width"></div>
    @endif
</div>
@endif
