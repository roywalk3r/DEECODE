<!DOCTYPE html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="x-ua-compatible" content="ie=edge">
<title>@yield('title')</title>
<meta name="description" content="description">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Favicon -->
<link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />
<!-- Plugins CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/plugins.css') }}">
<!-- Bootstap CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
<!-- Main Style CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
<link rel="stylesheet" href="{{asset('headerasset/assets/css/style.css')}}">
<link rel="preconnect" href="https://fonts.google.com">
   @livewireStyles
   @livewireScripts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="template-index belle template-index-belle">
<div id="pre-loader">
    <img src="assets/images/loader.gif" alt="Loading..." />
</div>
<div class="pageWrapper">
    <!--Search Form Drawer-->
    <div class="search">
        <div class="search__form">
            <form class="search-bar__form" action="#">
                <button class="go-btn search__button" type="submit"><i class="icon anm anm-search-l"></i></button>
                <input class="search__input" type="search" name="q" value="" placeholder="Search entire store..." aria-label="Search" autocomplete="off">
            </form>
            <button type="button" class="search-trigger close-btn"><i class="anm anm-times-l"></i></button>
        </div>
    </div>
    <!--End Search Form Drawer-->
        @include('partials.header')
    <div class="pageWrapper">
        @yield('content')
    </div>
        @include('partials.footer')
    <x-scroll-to-top-btn/>
    <x-news-letter-pop/>
     <!-- Including Jquery -->
     <script src="{{asset('assets/js/vendor/jquery-3.3.1.min.js')}}"></script>
     <script src="{{asset('assets/js/vendor/modernizr-3.6.0.min.js')}}"></script>
     <script src="{{asset('assets/js/vendor/jquery.cookie.js')}}"></script>
     <script src="{{asset('assets/js/vendor/wow.min.js')}}"></script>
     <!-- Including Javascript -->
     <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
     <script src="{{asset('assets/js/plugins.js')}}"></script>
     <script src="{{asset('assets/js/popper.min.js')}}"></script>
     <script src="{{asset('assets/js/lazysizes.js')}}"></script>
     <script src="{{asset('assets/js/main.js')}}"></script>

   <!-- Other Js -->
  @yield('scripts')
<!--For Newsletter Popup-->
<script>

    jQuery('.quick-view-popup').on('click', function() {
            var productId = $(this).data('product-id');
            jQuery('#content_quickview_' + productId).modal('show');
            // Set the clicked product ID to be used in Blade template
            var clickedProductId = productId;
        });

		jQuery(document).ready(function(){
		  jQuery('.closepopup').on('click', function () {
			  jQuery('#popup-container').fadeOut();
			  jQuery('#modalOverly').fadeOut();
		  });

		  var visits = jQuery.cookie('visits') || 0;
		  visits++;
		  jQuery.cookie('visits', visits, { expires: 1, path: '/' });
		  console.debug(jQuery.cookie('visits'));
		  if ( jQuery.cookie('visits') > 1 ) {
			jQuery('#modalOverly').hide();
			jQuery('#popup-container').hide();
		  } else {
			  var pageHeight = jQuery(document).height();
			  jQuery('<div id="modalOverly"></div>').insertBefore('body');
			  jQuery('#modalOverly').css("height", pageHeight);
			  jQuery('#popup-container').show();
		  }
		  if (jQuery.cookie('noShowWelcome')) { jQuery('#popup-container').hide(); jQuery('#active-popup').hide(); }
		});

		jQuery(document).mouseup(function(e){
		  var container = jQuery('#popup-container');
		  if( !container.is(e.target)&& container.has(e.target).length === 0)
		  {
			container.fadeOut();
			jQuery('#modalOverly').fadeIn(200);
			jQuery('#modalOverly').hide();
		  }
		});

		/*--------------------------------------
			Promotion / Notification Cookie Bar
		  -------------------------------------- */
		  if(Cookies.get('promotion') != 'true') {
			 $(".notification-bar").show();
		  }
		  $(".close-announcement").on('click',function() {
			$(".notification-bar").slideUp();
			Cookies.set('promotion', 'true', { expires: 1});
			return false;
		  });
</script>
</body>
</html>
