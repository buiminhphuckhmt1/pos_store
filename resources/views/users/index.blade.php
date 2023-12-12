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
<form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
                        <div class="modal fade" id="SupplierModal" tabindex="-1" aria-hidden="true" style="display: none;">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Tạo người dùng</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                        <label for="nameBasic" class="form-label">Tên người dùng</label>
                                        <input type="text" name="last_name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nhập tên người dùng">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                        <label for="nameBasic" class="form-label">Mật khẩu</label>
                                        <input type="password" name="password" id="password" class="form-control @error('name') is-invalid @enderror" placeholder="Nhập mật khẩu">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                        <label for="nameBasic" class="form-label">Ảnh</label>
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
                                    </div>

                                    <div class="col-lg-6 ">
                                        <div class="mb-3">
                                        <label for="nameBasic" class="form-label">Email</label>
                                        <input type="email" name="email" id="phone" class="form-control @error('name') is-invalid @enderror" placeholder="Nhập email">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                        <label for="nameBasic" class="form-label">Số điện thoại</label>
                                        <input type="text" name="phone" id="phone" class="form-control @error('name') is-invalid @enderror" placeholder="Nhập số điện thoại">
                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                        <label for="role_id">Chức vụ</label>
                                            <select class="form-select @error('role_id') is-invalid @enderror"
                                                id="role_id"name="role_id" id="exampleFormControlSelect1" aria-label="Default select example">
                                                <option selected>chọn chức vụ</option>
                                                @foreach($roles as $row)
                                                <option value="{{$row->id}}">{{ $row->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('role_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
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
    <div class="card">
        <div class="card-body"><div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Ảnh</th>
                    <th>Họ và tên</th>
                    <th>Số điện thoại</th>
                    <th>Email</th>
                    <th>Chức vụ</th>
                    <th style="text-align: center;">Hành động</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{$user->id}}</td>
                        <td>
                        <ul class="users-list m-0 avatar-group d-flex align-items-center p-0" style="list-style: none;">
                          <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar pull-up" title="" data-bs-original-title="{{$user->name}}">
                            <img src="{{ Storage::url($user->image) }}" alt="Avatar" class="">                           
                          </li>
                        </ul>                        
                    </td> 
                        <td>{{$user->last_name}}</td>
                        <td>{{$user->phone}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->role->name}}</td>
                        <td>
                            <div class="dropdown" style="text-align: center;">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                                </button>

                                <div class="dropdown-menu">
                                <button class="dropdown-item btn" data-bs-toggle="modal" data-bs-target="#CategoryeditModal{{$user->id}}"><i class="bx bx-edit-alt me-1"></i>Sửa</button>
                                <a class="dropdown-item" href="{{route('users.destroy', $user)}}" onclick="return window.confirm('Bạn có xác nhận xóa không');"><i class="bx bx-trash me-1"></i> Xóa</a>
                                </div>
                            

                            </div>
                        </td>
                    </tr>
                    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
                        <div class="modal fade" id="CategoryeditModal{{$user->id}}" tabindex="-1" aria-hidden="true" style="display: none;">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Sửa thông tin người dùng</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                <div class="col-lg-6">
                                        <div class="mb-3">
                                        <label for="nameBasic" class="form-label">Tên người dùng</label>
                                        <input type="text" name="last_name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nhập tên người dùng"
                                        value="{{ old('last_name', $user->last_name) }}">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
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
                                        <div class="mb-3">
                                        <label for="nameBasic" class="form-label">Ảnh</label>
                                        <div class="d-flex justify-content-left">
                                          <img src="{{ Storage::url($user->image) }}"  alt="" class="d-block rounded border border-2 border-light me-2" height="110" width="110" id="uploadedAvatar">
                                          <div class="d-flex flex-column justify-content-center">
                                              <label class="btn btn-primary " tabindex="0">
                                                  <span class="d-none d-sm-block">Tải ảnh lên</span>
                                                  <i class="bx bx-upload d-block d-sm-none"></i>
                                                  <input  type="file" name="image"  hidden="" accept="image/png, image/jpeg">
                                              </label>
                                          </div>
                                      </div>
                                      
                                      <p class="text-muted mb-0">Cho phép JPG, GIF, PNG. Tối đa 800K</p>
                                      @error('image')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                      @enderror
                                    
                                        </div>
                                    </div>

                                    <div class="col-lg-6 ">
                                        <div class="mb-3">
                                        <label for="nameBasic" class="form-label">Email</label>
                                        <input type="email" name="email" id="email" class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('email', $user->email) }}" placeholder="Nhập email">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                        <label for="nameBasic" class="form-label">Số điện thoại</label>
                                        <input type="text" name="phone" id="phone" class="form-control @error('name') is-invalid @enderror" 
                                        value="{{ old('phone', $user->phone) }}" placeholder="Nhập số điện thoại">
                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
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
            {{ $users->render() }}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $(document).on('click', '.btn-delete', function () {
                $this = $(this);
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "Do you really want to delete this user?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        $.post($this.data('url'), {_method: 'DELETE', _token: '{{csrf_token()}}'}, function (res) {
                            $this.closest('tr').fadeOut(500, function () {
                                $(this).remove();
                            })
                        })
                    }
                })
            })
        })
    </script>
@endsection
