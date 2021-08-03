<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Restautants') }}</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="{{asset('/admin/css/backend.css')}}" rel="stylesheet" type="text/css">
  @yield('css')
	<!-- /global stylesheets -->
  <style type="text/css">
    .sidebar-mobile-main .sidebar-main{z-index: 9999;}
    span.invalid-feedback {
        color: #ed1922;
    }
  </style>
</head>

<body>
  @include('admin.layouts.header')
  <!-- Page content -->
  <div class="page-content">
    @include('admin.layouts.sidebar')
    <!-- Main content -->
	  <div class="content-wrapper">
      <!-- Page header -->
      <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
          <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Home</span> - {{trans('local.header_title.'.request()->segment(2))}}</h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
          </div>
        </div>
      </div>
      <!-- /page header -->
      <!-- Content area -->
		  <div class="content">
        <div class="ajax-loader">
          @yield('content')
        </div>
      </div>
      <!-- Footer -->
      <div class="navbar navbar-expand-lg navbar-light">
        <div class="text-center d-lg-none w-100">
          <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-footer">
            <i class="icon-unfold mr-2"></i>
            Footer
          </button>
        </div>

        <div class="navbar-collapse collapse" id="navbar-footer">
          <span class="navbar-text">
            &copy; {{date('Y')}}. <a href="#">{{ config('app.name', 'Restautant') }}</a>
          </span>
        </div>
      </div>
      <!-- /footer -->
    </div>
  </div>
    
  <script src="{{ asset('/admin/js/backend.js') }}"></script>
  @include('flash::message')
  @yield('js')
  <script type="text/javascript">
    var block = $('.ajax-loader');
    /*$(block).block({ 
        message: '<i class="icon-spinner4 spinner"></i>',
        timeout: 2000, //unblock after 2 seconds
        overlayCSS: {
            backgroundColor: '#fff',
            opacity: 0.8,
            cursor: 'wait'
        },
        css: {
            border: 0,
            padding: 0,
            backgroundColor: 'transparent'
        }
    });*/
    jQuery(document).ready(function(){
      showAjaxLoader();
    });
    jQuery(window).on("load",function(){
      hideAjaxLoader();
    });
    function showAjaxLoader(){
        // $(block).block({ 
        //     message: '<i class="icon-spinner4 spinner"></i>',
        //     overlayCSS: {
        //         backgroundColor: '#fff',
        //         opacity: 0.8,
        //         cursor: 'wait'
        //     },
        //     css: {
        //         width: 16,
        //         border: 0,
        //         padding: 0,
        //         backgroundColor: 'transparent'
        //     }
        // });
    }
    function hideAjaxLoader(){
       //$(block).unblock();
    }
  </script>
</body>

</html>