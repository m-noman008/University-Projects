@extends('admin.layouts.app')
@section('title')
    @lang('Product List')
@endsection

@section('content')
    <div class="page-header card card-primary m-0 m-md-4 my-4 m-md-0 p-2 pt-4 pl-4 shadow">
        <div class="row justify-content-between">
            <div class="col-md-12">
                <form action="{{ route('admin.product.search') }}" method="get">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" name="product_name" value="{{ @request()->product_name }}"
                                    class="form-control get-trx-id" placeholder="@lang('Search for Product ')" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" name="product_category" value="{{ @request()->product_category }}"
                                    class="form-control get-username" placeholder="@lang('Search Category')" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" class="btn waves-effect waves-light btn-primary"><i
                                        class="fas fa-search"></i> @lang('Search')</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <div class="media mb-4 float-right">
                <a href="{{ route('admin.product.create') }}" class="btn btn-sm btn-primary mr-2">
                    <span><i class="fa fa-plus-circle"></i> @lang('Add New')</span>
                </a>
            </div>
            <div class="table-responsive">
                <table class="categories-show-table table table-hover table-striped table-bordered" id="zero_config">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">@lang('SL No.')</th>
                            <th scope="col">@lang('Product')</th>
                            <th scope="col">@lang('Category')</th>
                            <th scope="col">@lang('Price')</th>
                            <th scope="col">@lang('Stock')</th>
                            <th scope="col">@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productList as $item)
                            <tr>
                                <td data-label="@lang('SL No.')">{{ $loop->index + 1 }}</td>
                                <td data-label="@lang('Product')">
                                    <a
                                        href="{{ route('product.details', [slug(optional($item->details)->product_name), $item->id]) }}">
                                        <div class="d-lg-flex d-block align-items-center">
                                            <div class="mr-3"><img
                                                    src="{{ getFile(config('location.product.path_thumbnail') . $item->thumbnail_image) }}"
                                                    alt="user" class="rounded-circle" width="45" height="45">
                                            </div>
                                            <div class="">
                                                <p class="text-secondary mb-0">@lang(optional($item->details)->product_name)</p>
                                            </div>
                                        </div>
                                    </a>
                                </td>
                                <td data-label="@lang('Category')">
                                    @lang(optional(optional($item->category)->details)->name)
                                </td>
                                <td data-label="@lang('Price')">
                                    @lang(config('basic.currency_symbol'))
                                    @lang($item->price)
                                </td>

                                <td data-label="@lang('Stock')">
                                    {{ $item->stock_total ?? 'N/A' }}
                                </td>
                                <td data-label="@lang('Action')">
                                    <a href="{{ route('admin.product.edit', $item->id) }}"
                                        class="btn btn-sm btn-primary edit-button text-white">
                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                    </a>
                                    <a href="javascript:void(0)" data-route="{{ route('admin.product.delete', $item->id) }}"
                                        data-toggle="modal" data-target="#delete-modal"
                                        class="btn btn-danger btn-sm notiflix-confirm"><i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%">@lang('No Data Found')</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Delete Modal -->
    <div id="delete-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="primary-header-modalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h4 class="modal-title" id="primary-header-modalLabel">@lang('Delete Confirmation')
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                    </button>
                </div>
                <div class="modal-body">
                    <p>@lang('Are you sure to delete this?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">@lang('Close')</button>
                    <form action="" method="post" class="deleteRoute">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-primary">@lang('Yes')</button>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection


@push('js')
    @if ($errors->any())
        @php
            $collection = collect($errors->all());
            $errors = $collection->unique();
        @endphp
        <script>
            "use strict";
            @foreach ($errors as $error)
                Notiflix.Notify.Failure("{{ trans($error) }}");
            @endforeach
        </script>
    @endif

    <script>
        'use strict'
        $(document).ready(function() {
            $('.notiflix-confirm').on('click', function() {
                var route = $(this).data('route');
                $('.deleteRoute').attr('action', route)
            })
        });
    </script>
@endpush
