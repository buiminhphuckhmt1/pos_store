@extends('layouts.admin')

@section('title', 'Nhập hàng')
@section('content-header', 'Nhập hàng')
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
    <div id="purcha">
    </div>
@endsection