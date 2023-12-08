@extends('layouts.admin')

@section('title', 'Tạo sản phẩm mới')
@section('content-header', 'Tạo sản phẩm mới')

@section('content')

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="mb2 col-md-8">
                    <div>
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="mb-2 col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="name">Tên sản phẩm</label>
                                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name"
                                                placeholder="nhập tên sản phẩm" value="{{ old('name') }}">
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="barcode">Mã vạch</label>
                                            <div class="input-group">
                                                <input type="text" name="barcode" class="form-control @error('barcode') is-invalid @enderror"
                                                    id="barcode" placeholder="mã vạch" value="{{ old('barcode') }}">
                                                <button id="generate" type="button"  class="btn btn-outline-primary  dropdown-toggle-split show">
                                                <span>
                                                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAKhJREFUSEvtlVEOQDAQRJ+bcBNOJk7iKm7CTch+VFZjLak2kehPUWam0zVbkXlUmfEpStACPSCzHp6INXp/AgZA5sMOZqA+sewpgUAIeBcTBCUeoHdsBxwNVpRAk8m1CNFeh3vr+e6OtYMsBNrbFIJbJfgT7DZZNf9Ni2LVoZa/8x8UjQov0K7WzbB7M64XoInjWhrNeNITvPi+3XBSbDG/9dQlk2Yn2AALWFAZGuo/rAAAAABJRU5ErkJggg=="/>
                                                </span>
                                                </button>
                                            </div>
                                                    @error('barcode')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="brand_id">Thương hiệu</label>
                                            <select class="form-select @error('brand_id') is-invalid @enderror"
                                                id="brand_id"name="brand_id" id="exampleFormControlSelect1" aria-label="Default select example">
                                                <option selected>chọn thương hiệu</option>
                                                @foreach($brands as $row)
                                                        <option value="{{$row->id }}">{{ $row->name }}</option>
                                                    @endforeach
                                            </select>
                                            @error('brand_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-2 col-md-6"> 

                                        <div class="form-group mb-3">
                                                <label for="category_id">Danh mục</label>
                                                <select class="form-select @error('category_id') is-invalid @enderror"
                                                    id="category_id" name="category_id" id="exampleFormControlSelect1" aria-label="Default select example">
                                                    <option selected>chọn danh mục</option>
                                                    @foreach($products as $row)
                                                    <option value="{{$row->id }}">{{ $row->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('category_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                        </div>
                                        <div class="form-group mb-3">
                                        <label for="discountpercen">Giảm giá</label>
                                            <div class="input-group">
                                            <input type="text" name="discountpercen" class="form-control @error('discountpercen') is-invalid @enderror" id="discountpercen"
                                                    placeholder="nhập giảm giá" value="{{ old('discountpercen') }}">
                                                <span class="input-group-text">%</span>
                                                @error('discountpercen')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="status">Trạng thái</label>
                                            <select name="status" class="form-control @error('status') is-invalid @enderror" id="status">
                                                <option value="1" {{ old('status') === 1 ? 'selected' : ''}}>Hiện</option>
                                                <option value="0" {{ old('status') === 0 ? 'selected' : ''}}>Ẩn</option>
                                            </select>
                                            @error('status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="description">Mô tả</label>
                                    <textarea class="form-control" type="text" name="description" class="form-control @error('description') is-invalid @enderror"
                                        id="description" placeholder="nhập mô tả ..." value="{{ old('description') }}" rows="3"></textarea>   
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="mb-2 col-md-6">
                                    <div class="form-group mb-3">
                                            <label for="inputprice">Giá nhập</label>
                                            <input type="text" name="inputprice" class="form-control @error('inputprice') is-invalid @enderror" id="inputprice"
                                                placeholder="giá nhập" value="{{ old('inputprice') }}">
                                            @error('inputprice')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="unit_purchas">Đơn vị nhập vào</label>
                                            <input type="text" name="unit_purchas" class="form-control @error('unit_purchas') is-invalid @enderror" id="unit_purchas"
                                                placeholder="giá bán" value="{{ old('unit_purchas') }}">
                                            @error('unit_purchas')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="stock_alert">Cảnh báo số lượng</label>
                                            <input type="text" name="stock_alert" class="form-control @error('stock_alert') is-invalid @enderror" id="stock_alert"
                                                placeholder="nhập số lượng cảnh báo" value="{{ old('stock_alert') }}">
                                            @error('stock_alert')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-2 col-md-6"> 

                                        <div class="form-group mb-3">
                                            <label for="outputprice">Giá bán</label>
                                            <input type="text" name="outputprice" class="form-control @error('outputprice') is-invalid @enderror" id="outputprice"
                                                 placeholder="giá bán" value="{{ old('outputprice') }}">
                                            @error('outputprice')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-3">
                                                <label for="unit_sale">Đơn vị bán ra</label>
                                                <input type="text" name="unit_sale" class="form-control @error('unit_sale') is-invalid @enderror" id="unit_sale"
                                                    placeholder="giá bán" value="{{ old('unit_sale') }}">
                                                @error('unit_sale')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group text-center mb-3">
                                <div class="alert alert-dark mb-0" role="alert"><label for="description">Ảnh sản phẩm</label></div>
                                    <div class="d-flex justify-content-center mt-2">
                                        <img src="/storage/products/defaulppicture.jpg"  alt="" class="d-block" height="140" width="140" id="uploadedAvatar">
                                    
                                    </div>
                                    <div class="d-flex justify-content-center mb-4">
                                            <label for="upload" class="btn btn-primary me-2 " tabindex="0">
                                                <span class="d-none d-sm-block">Tải ảnh lên</span>
                                                <i class="bx bx-upload d-block d-sm-none"></i>
                                                <input  type="file" name="image" id="upload" class="account-file-input" hidden="" accept="image/png, image/jpeg">
                                            </label>
                                            <button type="button" class="btn btn-outline-secondary account-image-reset ">
                                                <i class="bx bx-reset d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Định dạng</span>
                                            </button>
                                        </div>
                                    <p class="text-muted mb-0">Cho phép JPG, GIF, PNG. Tối đa 800K</p>
                                    @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
                    
            <button class="btn btn-primary mt-4" type="submit">Thêm sản phẩm</button>
        </form>
@endsection

@section('js')
<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script>
</script>
@endsection