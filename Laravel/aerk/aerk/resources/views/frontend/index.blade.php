
@extends('master')

@section('title', 'Home Page')

@section('content')

<div>
    <!--Body Content-->
    @if(count($banners) > 0)
    <div id="page-content">
    	<!--Home slider-->
        <div class="slideshow slideshow-wrapper pb-section sliderFull">
            <div class="home-slideshow">
                @foreach($banners as $key => $banner)
                @if($banner->status == 'active')
                    <div class="slide">
                        <div class="blur-up lazyload bg-size">
                            @if($banner->hasMedia('banners'))
                                <img class="blur-up lazyload bg-img"  data-src="{{ $banner->getFirstMediaUrl('banners') }}" src="{{ $banner->getFirstMediaUrl('banners') }}" alt="{{ $banner->title }}" title="{{ $banner->title }}" />
                            @else
                                <p>No banner image available.</p>
                            @endif
                            <div class="slideshow__text-wrap slideshow__overlay classic {{ $banner->position }}">
                                <div class="slideshow__text-content {{ $banner->position }}">
                                    <div class="container">
                                        <div class="wrap-caption middle">
                                            <h2 class="h1 mega-title slideshow__title">{{ $banner->title }}</h2>
                                            <span class="mega-subtitle slideshow__subtitle">{!! html_entity_decode($banner->description) !!}</span>
                                            <span class="btn">Shop now</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
        @endif
        <!--End Home slider-->
        <!--Weekly Bestseller-->
       <x-weekly-best-seller/>
        </div>
        <!--Weekly Bestseller-->
        <!--Parallax Section-->
        <div class="section">
            <div class="hero hero--large hero__overlay bg-size">
            	<img class="bg-img" src="assets/images/parallax-banners/parallax-banner.jpg" alt="" />
                <div class="hero__inner">
                    <div class="container">
                        <div class="wrap-text left text-small font-bold">
                            <h2 class="h2 mega-title">Belle <br> The best choice for your store</h2>
                            <div class="rte-setting mega-subtitle">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</div>
                            <a href="#" class="btn">Purchase Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End Parallax Section-->
        <!--New Arrivals-->
       <x-new-arrivals/>
        <!--End Featured Product-->

        <!--Logo Slider-->
        <div class="section logo-section">
        	<div class="container">
            	<div class="row">
                	<div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    	<div class="section-header text-center">
                        	<h2 class="h2">The Most Loved Brands</h2>
                    	</div>
                		<div class="logo-bar">
                            <div class="logo-bar__item">
                                <img src="assets/images/logo/brandlogo1.png" alt="" title="" />
                            </div>
                            <div class="logo-bar__item">
                                <img src="assets/images/logo/brandlogo2.png" alt="" title="" />
                            </div>
                            <div class="logo-bar__item">
                                <img src="assets/images/logo/brandlogo3.png" alt="" title="" />
                            </div>
                            <div class="logo-bar__item">
                                <img src="assets/images/logo/brandlogo4.png" alt="" title="" />
                            </div>
                            <div class="logo-bar__item">
                                <img src="assets/images/logo/brandlogo5.png" alt="" title="" />
                            </div>
                            <div class="logo-bar__item">
                                <img src="assets/images/logo/brandlogo6.png" alt="" title="" />
                            </div>
               			 </div>
                	</div>
                </div>
            </div>
        </div>
        <!--End Logo Slider-->
    </div>
<x-quick-view/>
@endsection
