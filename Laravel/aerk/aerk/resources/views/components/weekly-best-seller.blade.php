<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <div class="section-header text-center">
                    <h2 class="h2">Weekly Bestseller</h2>
                    <p>Our most popular products based on sales</p>
                </div>
                <div class="productSlider grid-products">
                    @if ($products->isEmpty())
                    <p>No products found.</p>
                @else
                    @foreach ($products as $product)
                        <div class="col-12 item">
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
                                    <a href="{{ url('product.show', $product->slug) }}">{{ $product->name }}</a>
                                </div>
                                <!-- End product name -->
                                <!-- product price -->
                                <div class="product-price">
                                    @if ($product->old_price)
                                        <span class="old-price">${{ $product->old_price }}</span>
                                    @endif
                                    <span class="price">${{ $product->price }}</span>
                                </div>
                                <!-- End product price -->
                            </div>
                            <!-- End product details -->
                        </div>
                    @endforeach
                @endif
             
                </div>
            </div>
        </div>
    </div>    
</div>

<script>
    $(document).ready(function() {
        $('.quick-view-popup').on('click', function() {
            var productId = $(this).data('id');
            console.log(productId,"gdgddh")
            $.ajax({
                url: '/quick-view/' + productId,
                method: 'GET',
                success: function(response) {
                    $('#quick-view-content').html(response);
                },
                error: function() {
                    alert('Error loading product details');
                }
            });
        });
    });
    </script>
    