@extends('layouts.admin')

@section('title', 'In nhãn sản phẩm')
@section('content-header', 'In nhãn sản phẩm')
@section('search')
        <form class="d-flex"  action="{{ route('print.print') }}" method="GET" enctype="multipart/form-data">
@endsection
@section('content-actions')
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css">
@endsection
@section('content')
<div class="col-lg-3 col-md-6 mb-4">
                      <div class="mt-3">
                        <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasEnd" aria-controls="offcanvasEnd">
                          Hướng dẫn in nhãn
                        </button>
                        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEnd" aria-labelledby="offcanvasEndLabel" aria-hidden="true" style="visibility: hidden;">
                          <div class="offcanvas-header">
                            <h5 id="offcanvasEndLabel" class="offcanvas-title">Hướng dẫn in nhãn</h5>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                          </div>
                          <div class="offcanvas-body my-auto mx-0 flex-grow-0">
                            <p class="text-center" style="front-size=12px;">
                            đm phước
                              click chuột vào ô tìm kiếm nhập tên hoặc mã sản phẩm muốn in nhãn sau đó nhắn enter. 
                            </p>
                            <button type="button" class="btn btn-outline-secondary d-grid w-100" data-bs-dismiss="offcanvas">
                              Cancel
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
<div class="card product-list">
    <div class="card-body">
      <div class="table-responsive text-nowrap">
      <table class="table">
            <thead>
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Barcode</th>
                    
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr style="text-align: left;">
                    <td>{{$product->name}}</td>                   
                    <td>{{$product->barcode}}</td>
                    <td>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
      </div>
    </div>
</div>
<div class="d-flex gap-4 mt-4">
<button type="button" class="btn btn-info toggle-display">Cập nhật</button>
</div>
<div class="container-xxl flex-grow-1 container-p-y">
<div class="row border border-dark box is-toggle d-none">
<div class="d-block gap-4 mt-2">
<button type="button" class="btn btnprn btn-info"><i class="bx bx-printer"></i></button>
</div>
              @for ($i = 0; $i < 8; $i++)
                <div class="col-md-6 col-xl-3">
                  <div class="card shadow-none bg-transparent border border-dark mb-3 mt-3">
                    <div class="card-body">
                      <div class="barcode-item style30">
                          @foreach ($products as $product)
                          <div class="head_barcode text-center">
                              <h5 class="barcode-name mb-0 p-0">{{$product->name}}</h5> 
                          </div>
                          <div textmargin="0" fontoptions="bold" class="barcode">
                          {!! DNS1D::getBarcodeHTML($product->barcode, "C128",2,70) !!}
                          </div>
                          @endforeach
                      </div>
                    </div>
                  </div>
                </div>
              @endfor
              </div>
            </div>
            <div id='printTable' class="d-none">
              <table class="table table-striped" cellpadding="25" text-align="center">
              <tbody>
              @for ($j = 0; $j < 2; $j++)
                <tr text-align="center">
                @for ($i = 0; $i < 4; $i++)
                  <td text-align="center">
                    <div class="barcode-item style30">
                      @foreach ($products as $product)
                      <div class="head_barcode text-center">
                        <h1 class="barcode-name mb-0 p-0">{{$product->name}}</h1> 
                      </div>
                      <div textmargin="0" fontoptions="bold" class="barcode">
                        {!! DNS1D::getBarcodeHTML($product->barcode, "C128",3,150) !!}
                      </div>
                      @endforeach
                    </div>
                  </td>
                  @endfor
                </tr>
                @endfor
              </tbody>
              </table>
            </div>
@endsection
@section('js')

@endsection
