<!-- Main Sidebar Container -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="{{ url('backend/home') }}" class="app-brand-link">
              <span class="app-brand-logo demo w-px-30 h-px-30">
                  <img class="w-px-30 h-px-30" src="{{ asset('template/images/favicon_forum.jpg') }}">
                </svg>
              </span>
              <span class="app-brand-text demo menu-text fw-bolder ms-2" style="text-transform: uppercase;">{{ config('app.name') }}</span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>
          <ul class="menu-inner py-1">
            <li class="menu-item">
              <a href="{{route('home')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Thống kê</div>
              </a>
            </li>
            <li class="menu-item open">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-table"></i>
                <div data-i18n="Tables">Quản lý bảng</div>
              </a>
              <ul class="menu-sub">
              <li class="menu-item {{ activeSegment('cart') }}">
                  <a href="{{ route('cart.index') }}" class="menu-link">
                    <div data-i18n="Tables">Tạo hóa đơn</div>
                  </a>
                </li>
                <li class="menu-item {{ activeSegment('products') }}">
                  <a href="{{ route('products.index') }}" class="menu-link">
                    <div data-i18n="Tables">Quản lý sản phẩm</div>
                  </a>
                </li>
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
                <li class="menu-item">
                  <a href="{{ url('backend/category') }}" class="menu-link">
                    <div data-i18n="Tables">Quản lý công nợ</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="{{ url('backend/users') }}" class="menu-link">
                    <div data-i18n="Tables">Quản lý tài khoản</div>
                  </a>
                </li>
                <li class="menu-item {{ activeSegment('settings') }}">
                  <a href="{{ route('settings.index') }}" class="menu-link">
                    <div data-i18n="Tables">Cài đặt cấu hình</div>
                  </a>
                </li>
                <li class="menu-item">
                    <a href="{{route('logout')}}" class="menu-link" >
                        <div data-i18n="Tables">Đăng xuất</div>
                    </a>
                </li>
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
                    <div data-i18n="Tables">0338799081</div>
                  </a>
                  <a href="https://www.facebook.com/longmotull" target="_blank" class="menu-link">
                    <i class='menu-icon tf-icons bx bxl-facebook-square'></i>
                    <div data-i18n="Tables">Facebook</div>
                  </a>
                  <a href="https://zalo.me/0338799081" target="_blank" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-phone-call"></i>
                    <div data-i18n="Tables">Zalo</div>
                  </a>
                </ul>
            </li>
        </ul>
        </aside>
