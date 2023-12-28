<!-- Main Sidebar Container -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="{{route('home')}}" class="app-brand-link">
              <span class="app-brand-logo demo w-px-30 h-px-30">
                  <img class="w-px-30 h-px-30" src="/storage/products/logo.png">
              </span>
              <span class="app-brand-text demo menu-text fw-bolder ms-2" style="text-transform: uppercase;">{{ config('app.name') }}</span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>
          <ul class="menu-inner py-1">
          @if(Auth::user()->role_id && Auth::user()->role_id == 4)
            <li class="menu-item">
              <a href="{{route('home')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Thống kê</div>
              </a>
            </li>
            @endif
            <li class="menu-item open">
              <ul class="menu-sub">
              @if(Auth::user()->role_id && Auth::user()->role_id != 3)
              <li class="menu-item {{ activeSegment('cart') }}">
                  <a href="{{ route('cart.index') }}" class="menu-link">
                    <div data-i18n="Tables">Tạo hóa đơn</div>
                  </a>
                </li>
                @endif
                <li class="menu-item {{ activeSegment('products') }}">
                  <a href="{{ route('products.index') }}" class="menu-link">
                    <div data-i18n="Tables">Quản lý sản phẩm</div>
                  </a>
                </li>
                @if(Auth::user()->role_id && Auth::user()->role_id != 3)
                <li class="menu-item {{ activeSegment('orders') }}">
                  <a href="{{ route('orders.index') }}" class="menu-link">
                    <div data-i18n="Tables">Quản lý hóa đơn</div>
                  </a>
                </li>
                <li class="menu-item {{ activeSegment('customers') }}" >
                  <a href="{{ route('customers.index') }}" class="menu-link">
                    <div data-i18n="Tables">Quản lý khách hàng</div>
                  </a>
                </li>
                @endif
                @if(Auth::user()->role_id && Auth::user()->role_id == 1 || Auth::user()->role_id && Auth::user()->role_id == 4 )
                <li class="menu-item {{ activeSegment('users') }}" >
                  <a href="{{ route('users.index') }}" class="menu-link">
                    <div data-i18n="Tables">Quản lý tài khoản</div>
                  </a>
                </li>
                @endif
                @if(Auth::user()->role_id && Auth::user()->role_id != 2)
                <li class="menu-item {{ activeSegment('suppliers') }}" >
                  <a href="{{ route('suppliers.index') }}" class="menu-link">
                    <div data-i18n="Tables">Nhà cung cấp</div>
                  </a>
                </li>
                
                <li class="menu-item {{ activeSegment('cargo') }}" >
                  <a href="{{ route('cargo.index') }}" class="menu-link">
                    <div data-i18n="Tables">Nhập hàng</div>
                  </a>
                </li>
                <li class="menu-item {{ activeSegment('purchars') }}">
                  <a href="{{ route('purchars.index') }}" class="menu-link">
                    <div data-i18n="Tables">Quản lý nhập hàng</div>
                  </a>
                </li>
                @endif
                
                @if(Auth::user()->role_id && Auth::user()->role_id == 4 )
                <li class="menu-item {{ activeSegment('settings') }}">
                  <a href="{{ route('settings.index') }}" class="menu-link">
                    <div data-i18n="Tables">Cài đặt cấu hình</div>
                  </a>
                </li>
                @endif
              </ul>
            </li>
            <li class="menu-item open">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-support"></i>
                    <div data-i18n="Tables">Liên hệ hỗ trợ</div>
                </a>
                <ul class="menu-sub">
                  <a href="javascript:void(0);" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-phone"></i>
                    <div data-i18n="Tables">0389426653</div>
                  </a>
                  <a href="https://www.facebook.com/phuoc.bui.52643821" target="_blank" class="menu-link">
                    <i class='menu-icon tf-icons bx bxl-facebook-square'></i>
                    <div data-i18n="Tables">Facebook</div>
                  </a>
                  <a href="https://zalo.me/0389426653" target="_blank" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-phone-call"></i>
                    <div data-i18n="Tables">Zalo</div>
                  </a>
                </ul>
            </li>
        </ul>
        </aside>
