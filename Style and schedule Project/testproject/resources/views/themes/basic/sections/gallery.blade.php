@gallery
<section class="gallery_area">
    <div class="container" data-aos="zoom-in-up">
        @if(isset($templates['gallery'][0]) && $gallery = $templates['gallery'][0])
            <div class="row">
                <div class="section_header text-center">
                    <h2>@lang(optional($gallery->description)->title)</h2>
                   
                </div>
            </div>
        @endif
        <div class="section_btn_area">
            <div class="row g-4 justify-content-center mt-30 mb-30 mx-auto">
                <div class="col-lg-2 col-sm-4 col-6 d-flex justify-content-center">
                    <button type="button" data-filter="all">@lang('All')</button>
                </div>
                @foreach($galleryTag as $key => $item)
                    <div class="col-lg-2 col-sm-4 col-6 d-flex justify-content-center">
                        <button type="button"
                                data-filter=".{{ removeSpaceTagName($item->name) }}">@lang($item->name)</button>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="row justify-content-center">
            <div id="masonryContainer" class="cols mx-auto text-center gallery_magnific_popup">
                @foreach($manageGallery->take(8) as $key => $item)
                    <div class="img-box mix {{ removeSpaceTagName(optional($item->tag)->name) }}">
                        <a href="{{ getFile(config('location.gallery.path').$item->image)}}" target="_blank"><img
                                src="{{ getFile(config('location.gallery.path').$item->image)}}" alt=""
                                class="img-fluid"/></a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endgallery
