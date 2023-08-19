@extends('layouts.admin')

@section('title', 'Chỉnh sửa sản phẩm ')
@section('content-header', 'chỉnh sửa thông tin sản phẩm')

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label for="name">Tên sản phẩm</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name"
                    placeholder="tên sản phẩm" value="{{ old('name', $product->name) }}">
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>


            <div class="form-group mb-3">
                <label for="description">Đơn vị tính</label>
                <input type="text" name="description" class="form-control @error('description') is-invalid @enderror"
                    id="description"
                    placeholder="đơn vị tính" value="{{ old('description', $product->description) }}">
                @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="image">Ảnh</label>
                <div class="d-flex align-items-start align-items-sm-center gap-4">
                    <img src="{{ Storage::url($product->image) }}"  alt="user-avatar" class="d-block " height="80" width="80" id="uploadedAvatar">
                    <div class="button-wrapper">
                        <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                            <span class="d-none d-sm-block">Tải ảnh lên</span>
                            <i class="bx bx-upload d-block d-sm-none"></i>
                            <input  type="file" name="image" id="upload" class="account-file-input" hidden="" accept="image/png, image/jpeg">
                        </label>
                        <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                            <i class="bx bx-reset d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Định dạng</span>
                        </button>

                        <p class="text-muted mb-0">Cho phép JPG, GIF hoặc PNG. Kích thước tối đa 800K</p>
                    </div>
                </div>
                @error('image')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="barcode">Mã vạch</label>
                <input type="text" name="barcode" class="form-control @error('barcode') is-invalid @enderror"
                    id="barcode" placeholder="mã vạch" value="{{ old('barcode', $product->barcode) }}">
                @error('barcode')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="inputprice">Giá nhập</label>
                <input type="text" name="inputprice" class="form-control @error('inputprice') is-invalid @enderror" id="inputprice"
                    placeholder="giá nhập" value="{{ old('inputprice',$product->inputprice) }}">
                @error('inputprice')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="outputprice">Giá bán</label>
                <input type="text" name="outputprice" class="form-control @error('outputprice') is-invalid @enderror" id="outputprice"
                    placeholder="giá bán" value="{{ old('outputprice',$product->outputprice) }}">
                @error('outputprice')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="quantity">Số lượng</label>
                <input type="text" name="quantity" class="form-control @error('quantity') is-invalid @enderror"
                    id="quantity" placeholder="Quantity" value="{{ old('quantity', $product->quantity) }}">
                @error('quantity')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="status">Trạng thái</label>
                <select name="status" class="form-control @error('status') is-invalid @enderror" id="status">
                    <option value="1" {{ old('status', $product->status) === 1 ? 'selected' : ''}}>Hiện</option>
                    <option value="0" {{ old('status', $product->status) === 0 ? 'selected' : ''}}>Ẩn</option>
                </select>
                @error('status')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <button class="btn btn-primary" onclick="return window.confirm('Bạn có xác nhận sửa không');" type="submit">Cập nhật</button>
        </form>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script>
    $(document).ready(function () {
        bsCustomFileInput.init();
    });
</script>
@endsection