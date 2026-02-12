@extends($theme.'layouts.app')
@section('title',trans('Home'))

@section('content')
    @include($theme.'partials.heroBanner')

    @include($theme.'sections.about-area')
    @include($theme.'sections.experience')
    @include($theme.'sections.service')
    @include($theme.'sections.speciality')
  
    @include($theme.'sections.pricing-plan')
    @include($theme.'sections.gallery')
    @include($theme.'sections.testimonial')
    @include($theme.'sections.team')
    @include($theme.'sections.book-appointment')

@endsection
 