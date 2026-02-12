@service
@if(isset($templates['services'][0]) && $services = $templates['services'][0])
    <section class="service_area"
             style="background: linear-gradient(rgb(53, 49, 47, .9), rgb(53, 49, 47, .9)), url({{ getFile(config('location.content.path').@$services->templateMedia()->background_image) }}); background-size: cover; background-repeat: no-repeat">
        <div class="container pb-5">
            <div class="row">
                <div class="section_header text-center">
                    <div class="header_text">
                        <h2>@lang(optional($services->description)->title)</h2>
                        <p class="title_details">At Style & Schedule, we specialize in precision haircuts, spa treatments, and expert hair coloring services, all designed to ensure you leave looking and feeling your best. </p>
                    </div>
                </div>

            </div>
        </div>
        <div class="owl-carousel owl-theme service_area_carousel">
            @foreach($servicesName->take(3) as $key => $item)
                <div class="item d-flex align-items-center">
                    <div class="img_area">
                        <img src="{{ getFile(config('location.service.pathThumbnail').$item->image)}}" alt="">
                    </div>
                    <div class="text_area">
                        <h4>0{{ $key + 1 }}</h4>
                        <h3>@lang(optional($item->serviceDetails)->service_name)</h3>
                        <p>@lang(optional($item->serviceDetails)->short_title)</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endif
@endservice
