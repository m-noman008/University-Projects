@extends($theme.'layouts.app')
@section('title')
    @lang($title)
@endsection

@section('content')
    <!-- POLICY -->

    <section class="privacy-policy">
        <div class="container">

            <div class="row g-4">
                <div class="col-lg-12">
                    <div class="process_area">
                        <div class="section_bottom">
                            <p> @lang(@$description)</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- /POLICY -->
@endsection
