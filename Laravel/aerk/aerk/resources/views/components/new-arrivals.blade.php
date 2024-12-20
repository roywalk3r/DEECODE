<div class="product-rows section">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <div class="section-header text-center">
                    <h2 class="h2">New Arrivals</h2>
                    <p>Grab these new items before they are gone!</p>
                </div>
            </div>
        </div>
        <div class="grid-products">
            <div class="row">
                @if ($products->isEmpty())
                <p>No products found.</p>
            @else
                @foreach ($products as $product)
                <div class="col-6 col-sm-2 col-md-3 col-lg-3 item">
                    <!-- start product image -->
                    <div class="product-image">
                        <!-- start product image -->
                        <a href="{{ url('product.show', $product->slug) }}" class="grid-view-item__link">
                            <!-- image -->
                            @if ($product->hasMedia('product-images') && $product->getMedia('product-images')->isNotEmpty())
                                <img class="primary blur-up lazyload" data-src="{{ $product->getMedia('product-images')->first()->getUrl() }}" src="{{ $product->getMedia('product-images')->first()->getUrl() }}" alt="image" title="product">
                            @endif
                            <!-- End image -->
                            <!-- Hover image -->
                            @if ($product->hasMedia('product-images') && $product->getMedia('product-images')->count() >= 2)
                                <img class="hover blur-up lazyload" data-src="{{ $product->getMedia('product-images')[1]->getUrl() }}" src="{{ $product->getMedia('product-images')[1]->getUrl() }}" alt="image" title="product">
                            @endif
                            <!-- End hover image -->
                            <!-- Variant Image-->
                            @if ($product->hasMedia('product-images') && $product->getMedia('product-images')->isNotEmpty())
                                <img class="grid-view-item__image hover variantImg" src="{{ $product->getMedia('product-images')->first()->getUrl() }}" alt="image" title="product">
                            @endif
                            <!-- Variant Image-->
                            <!-- product label -->
                            <div class="product-labels rounded">
                                @foreach ($product->salesTags as $tag)
                                    @if ($tag->name == 'Sale')
                                        <span class="lbl on-sale">{{ $tag->name }}</span>
                                    @elseif ($tag->name == 'New')
                                        <span class="lbl pr-label1">{{ $tag->name }}</span>
                                    @elseif ($tag->name == 'Hot')
                                        <span class="lbl pr-label2">{{ $tag->name }}</span>
                                    @endif
                                @endforeach
                            </div>
                            <!-- End product label -->
                        </a>
                        @if ($product->expires_at)
                            <div class="saleTime desktop" data-countdown="{{ $product->expires_at }}"></div>
                        @endif
                        <!-- end product image -->
    
                        <!-- Start product button -->
                        <form class="variants add" action="{{ url('cart.add', $product->id) }}" method="post">
                            @csrf
                            <button class="btn btn-addto-cart" type="submit" tabindex="0">Add To Cart</button>
                        </form>
                        <div class="button-set">
                            <a href="javascript:void(0)" title="Quick View" class="quick-view-popup quick-view" data-toggle="modal" data-target="#content_quickview_{{ $product->id }}" 
                            data-product-id="#{{ $product->id }}" 
                            >
                                <i class="icon anm anm-search-plus-r"></i>
                            </a>
                            <div class="wishlist-btn">
                                <a class="wishlist add-to-wishlist" href="{{ url('wishlist.add', $product->id) }}">
                                    <i class="icon anm anm-heart-l"></i>
                                </a>
                            </div>
                            <div class="compare-btn">
                                <a class="compare add-to-compare" href="{{ url('compare.add', $product->id) }}" title="Add to Compare">
                                    <i class="icon anm anm-random-r"></i>
                                </a>
                            </div>
                        </div>
                        <!-- end product button -->
                    </div>
                    <!-- end product image -->
                    <!--start product details -->
                    <div class="product-details text-center">
                        <!-- product name -->
                        <div class="product-name">
                            <a href="product-layout-1.html">{{$product->name }}</a>
                        </div>
                        <!-- End product name -->
                        <!-- product price -->
                        <div class="product-price">
                            <span class="old-price">{{ $product->old_price }}</span>
                            <span class="price">{{ $product->price }}</span>
                        </div>
                        <!-- End product price -->
                        <!-- Color Variant -->
                        <ul class="swatches">
                            <li class="swatch small rounded navy" rel="assets/images/product-images/product-image-stw1.jpg"></li>
                            <li class="swatch small rounded green" rel="assets/images/product-images/product-image-stw1-1.jpg"></li>
                            <li class="swatch small rounded gray" rel="assets/images/product-images/product-image-stw1-2.jpg"></li>
                            <li class="swatch small rounded aqua" rel="assets/images/product-images/product-image-stw1-3.jpg"></li>
                            <li class="swatch small rounded orange" rel="assets/images/product-images/product-image-stw1-4.jpg"></li>
                        </ul>
                        <!-- End Variant -->
                    </div>
                    <!-- End product details -->
                </div>
                @endforeach
                @endif 
            </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 text-center">
                    <a href="{{ route('all-products') }}" class="btn">View all</a>
                </div>
            </div>
        </div>
   </div>
</div>	