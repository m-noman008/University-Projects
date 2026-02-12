@extends('admin.layouts.app')
@section('title')
    Staff Management
@endsection
@section('content')
    <div class="m-0 my-4 shadow card card-primary m-md-4 m-md-0">
        <div class="card-body">
            <div class="float-right mb-4 media">
                <a href="{{ route('admin.staff.create') }}" class="mr-2 btn btn-sm btn-primary">
                    <span><i class="fa fa-plus-circle"></i> Add new</span>
                </a>
            </div>
            <div class="table-responsive">
                <table class="table categories-show-table table-hover table-striped table-bordered" id="zero_config">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">SL No.</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Address</th>
                            <th scope="col">Staff Type</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($staff as $member)
                            @if ($member->role != 'admin')
                                <tr>
                                    <td data-label="@lang('SL No.')">{{ $loop->index + 1 }}</td>
                                    <td data-label="name">
                                        <div class="d-lg-flex d-block align-items-center ">
                                            <div class="">
                                                <span class=" font-16">{{ $member->name }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <td data-label="email">
                                        <div class="d-lg-flex d-block align-items-center ">
                                            <div class="">
                                                <span class=" font-16">{{ $member->email }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-label="phone">
                                        <div class="d-lg-flex d-block align-items-center ">
                                            <div class="">
                                                <span class=" font-16">{{ $member->phone }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-label="address">
                                        <div class="d-lg-flex d-block align-items-center ">
                                            <div class="">
                                                <span class=" font-16">{{ $member->address }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-label="staff_type">
                                        <div class="d-lg-flex d-block align-items-center ">

                                            <div class="">
                                                <span class=" font-16">{{ $member->role }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-label="action">
                                        <a href="{{ route('admin.staff.edit', $member->id) }}"
                                            class="text-white btn btn-sm btn-primary edit-button">
                                            <i class="fa fa-edit" aria-hidden="true"></i>
                                        </a>
                                        <form action="{{ route('admin.staff.delete', $member->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm notiflix-confirm">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('style-lib')
        <link href="{{ asset('assets/admin/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
    @endpush
    @push('js')
        <script src="{{ asset('assets/admin/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/admin/js/datatable-basic.init.js') }}"></script>
    @endpush
@endsection
