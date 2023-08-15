@extends('layouts.admin')

@section('title', 'Cài đặt cấu hình')
@section('content-header', 'Cài đặt cấu hình')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('settings.store') }}" method="post">
            @csrf

            <div class="form-group">
                <label for="app_name">Tên ứng dung</label>
                <input type="text" name="app_name" class="form-control @error('app_name') is-invalid @enderror" id="app_name" placeholder="Tên ứng dung" value="{{ old('app_name', config('settings.app_name')) }}">
                @error('app_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="app_description">Mô tả</label>
                <textarea name="app_description" class="form-control @error('app_description') is-invalid @enderror" id="app_description" placeholder="Mô tả">{{ old('app_description', config('settings.app_description')) }}</textarea>
                @error('app_description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="currency_symbol">Đơn vị tiền tệ</label>
                <input type="text" name="currency_symbol" class="form-control @error('currency_symbol') is-invalid @enderror" id="currency_symbol" placeholder="Đơn vị tiền tệ" value="{{ old('currency_symbol', config('settings.currency_symbol')) }}">
                @error('currency_symbol')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="warning_quantity">Số lượng </label>
                <input type="text" name="warning_quantity" class="form-control @error('warning_quantity') is-invalid @enderror" id="warning_quantity" placeholder="Warning quantity" value="{{ old('warning_quantity', config('settings.warning_quantity')) }}">
                @error('warning_quantity')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <button type="submit" class="mt-3 btn btn-primary">Thay đổi cài đặt</button>
        </form>
    </div>
</div>
@endsection
