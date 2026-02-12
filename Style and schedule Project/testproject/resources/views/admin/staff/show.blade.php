@extends('admin.layouts.app')
@section('title')
    @lang('Create Staff')
@endsection
@section('content')
    <div class="m-0 my-4 shadow card card-primary m-md-4 m-md-0">
        <div class="card-body">
            <div class="mb-4 media justify-content-end">
                <a href="{{ route('admin.staff.index') }}" class="mr-2 btn btn-sm btn-primary">
                    <span><i class="fas fa-arrow-left"></i>Back</span>
                </a>
            </div>
            <div class="mt-2 tab-content" id="myTabContent">

                <div class="container">
                    <form method="post" action="{{ route('admin.staff.store') }}" class="mt-4"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-sm-12 col-md-6">
                                <label for="name"> Name </label>
                                <input type="text" name="name" class="form-control" placeholder="Enter Name"
                                    autocomplete="off" value="{{ $staff->name }}">
                            </div>
                            <div class="mb-3 col-sm-12 col-md-6">
                                <label for="name"> Username </label>
                                <input type="text" name="username" class="form-control" placeholder="Enter Name"
                                    autocomplete="off" value="{{ $staff->username }}">
                            </div>
                            <div class="mb-3 col-sm-12 col-md-6">
                                <label for="email"> Email </label>
                                <input type="text" name="email" class="form-control" placeholder="Enter Email"
                                    autocomplete="off" value="{{ $staff->email }}">
                            </div>

                            <div class="mb-3 col-sm-12 col-md-6">
                                <label for="phone"> Phone </label>
                                <input type="text" name="phone" class="form-control" placeholder="Enter Phone Number"
                                    autocomplete="off" value="{{ $staff->phone }}">
                            </div>
                            <div class="mb-3 col-sm-12 col-md-6">
                                <label for="address"> Address </label>
                                <input type="text" name="address" class="form-control" placeholder="Enter Address"
                                    autocomplete="off" value="{{ $staff->address }}">
                            </div>

                            <div class="mb-3 col-sm-12 col-md-6">
                                <label for="password"> Password </label>
                                <input type="text" name="password" class="form-control" placeholder="Enter Password"
                                    autocomplete="off">
                            </div>
                            <div class="mb-3 col-sm-12 col-md-6">
                                <label for="status">Status</label>
                                <select name="status" class="form-control">
                                    <option value="">Select Status</option>
                                    <option value="1" {{ $staff->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $staff->status == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="mb-3 col-sm-12 col-md-6">
                                <label for="staff_type">Role</label>
                                    <select name="staff_type" class="form-control">
                                        <option value="">Select Role</option>
                                        <option value="appointer" {{ $staff->staff_type == 'appointer' ? 'selected' : '' }}>
                                            Appointer</option>
                                        <option value="order_manager"
                                            {{ $staff->staff_type == 'order_manager' ? 'selected' : '' }}>Order Manager
                                        </option>
                                    </select>
                            </div>
                        </div>

                        <div class="mt-3 row ">

                            <div class="col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <div>
                                        <label for="image-upload"></label>
                                        <input type="file" name="image" placeholder="Choose Image">
                                    </div>
                                </div>
                            </div>
                        </div>


                        <button type="submit"
                            class="mt-3 btn waves-effect waves-light btn-rounded btn-primary btn-block">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
