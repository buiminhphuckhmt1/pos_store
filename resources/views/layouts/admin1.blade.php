<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', config('app.name'))</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="/storage/products/logo.png">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- overlayScrollbars -->
    <!-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> -->
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <!-- <link rel="stylesheet" href="../assets/admin/layout2/assets/css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="{{ asset('admin/assets/admin/layout1/css/font-awesome.min.css') }}">
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('admin/assets/admin/layout2/assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/admin/layout2/assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('admin/assets/admin/layout2/assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('admin/assets/admin/layout2/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/admin/layout2/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <link rel="stylesheet" href="{{ asset('admin/assets/admin/layout2/assets/vendor/libs/apex-charts/apex-charts.css') }}" />

    <!-- Page CSS -->
    

    <!-- Helpers -->
    <script src="{{ asset('admin/assets/admin/layout2/assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('admin/assets/admin/layout2/assets/js/config.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/assets/ckeditor/ckeditor.js') }}"></script>

    @vite([ 'resources/js/app.js'])
    @yield('css')
    <script>
        window.APP = <?php echo json_encode([
                            'currency_symbol' => config('settings.currency_symbol'),
                            'warning_quantity' => config('settings.warning_quantity')
                        ]) ?>
    </script>
</head>

<body>
    <!-- Site wrapper -->
    <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        
        <!-- Content Wrapper. Contains page content -->
        <div class="layout-page">
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content">
                <div class="container-xxl flex-grow-1 container-p-y ">
          <div class="d-flex justify-content-between mb-2">
          <div class="app-brand demo ">
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
            <div class="input-group-append">
                <button id="expand" type="button" class="btn btn-outline-primary"><span><i class="bx bx-expand"></i></span></button>
                <button id="close" type="button" class="btn btn-outline-primary" style="display:none;"><span><i class="bx bx-collapse"></i></span></button>
            </div>
          </div>

                    @include('layouts.partials.alert.success')
                    @include('layouts.partials.alert.error')
                    @yield('content')
                </div>
            </section>
         </div>
         <div class="container-xxl">
            @include('layouts.partials.footer')
         </div>
        </div>
    </div>
        </div>
    @yield('js')
    <script src="{{ asset('admin/assets/admin/layout2/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('admin/assets/admin/layout2/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('admin/assets/admin/layout2/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('admin/assets/admin/layout2/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('admin/assets/admin/layout2/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('admin/assets/admin/layout2/assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('admin/assets/admin/layout2/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('admin/assets/admin/layout2/assets/js/main.js') }}"></script>
    <!-- Page JS -->
    <!-- <script src="{{ asset('admin/assets/admin/layout2/assets/js/dashboards-analytics.js') }}"></script> -->
    <script src="{{ asset('admin/assets/admin/layout2/assets/js/pages-account-settings-account.js') }}"></script>
    <script>
    function toggleScreenExpand(elem) {
    elem = elem || document.documentElement;
    if (!document.fullscreenElement && !document.mozFullScreenElement &&
        !document.webkitFullscreenElement && !document.msFullscreenElement) {
        if (elem.requestFullscreen) {
        elem.requestFullscreen();
        } else if (elem.msRequestFullscreen) {
        elem.msRequestFullscreen();
        } else if (elem.mozRequestFullScreen) {
        elem.mozRequestFullScreen();
        } else if (elem.webkitRequestFullscreen) {
        elem.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
        }
      document.getElementById('close').style.display= 'block'
      document.getElementById('expand').style.display= 'none'
    } else {
        if (document.exitFullscreen) {
        document.exitFullscreen();
        } else if (document.msExitFullscreen) {
        document.msExitFullscreen();
        } else if (document.mozCancelFullScreen) {
        document.mozCancelFullScreen();
        } else if (document.webkitExitFullscreen) {
        document.webkitExitFullscreen();
        }
      
       document.getElementById('expand').style.display= 'block'
      document.getElementById('close').style.display= 'none'
    }
    }
//on click expand div
$('#expand').on('click',function(){
  var elem = document.getElementById('expand-box');
  toggleScreenExpand(elem);
  var elemmm = document.getElementById('expand');{
  toggleClass(d-none);}
  var elemm = document.getElementById('close');{
  toggleClass(d-block);}
});

$('#close').on('click',function(){
  toggleScreenExpand();
  var elemmmm = document.getElementById('expand');{
  toggleClass(d-none);}
  var elemmmmm = document.getElementById('close');{
  toggleClass(d-none);}
})
        </script>
         <script type="text/javascript">
    
    var options={
      series: [
        {
          name: 'Truy cập',
          data: _ldata
        },
      ],
      chart: {
        height: 300,
        stacked: true,
        type: 'bar',
        toolbar: { show: false }
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '33%',
          borderRadius: 12,
          startingShape: 'rounded',
          endingShape: 'rounded'
        }
      },
      colors: [ config.colors.success],
      dataLabels: {
        enabled: false
      },
      stroke: {
        curve: 'smooth',
        width: 6,
        lineCap: 'round',
        colors: config.colors.white
      },
      legend: {
        show: true,
        horizontalAlign: 'left',
        position: 'top',
        markers: {
          height: 8,
          width: 8,
          radius: 12,
          offsetX: -3
        },
        labels: {
          colors: config.colors.axisColor,
        },
        itemMargin: {
          horizontal: 10
        }
      },
      grid: {
        borderColor: config.colors.borderColor,
        padding: {
          top: 0,
          bottom: -8,
          left: 20,
          right: 20
        }
      },
      xaxis: {
        categories: _odata,
        labels: {
          style: {
            fontSize: '13px',
            colors: config.colors.axisColor,
          }
        },
        axisTicks: {
          show: false
        },
        axisBorder: {
          show: false
        }
      },
      yaxis: {
        labels: {
          style: {
            fontSize: '13px',
            colors: config.colors.axisColor,
          }
        }
      },
      responsive: [
        {
          breakpoint: 1700,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '32%'
              }
            }
          }
        },
        {
          breakpoint: 1580,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '35%'
              }
            }
          }
        },
        {
          breakpoint: 1440,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '42%'
              }
            }
          }
        },
        {
          breakpoint: 1300,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '48%'
              }
            }
          }
        },
        {
          breakpoint: 1200,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '40%'
              }
            }
          }
        },
        {
          breakpoint: 1040,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 11,
                columnWidth: '48%'
              }
            }
          }
        },
        {
          breakpoint: 991,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '30%'
              }
            }
          }
        },
        {
          breakpoint: 840,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '35%'
              }
            }
          }
        },
        {
          breakpoint: 768,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '28%'
              }
            }
          }
        },
        {
          breakpoint: 640,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '32%'
              }
            }
          }
        },
        {
          breakpoint: 576,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '37%'
              }
            }
          }
        },
        {
          breakpoint: 480,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '45%'
              }
            }
          }
        },
        {
          breakpoint: 420,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '52%'
              }
            }
          }
        },
        {
          breakpoint: 380,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '60%'
              }
            }
          }
        }
      ],
      states: {
        hover: {
          filter: {
            type: 'none'
          }
        },
        active: {
          filter: {
            type: 'none'
          }
        }
      }
    };
    var chart = new ApexCharts(document.querySelector("#totalRevenueChart"), options);
    chart.render();
    
       var options = {
        series: [
        {
          name: 'Hàng bán chạy',
          data: _edata,
        }
      ],
      chart: {
        height: 165,
        parentHeightOffset: 0,
        parentWidthOffset: 0,
        toolbar: {
          show: false
        },
        type: 'area'
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        width: 2,
        curve: 'smooth'
      },
      legend: {
        show: false
      },
      markers: {
        size: 4,
        colors: 'transparent',
        strokeColors: 'transparent',
        strokeWidth: 4,
        discrete: [
          {
            fillColor: config.colors.white,
            seriesIndex: 0,
            dataPointIndex: 7,
            strokeColor: config.colors.danger,
            strokeWidth: 2,
            size: 6,
            radius: 8
          }
        ],
        hover: {
          size: 7
        }
      },
      colors: [config.colors.danger],
      grid: {
        borderColor: config.colors.borderColor,
        strokeDashArray: 3,
        padding: {
          top: -20,
          bottom: -8,
          left: 8,
          right: 8
        }
      },
      xaxis: {
        categories: _fdata,
        min:1,
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        },
      },
      yaxis: {
        labels: {
          show: false
        },
        min: 0,
        max: 20,
        tickAmount: 4
      }
        };
      var chart = new ApexCharts(document.querySelector("#incomeChart"), options);
      chart.render();
      
       var options = {
        series: [
        {
          name: 'Bài viết',
          data: _gdata,
        }
      ],
      chart: {
        height: 165,
        parentHeightOffset: 0,
        parentWidthOffset: 0,
        toolbar: {
          show: false
        },
        type: 'area'
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        width: 2,
        curve: 'smooth'
      },
      legend: {
        show: false
      },
      markers: {
        size: 4,
        colors: 'transparent',
        strokeColors: 'transparent',
        strokeWidth: 4,
        discrete: [
          {
            fillColor: config.colors.white,
            seriesIndex: 0,
            dataPointIndex: 7,
            strokeColor: config.colors.danger,
            strokeWidth: 2,
            size: 6,
            radius: 8
          }
        ],
        hover: {
          size: 7
        }
      },
      colors: [config.colors.danger],
      grid: {
      borderColor: config.colors.borderColor,
        strokeDashArray: 3,
        padding: {
          top: -20,
          bottom: -8,
          left: 8,
          right: 8
        }
      },
      xaxis: {
        categories: _hdata,
        min:1,
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        },
      },
      yaxis: {
        labels: {
          show: false
        },
        min: 0,
        max: 20,
        tickAmount: 4
      }
        };
      var chart = new ApexCharts(document.querySelector("#incomemonthChart"), options);
      chart.render();
      $(function(){
        
      
      var options = {
        chart: {
          height: 165,
        type: 'donut'
      },
      labels: _ydata,
      series: _xdata,
      colors: [config.colors.primary, config.colors.secondary, config.colors.info, config.colors.success, config.colors.primary, config.colors.secondary, config.colors.info],
      stroke: {
        width: 7,
      },
      dataLabels: {
        enabled: false,
        formatter: function (val, opt) {
          return parseInt(val) + '%';
        }
      },
      legend: {
        show: false
      },
      grid: {
        padding: {
          top: 0,
          bottom: 0,
          right: 15
        }
      },
      plotOptions: {
        pie: {
          donut: {
            size: '70%',
            labels: {
              show: true,
              value: {
                fontSize: '1.5rem',
                fontFamily: 'Public Sans',
                offsetY: -15,
                formatter: function (val) {
                  var was=((val)/_qdata)*100;
                  console.log(was);
                  return (was.toFixed(2)) + '%';
                }
              },
              name: {
                offsetY: 20,
                fontFamily: 'Public Sans'
              },
              total: {
                show: true,
                fontSize: '0.8125rem',
                label: '7 ngày',
                formatter: function (w) {
                  return _zdata.toFixed(2) + '%';;
                }
              }
            }
          }
        }
      }
    };
        var chart = new ApexCharts(document.querySelector("#orderStatisticsChart"), options);
        chart.render();
      });
    </script>
</body>

</html>

