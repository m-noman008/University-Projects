@plan
<section class="plan_area">
    <div class="container">
        @if(isset($templates['plan'][0]) && $plan = $templates['plan'][0])
            <div class="row">
                <div class="section_header text-center pb-5">
                    <h2 class="text-uppercase">@lang(optional($plan->description)->title)</h2>
                    <p class="title_details">@lang(optional($plan->description)->sub_title)</p>
                </div>
            </div>
        @endif
        <div class="row gy-4 justify-content-center">
            @forelse($plans as $key => $plan)
                <div class="col-lg-4 col-sm-6">
                    <div class="card border-0 rounded-0 text-center box_shadow1"
                         data-aos="{{($key % 2 != 0)?'flip-right':'flip-left'}}">
                        <div class="card_header">
                            <h4 class="pb-30 text-uppercase">@lang($plan->name)</h4>
                            <span><span class="price">{{ config('basic.currency_symbol') . $plan->price }}</span></span>
                        </div>
                        <div class="card_image d-flex align-items-center justify-content-center mx-auto mt-30 mb-30">
                            <img src="{{ getFile(config('location.plan.path').$plan->image) }}" alt="">
                        </div>
                        <div class="card_body">
                            <ul class="plan_list mx-auto text-start w-75 mb-30">
                                @foreach($plan->services as $data)
                                    <li><i class="fa-solid fa-check"></i>{{ $data }}</li>
                                @endforeach
                            </ul>
                            <a class="card_btn mx-auto d-flex justify-content-center align-items-center"
                               href="{{ route('user.plan.purchase', $plan->id) }}">@lang('PURCHASE NOW')</a>
                        </div>
                    </div>
                </div>
            @empty
            @endforelse
        </div>
    </div>
</section>
@endplan
