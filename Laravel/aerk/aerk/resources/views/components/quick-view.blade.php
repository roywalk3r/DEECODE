
  <div>
      @if ($products->isEmpty())
      <p>No products found.</p>
  @else
      @foreach ($products as $product)
  <div class="modal fade quick-view-popup content_quickview" id="content_quickview_{{ $product->id }}">
    	<div class="modal-dialog">
        	<div class="modal-content">
            	<div class="modal-body">
                    <div id="ProductSection-product-template" class="product-template__container prstyle1">
                <div class="product-single">
                <!-- Start model close -->
                <a href="javascript:void()" data-dismiss="modal" class="model-close-btn pull-right" title="close"><span class="icon icon anm anm-times-l"></span></a>
                <!-- End model close -->
                 <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="product-details-img">
                            @if ($product->hasMedia('product-images') && $product->getMedia('product-images')->isNotEmpty())
                            <div class="pl-20">
                                <img src="{{ $product->getMedia('product-images')->first()->getUrl() }}" alt="{{ $product->name }}" />
                            </div>
                        @endif
                        </div>
                    </div>
                     <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="product-single__meta">
                                <h2 class="product-single__title">{{ $product->name }}</h2>
                                <div class="prInfoRow">
                                    <div class="product-stock">
                                        @if ($product->qty > 0)
                                            <span class="instock">In Stock ({{ $product->qty }})</span>
                                        @else
                                            <span class="outstock">Unavailable</span>
                                        @endif
                                    </div>
                                    <div class="product-sku">SKU: <span class="variant-sku">{{ $product->sku }}</span></div>
                                </div>
                                <p class="product-single__price product-single__price-product-template">
                                    <span class="visually-hidden">Regular price</span>
                                    <s id="ComparePrice-product-template"><span class="money">{{ $product->old_price }}</span></s>
                                    <span class="product-price__price product-price__price-product-template product-price__sale product-price__sale--single">
                                        <span id="ProductPrice-product-template"><span class="money">{{ $product->price }}</span></span>
                                    </span>
                                </p>
                                <div class="product-single__description rte">
                                   {{$product->description}}
                                </div>
                                
                            <form method="post" action="http://annimexweb.com/cart/add" id="product_form_10508262282" accept-charset="UTF-8" class="product-form product-form-product-template hidedropdown" enctype="multipart/form-data">
                                <div class="swatch clearfix swatch-0 option1" data-option-index="0">
                                    <div class="product-form__item">
                                      <label class="header">Color: <span class="slVariant">Red</span></label>
                                      <div data-value="Red" class="swatch-element color red available">
                                        <input class="swatchInput" id="swatch-0-red" type="radio" name="option-0" value="Red">
                                        <label class="swatchLbl color medium rectangle" for="swatch-0-red" style="background-image:url(assets/images/product-detail-page/variant1-1.jpg);" title="Red"></label>
                                      </div>
                                      <div data-value="Blue" class="swatch-element color blue available">
                                        <input class="swatchInput" id="swatch-0-blue" type="radio" name="option-0" value="Blue">
                                        <label class="swatchLbl color medium rectangle" for="swatch-0-blue" style="background-image:url(assets/images/product-detail-page/variant1-2.jpg);" title="Blue"></label>
                                      </div>
                                      <div data-value="Green" class="swatch-element color green available">
                                        <input class="swatchInput" id="swatch-0-green" type="radio" name="option-0" value="Green">
                                        <label class="swatchLbl color medium rectangle" for="swatch-0-green" style="background-image:url(assets/images/product-detail-page/variant1-3.jpg);" title="Green"></label>
                                      </div>
                                      <div data-value="Gray" class="swatch-element color gray available">
                                        <input class="swatchInput" id="swatch-0-gray" type="radio" name="option-0" value="Gray">
                                        <label class="swatchLbl color medium rectangle" for="swatch-0-gray" style="background-image:url(assets/images/product-detail-page/variant1-4.jpg);" title="Gray"></label>
                                      </div>
                                    </div>
                                </div>
                                <div class="swatch clearfix swatch-1 option2" data-option-index="1">
                                    <div class="product-form__item">
                                      <label class="header">Size: <span class="slVariant">XS</span></label>
                                      <div data-value="XS" class="swatch-element xs available">
                                        <input class="swatchInput" id="swatch-1-xs" type="radio" name="option-1" value="XS">
                                        <label class="swatchLbl medium rectangle" for="swatch-1-xs" title="XS">XS</label>
                                      </div>
                                      <div data-value="S" class="swatch-element s available">
                                        <input class="swatchInput" id="swatch-1-s" type="radio" name="option-1" value="S">
                                        <label class="swatchLbl medium rectangle" for="swatch-1-s" title="S">S</label>
                                      </div>
                                      <div data-value="M" class="swatch-element m available">
                                        <input class="swatchInput" id="swatch-1-m" type="radio" name="option-1" value="M">
                                        <label class="swatchLbl medium rectangle" for="swatch-1-m" title="M">M</label>
                                      </div>
                                      <div data-value="L" class="swatch-element l available">
                                        <input class="swatchInput" id="swatch-1-l" type="radio" name="option-1" value="L">
                                        <label class="swatchLbl medium rectangle" for="swatch-1-l" title="L">L</label>
                                      </div>
                                    </div>
                                </div>
                                <!-- Product Action -->
                                <div class="product-action clearfix">
                                    <div class="product-form__item--quantity">
                                        <div class="wrapQtyBtn">
                                            <div class="qtyField">
                                                <a class="qtyBtn minus cart__add_minus" href="{{ route('cart.remove', ['id'=> $product->id]) }}"
                                                data-product-id="{{ $product->id }}"
                                                ><i class="fa anm anm-minus-r" aria-hidden="true"></i></a>
                                                <input type="text" id="Quantity" name="quantity" value="1" class="product-form__input qty">
                                                <a class="qtyBtn plus" href="{{ route('cart.add', ['id'=> $product->id]) }}"
                                                data-product-id="{{ $product->id }}"
                                                ><i class="fa anm anm-plus-r" aria-hidden="true"></i></a>
                                            </div>
                                        </div>
                                    </div>                                
                                    <div class="product-form__item--submit add_to_cart">
                                        <a href="{{ route('cart.add', ['id'=> $product->id]) }}" data-product-id="{{ $product->id }}" class="cart__add">
                                            <button type="button" name="add" class="btn product-form__cart-submit ">
                                                <span>Add to cart</span>
                                            </button>
                                        </a>
                                    </div>
                                    <div class="product-form__item--submit remove_from_cart">
                                        <a href="{{ route('cart.remove', ['id'=> $product->id]) }}" data-product-id="{{ $product->id }}" class="cart__add">
                                            <button type="button" name="add" class="btn product-form__cart-submit ">
                                                <span>Remove from cart</span>
                                            </button>
                                        </a>
                                    </div>
                                </div>
                                <!-- End Product Action -->
                            </form>
                            <div class="display-table shareRow">
                                <div class="display-table-cell">
                                    <div class="wishlist-btn">
                                        <a class="wishlist add-to-wishlist" href="#" title="Add to Wishlist"><i class="icon anm anm-heart-l" aria-hidden="true"></i> <span>Add to Wishlist</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div> 
 

            </div>
                <!--End-product-single-->
                </div>
            </div>
        		</div>
        	</div>
        </div>
    </div> 
    @endforeach
    @endif
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
        $('.quick-view-popup').on('click', function() {
            var productId = $(this).data('product-id');
            $('#content_quickview_' + productId).modal('show');
            var clickedProductId = productId;
        });

        //Show and hide qty field
        function showAddToCart() {
            $('.qtyField').hide();
            $('.remove_from_cart').hide();
            $('.add_to_cart').show();
        }
        showAddToCart();
        function hidAddToCart() {
            $('.qtyField').show();
            $('.remove_from_cart').show();
            $('.add_to_cart').hide();
        }
         //Add items to cart
        $('.cart__add').click(function(e) {
            e.preventDefault();
 
             const productID = $(this).data('product-id');
            console.log("#id", productID);
            const url = `/cart/add/${productID}`; 
            $.ajax({
                type: 'GET',
                url: url,
                success: function(response) {
                    console.log("Item added to cart.");
                    hidAddToCart();

                },
                error: function(xhr, status, error) {
                    console.error("Error adding item to cart:", error);
                }
            });
        });

        $('.cart__add_plus').click(function(e) {
            e.preventDefault();
 
             const productID = $(this).data('product-id');
            console.log("#id", productID);
            const url = `/cart/add/${productID}`; 
            $.ajax({
                type: 'GET',
                url: url,
                success: function(response) {
                    console.log("cart updated succesfully.");
                    hidAddToCart();

                },
                error: function(xhr, status, error) {
                    console.error("Error adding item to cart:", error);
                }
            });
        });

        $('.cart__add_minus').click(function(e) {
            e.preventDefault();
 
             const productID = $(this).data('product-id');
            console.log("#id", productID);
            const url = `/cart/remove/${productID}`; 
            $.ajax({
                type: 'GET',
                url: url,
                success: function(response) {
                    console.log("cart updated succesfully.");
                    hidAddToCart();

                },
                error: function(xhr, status, error) {
                    console.error("Error updating cart:", error);
                }
            });
        });
    });

</script>
