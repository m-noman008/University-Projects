@extends('admin.layouts.app')
@section('title')
    @lang('Manage Gallery Tags')
@endsection

@section('content')
    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">

        <div class="card-body">
            <button class="btn btn-sm btn-primary float-right mb-2" type="button" data-toggle="modal" data-target="#addModal">
                <span><i class="fas fa-plus"></i> @lang('Add New')</span>
            </button>

            <div class="table-responsive">
                <table class="categories-show-table table table-hover table-striped table-bordered" id="zero_config">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">@lang('SL No.')</th>
                            <th scope="col">@lang('Name')</th>
                            <th scope="col">@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($manageTags as $key => $item)
                            <tr>
                                <td data-label="SL No.">{{ ++$key }}</td>
                                <td data-label="@lang('Name')">
                                    @lang($item->name)
                                </td>
                                <td data-label="@lang('Action')">
                                    <button class="btn btn-sm btn-primary edit-button" type="button" data-toggle="modal"
                                        data-target="#editModal" data-name="{{ $item->name }}"
                                        data-route="{{ route('admin.gallery.tag.update', ['id' => $item->id]) }}">
                                        <span><i class="fas fa-edit"></i></span>
                                    </button>
                                    <button class="btn btn-danger btn-sm notiflix-confirm" data-toggle="modal"
                                        data-target="#delete-modal"
                                        data-route="{{ route('admin.gallery.tag.delete', ['id' => $item->id]) }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>

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

    <!-- Add Tag Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">@lang('Add New Tags')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.gallery.tag.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Name')</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                placeholder="@lang('Enter Tag name')" class="form-control form-control-lg">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">
                            <span>@lang('Cancel')</span>
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <span><i class="fas fa-save"></i> @lang('Save')</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">@lang('Edit Tags')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="post" id="editForm">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Name')</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="edit-name form-control form-control-lg">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">
                            <span>@lang('Cancel')</span>
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <span><i class="fas fa-save"></i> @lang('Save Changes')</span></button>
                    </div>
                </form>
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
@push('style-lib')
    <link href="{{ asset('assets/admin/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endpush
@push('js')
    <script src="{{ asset('assets/admin/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/datatable-basic.init.js') }}"></script>


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
        "use strict";
        $(document).ready(function() {
            $(document).on('click', '.edit-button', function() {
                $('#editForm').attr('action', $(this).data('route'))
                $('.edit-name').val($(this).data('name'))
            })

        });
    </script>

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
