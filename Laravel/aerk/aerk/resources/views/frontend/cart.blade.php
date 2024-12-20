@extends('master')

@section('title', 'Aerk | Cart')

@section('content')
<main class="main">
    <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">Shopping Cart<span>Shop</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

@if ($cart->items)
<div class="page-content">
    <div class="cart">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <table class="table table-cart table-mobile">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                @foreach ($cart->items as $item)
                            <tr>
                                <td class="product-col">
                                    <div class="product">
                                        <figure class="product-media">
                                            <a href="#">
                                                <img src="{{ $item['item']->getMedia('product-images')->first()->getUrl() }}" alt="{{ $item['item']->name }}">
                                            </a>
                                        </figure>
                                        <h3 class="product-title">
                                            <a href="#">{{ $item['item']->name }}</a>
                                        </h3><!-- End .product-title -->
                                    </div><!-- End .product -->
                                </td>
                                <td class="price-col">${{ $item['item']->price }}</td>
                                <td class="quantity-col">
                                
                                    <div class="cart-product-quantity">
                                        <div class="input-group  input-spinner">
                                           <div class="input-group-prepend">
                                              <button style="min-width: 26px" class="btn btn-decrement btn-spinner" type="button" data-product-id="{{ $item['item']->id }}">
                                                <i class="icon-minus"></i>
                                               </button>
                                            </div>
                                            <input type="text" style="text-align: center" class="form-control quantity-input"  value="{{ $item['qty'] }}" min="1" max="10" step="1" data-id="{{ $item['item']->id }}" data-price="{{ $item['item']->price }}" required>
                                                <div class="input-group-append">
                                                    <button style="min-width: 26px" class="btn btn-increment btn-spinner" type="button" data-product-id="{{ $item['item']->id }}"><i class="icon-plus"></i></button>
                                                </div>
                                            </div>
                                            
                                    </div>
                                </td>
                                <td class="total-col" id="item-total-{{ $item['item']->id }}">${{ $item['price'] }}</td>
                                <td class="remove-col"><a href="{{ route('cart.removeItem', $item['item']->id) }}" class="btn-remove"><i class="icon-close"></i></a></td>
                            </tr>
                @endforeach
                        </tbody>
                    </table><!-- End .table table-cart -->

                    <div class="cart-bottom">
                        <div class="cart-discount">
                            <form action="#">
                                <div class="input-group">
                                    <input type="text" class="form-control" required placeholder="coupon code">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-primary-2" type="submit"><i class="icon-long-arrow-right"></i></button>
                                    </div><!-- .End .input-group-append -->
                                </div><!-- End .input-group -->
                            </form>
                        </div><!-- End .cart-discount -->

                        <a href="#" class="btn btn-outline-dark-2"><span>UPDATE CART</span><i class="icon-refresh"></i></a>
                    </div><!-- End .cart-bottom -->
                </div><!-- End .col-lg-9 -->
                <aside class="col-lg-3">
                    <div class="summary summary-cart">
                        <h3 class="summary-title">Cart Total</h3><!-- End .summary-title -->

                        <table class="table table-summary">
                            <tbody>
                                <tr class="summary-subtotal">
                                    <td>Subtotal:</td>
                                    <td id="cart-sub-total">${{ $cart->totalPrice }}</td>
                                </tr><!-- End .summary-subtotal -->
                                <tr class="summary-shipping">
                                    <td>Shipping:</td>
                                    <td>&nbsp;</td>
                                </tr>

                                <tr class="summary-shipping-row">
                                    <td>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="free-shipping" name="shipping" class="custom-control-input">
                                            <label class="custom-control-label" for="free-shipping">Free Shipping</label>
                                        </div><!-- End .custom-control -->
                                    </td>
                                    <td>$0.00</td>
                                </tr><!-- End .summary-shipping-row -->

                                <tr class="summary-shipping-row">
                                    <td>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="standard-shipping" name="shipping" class="custom-control-input">
                                            <label class="custom-control-label" for="standard-shipping">Standard:</label>
                                        </div><!-- End .custom-control -->
                                    </td>
                                    <td>$10.00</td>
                                </tr><!-- End .summary-shipping-row -->

                                <tr class="summary-shipping-row">
                                    <td>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="express-shipping" name="shipping" class="custom-control-input">
                                            <label class="custom-control-label" for="express-shipping">Express:</label>
                                        </div><!-- End .custom-control -->
                                    </td>
                                    <td>$20.00</td>
                                </tr><!-- End .summary-shipping-row -->

                                <tr class="summary-shipping-estimate">
                                    <td>Estimate for Your Country<br> <a href="dashboard.html">Change address</a></td>
                                    <td>&nbsp;</td>
                                </tr><!-- End .summary-shipping-estimate -->

                                <tr class="summary-total">
                                    <td>Total:</td>
                                    <td id="cart-total">${{ $cart->totalPrice }}</td>
                                </tr><!-- End .summary-total -->
                            </tbody>
                        </table><!-- End .table table-summary -->

                        <a href="checkout.html" class="btn btn-outline-primary-2 btn-order btn-block">PROCEED TO CHECKOUT</a>
                    </div><!-- End .summary -->

                    <a href="category.html" class="btn btn-outline-dark-2 btn-block mb-3"><span>CONTINUE SHOPPING</span><i class="icon-refresh"></i></a>
                </aside><!-- End .col-lg-3 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .cart -->
</div><!-- End .page-content -->
@else
<p>Your cart is empty.</p>
@endif
</main><!-- End .main -->
@endsection

@section('scripts')
<!-- JavaScript code to handle adding items to the cart using AJAX -->
<script>
    // Function to update item total and cart total
    function updateTotals(input) {
        const productId = input.data('id');
        const itemPrice = parseFloat(input.data('price'));
        const quantity = parseInt(input.val());
        const itemTotalElement = $(`#item-total-${productId}`);
        const cartSubTotalElement = $('#cart-sub-total');
        const itemTotal = itemPrice * quantity;
        const cartTotalElement = $('#cart-total');
        itemTotalElement.text(`$${itemTotal.toFixed(2)}`);
        
        
        // Update cart total
        let cartSubTotal = 0;
        $('.quantity-input').each(function() {
            const itemPrice = parseFloat($(this).data('price'));
            const quantity = parseInt($(this).val());
            cartSubTotal += itemPrice * quantity;
        });
        cartSubTotalElement.text(`$${cartSubTotal.toFixed(2)}`);
        let cartTotal = 0;
        if (cartSubTotal > 0) {
            cartTotal = cartSubTotal;
        }
        cartTotalElement.text(`$${cartTotal.toFixed(2)}`);


    }
      
    // Increment button click event
    $('.btn-increment').click(function(e) {
        e.preventDefault();
        const input = $(this).closest('.input-spinner').find('.quantity-input');
        input.val(parseInt(input.val()) + 1);
        updateTotals(input);
        
        const productId = $(this).data('product-id');
        $.ajax({
            type: 'GET',
            url: '/cart/add/' + productId,
            success: function(response) {
                console.log("Item added to cart.");
            },
            error: function(xhr, status, error) {
                console.error("Error adding item to cart:", error);
            }
        });
    });

    // Decrement button click event
    $('.btn-decrement').click(function(e) {
        e.preventDefault();
        const input = $(this).closest('.input-spinner').find('.quantity-input');
        if (parseInt(input.val()) > input.attr('min')) {
            input.val(parseInt(input.val()) - 1);
            updateTotals(input);

            const productId = $(this).data('product-id');
            $.ajax({
                type: 'GET',
                url: '/cart/remove/' + productId,
                success: function(response) {
                    console.log("Item removed from cart.");
                },
                error: function(xhr, status, error) {
                    console.error("Error removing item from cart:", error);
                }
            });
        }
    });
</script>

@endsection
