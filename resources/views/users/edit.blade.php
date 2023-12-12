@extends('layouts.admin')

@section('title', 'Danh sách người dùng')
@section('content-header', 'Danh sách người dùng')
@section('search')
        <form class="d-flex" action="{{ route('users.index') }}" method="GET" enctype="multipart/form-data">
@endsection
@section('content-actions')
@if(Auth::user()->role_id && Auth::user()->role_id == 4 )
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#SupplierModal">
Thêm người dùng
</button>
@endif
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span> Thông tin người dùng</h4>

              <div class="row">
                <div class="col-md-12">
                  <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item">
                      <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i> Account</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="pages-account-settings-notifications.html"><i class="bx bx-bell me-1"></i> Notifications</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="pages-account-settings-connections.html"><i class="bx bx-link-alt me-1"></i> Connections</a>
                    </li>
                  </ul>
                  <div class="card mb-4">
                    <h5 class="card-header">Thông tin người dùng</h5>
                    <!-- Account -->
                    <div class="card-body">
                    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
                      <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img src="../assets/img/avatars/1.png" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar">
                        <div class="button-wrapper">
                          <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                            <span class="d-none d-sm-block">Upload new photo</span>
                            <i class="bx bx-upload d-block d-sm-none"></i>
                            <input type="file" id="upload" class="account-file-input" hidden="" accept="image/png, image/jpeg">
                          </label>
                          <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                            <i class="bx bx-reset d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Reset</span>
                          </button>

                          <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                        </div>
                      </div>
                    </div>
                    <hr class="my-0">
                    <div class="card-body">
                        <div class="row">
                          <div class="mb-3 col-md-6">
                          <label for="nameBasic" class="form-label">Tên người dùng</label>
                                        <input type="text" name="last_name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nhập tên người dùng"
                                        value="{{ old('last_name', $user->last_name) }}">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                          </div>
                          <div class="mb-3 col-md-6">
                          <label for="nameBasic" class="form-label">Mật khẩu mới</label>
                                        <input type="password" name="password" id="password" class="form-control @error('name') is-invalid @enderror"
                                        value="" placeholder="Nhập mật khẩu">
                                        <p class="">nhập nếu muốn đổi mật khẩu</p>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                          </div>
                          <div class="mb-3 col-md-6">
                          <label for="nameBasic" class="form-label">Email</label>
                                        <input type="email" name="email" id="email" class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('email', $user->email) }}" placeholder="Nhập email">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                          </div>
                          <div class="mb-3 col-md-6">
                          <label for="nameBasic" class="form-label">Số điện thoại</label>
                                        <input type="text" name="phone" id="phone" class="form-control @error('name') is-invalid @enderror" 
                                        value="{{ old('phone', $user->phone) }}" placeholder="Nhập số điện thoại">
                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                          </div>
                          <div class="mb-3 col-md-6">
                          <label for="role_id">Chức vụ</label>
                                            <select class="form-select @error('role_id') is-invalid @enderror"
                                                id="role_id"name="role_id" id="exampleFormControlSelect1" aria-label="Default select example">
                                                <option selected>chọn chức vụ</option>
                                                @foreach($roles as $row)
                                                <option value="{{$row->id}}" {{ old('role_id', $user->role_id) === $row->id  ? 'selected' : ''}}>{{ $row->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('role_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                          </div>
                        </div>
                        <div class="mt-2">
                          <button type="submit" class="btn btn-primary me-2">Save changes</button>
                          <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                        </div>
                      </form>
                    </div>
                    <!-- /Account -->
                  </div>
                  <div class="card">
                    <h5 class="card-header">Delete Account</h5>
                    <div class="card-body">
                      <div class="mb-3 col-12 mb-0">
                        <div class="alert alert-warning">
                          <h6 class="alert-heading fw-bold mb-1">Are you sure you want to delete your account?</h6>
                          <p class="mb-0">Once you delete your account, there is no going back. Please be certain.</p>
                        </div>
                      </div>
                      <form id="formAccountDeactivation" onsubmit="return false">
                        <div class="form-check mb-3">
                          <input class="form-check-input" type="checkbox" name="accountActivation" id="accountActivation">
                          <label class="form-check-label" for="accountActivation">I confirm my account deactivation</label>
                        </div>
                        <button type="submit" class="btn btn-danger deactivate-account">Deactivate Account</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
@endsection
