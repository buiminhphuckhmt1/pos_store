@extends('layouts.admin')

@section('title', 'Thương hiệu sản phẩm')
@section('content-header', 'Thương hiệu sản phẩm')
@section('search')
        <form class="d-flex" action="{{ route('brands.index') }}" method="GET" enctype="multipart/form-data">
@endsection
@section('content-actions')
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#CategoryModal">
    Tạo thương hiệu
</button>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css">
@endsection
@section('content')
<form action="{{ route('brands.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
                        <div class="modal fade" id="CategoryModal" tabindex="-1" aria-hidden="true" style="display: none;">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Tạo thương hiệu</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                      <label for="nameBasic" class="form-label">Ảnh thương hiệu</label>
                                      <div class="d-flex justify-content-left">
                                          <img src="/storage/products/defaulppicture.jpg"  alt="" class="d-block rounded border border-2 border-light me-2" height="110" width="110" id="uploadedAvatar">
                                          <div class="d-flex flex-column justify-content-center">
                                              <label for="upload" class="btn btn-primary " tabindex="0">
                                                  <span class="d-none d-sm-block">Tải ảnh lên</span>
                                                  <i class="bx bx-upload d-block d-sm-none"></i>
                                                  <input  type="file" name="image" id="upload" class="account-file-input" hidden="" accept="image/png, image/jpeg">
                                              </label>
                                              <button type="button" class="btn btn-outline-secondary account-image-reset mt-2">
                                                  <i class="bx bx-reset d-block d-sm-none"></i>
                                                  <span class="d-none d-sm-block">Định dạng</span>
                                              </button>
                                          </div>
                                      </div>
                                      
                                      <p class="text-muted mb-0">Cho phép JPG, GIF, PNG. Tối đa 800K</p>
                                      @error('image')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                      @enderror
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="nameBasic" class="form-label">Tên thương hiệu</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Nhập tên thương hiệu">
                                    </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                  Đóng
                                </button>
                                <button type="submit" class="btn btn-primary">Lưu</button>
                              </div>
                            </div>
                          </div>
                        </div>
</form>

<div class="card product-list">
    <div class="card-body">
      <div class="table-responsive text-nowrap ">
      <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th style="min-width: 100px;">Ảnh</th>
                    <th>Tên thương hiệu</th>
                    <th></th>
                    <th style="text-align: right;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($brands as $brand)
                <tr>
                    <td>{{$brand->id}}</td>
                    <td>
                        <ul class="users-list m-0 avatar-group d-flex align-items-center p-0" style="list-style: none;">
                          <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar pull-up" title="" data-bs-original-title="{{$brand->name}}">
                            <img src="{{ Storage::url($brand->image) }}" alt="Avatar" class="">                           
                          </li>
                        </ul> 
                    </td>
                    <td>{{$brand->name}}</td>
                    <td></td>
                    <td style="text-align: right;">
                        <div class="dropdown" style="text-align: right; padding-right: 20px;">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                              <button class="dropdown-item btn" data-bs-toggle="modal" data-bs-target="#CategoryeditModal{{$brand->id}}"><i class="bx bx-edit-alt me-1"></i>Sửa</button>
                              <button class="dropdown-item btn-delete" data-url="{{route('brands.destroy', $brand)}}"><i class="bx bx-trash me-1"></i> Xóa</button>
                            </div>
                        </div>
                    </td>
                </tr>
                <form action="{{ route('brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
                        <div class="modal fade" id="CategoryeditModal{{$brand->id}}" tabindex="-1" aria-hidden="true" style="display: none;">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Sửa thương hiệu</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                <div class="col-lg-6">
                                      <label for="nameBasic" class="form-label">Ảnh thương hiệu</label>
                                      <input class="form-control"name="image" type="file" id="formFile">
                                      
                                      <p class="text-muted mb-0">Cho phép JPG, GIF, PNG. Tối đa 800K</p>
                                      @error('image')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                      @enderror
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="nameBasic" class="form-label">Tên thương hiệu</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Nhập tên thương hiệu"
                                        value="{{ old('name', $brand->name) }}">
                                    </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                  Đóng
                                </button>
                                <button type="submit" class="btn btn-primary">Lưu</button>
                              </div>
                            </div>
                          </div>
                        </div>
</form>
                @endforeach
            </tbody>
        </table>
        {{ $brands->render() }}
      </div>
    </div>
</div>
@endsection
