@extends('layouts.admin')

@section('title', 'Danh mục sản phẩm')
@section('content-header', 'Danh mục sản phẩm')

@section('content-actions')
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#CategoryModal">
    Tạo danh mục
</button>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css">
@endsection
@section('content')
<form action="{{ route('categorys.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
                        <div class="modal fade" id="CategoryModal" tabindex="-1" aria-hidden="true" style="display: none;">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Tạo danh mục</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="nameBasic" class="form-label">Mã danh mục</label>
                                        <input type="text" name="code" id="code" class="form-control" placeholder="Nhập mã danh mục">
                                    </div>
                                    <div class="col mb-3">
                                        <label for="nameBasic" class="form-label">Tên danh mục</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Nhập tên danh mục">
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
                    <th style="min-width: 100px;">Mã</th>
                    <th>Tên danh mục</th>
                    <th></th>
                    <th style="text-align: right;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($categorys as $category)
                <tr>
                    <td>{{$category->id}}</td>
                    <td>{{$category->code}}</td>
                    <td>{{$category->name}}</td>
                    <td></td>
                    <td style="text-align: right;">
                        <div class="dropdown" style="text-align: right; padding-right: 20px;">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                              <button class="dropdown-item btn" data-bs-toggle="modal" data-bs-target="#CategoryeditModal{{$category->id}}"><i class="bx bx-edit-alt me-1"></i>Sửa</button>
                              <button class="dropdown-item btn-delete" data-url="{{route('categorys.destroy', $category)}}"><i class="bx bx-trash me-1"></i> Xóa</button>
                            </div>
                        </div>
                    </td>
                </tr>
                <form action="{{ route('categorys.update', $category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
                        <div class="modal fade" id="CategoryeditModal{{$category->id}}" tabindex="-1" aria-hidden="true" style="display: none;">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Sửa danh mục</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="nameBasic" class="form-label">Mã danh mục</label>
                                        <input type="text" name="code" id="code" class="form-control" placeholder="Nhập mã danh mục"
                                        value="{{ old('name', $category->code) }}">
                                    </div>
                                    <div class="col mb-3">
                                        <label for="nameBasic" class="form-label">Tên danh mục</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Nhập tên danh mục"
                                        value="{{ old('name', $category->name) }}">
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
        {{ $categorys->render() }}
      </div>
    </div>
</div>
@endsection
