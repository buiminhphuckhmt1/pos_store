@extends('layouts.admin')

@section('title', 'Danh sách khách hàng')
@section('content-header', 'Danh sách khách hàng')
@section('content-actions')
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#CategoryModal">
Thêm khách hàng
</button>
    <!-- <a href="" class="btn btn-info"><i class='bx bxs-download'></i>Xuất excel</a>
    <a href="" class="btn btn-info"><i class='bx bx-up-arrow-alt' ></i></i>Nhập excel</a> -->
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
@endsection
@section('content')
<form action="{{ route('customers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal fade" id="CategoryModal" tabindex="-1" aria-hidden="true" style="display: none;">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Thêm khách hàng</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                <div class="form-group">
                    <label for="last_name">Họ và tên</label>
                    <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror"
                           id="last_name"
                           placeholder="Họ và tên" value="{{ old('last_name') }}">
                    @error('last_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone">Số điên thoại</label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone"
                           placeholder="Số đien thoại" value="{{ old('phone') }}">
                    @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="address">Địa chỉ</label>
                    <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                           id="address"
                           placeholder="Địa chỉ" value="{{ old('address') }}">
                    @error('address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <button class="btn btn-primary mt-3" type="submit">Tạo</button>
                </div>
                </div>
             </div>
            </div>
            </form>
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Họ và tên</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Ngày thêm</th>
                    <th style="text-align: center;">Hành động</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($customers as $customer)
                    <tr>
                        <td>{{$customer->id}}</td>
                        <td>{{$customer->last_name}}</td>
                        <td>{{$customer->phone}}</td>
                        <td>{{$customer->address}}</td>
                        <td>{{$customer->created_at}}</td>
                        <td>
                            <div class="dropdown" style="text-align: center;">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                <button class="dropdown-item btn" data-bs-toggle="modal" data-bs-target="#CategoryeditModal{{$customer->id}}"><i class="bx bx-edit-alt me-1"></i>Sửa</button>
                                <a class="dropdown-item" href="{{route('customers.destroy', $customer)}}" onclick="return window.confirm('Bạn có xác nhận xóa không');"><i class="bx bx-trash me-1"></i> Xóa</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <form action="{{ route('customers.update', $customer) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal fade" id="CategoryeditModal{{$customer->id}}" tabindex="-1" aria-hidden="true" style="display: none;">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Sửa thương hiệu</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                <div class="form-group">
                    <label for="last_name">Họ và tên</label>
                    <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror"
                           id="last_name"
                           placeholder="Họ và tên" value="{{ old('last_name', $customer->last_name) }}">
                    @error('last_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone">SĐT</label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone"
                           placeholder="Số điện thoại" value="{{ old('phone', $customer->phone) }}">
                    @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="address">Địa chỉ</label>
                    <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                           id="address"
                           placeholder="Địa chỉ" value="{{ old('address', $customer->address) }}">
                    @error('address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <button class="btn btn-primary mt-3" type="submit">Cập nhật</button>
                </div>
                </div>
                </div>
                </div>
            </form>
                @endforeach
                </tbody>
            </table>
            {{ $customers->render() }}
        </div>
    </div>
@endsection
