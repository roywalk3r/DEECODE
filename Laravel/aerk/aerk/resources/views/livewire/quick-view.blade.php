<div class="modal fade quick-view-popup" id="content_quickview">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div id="ProductSection-product-template" class="product-template__container prstyle1">
                    <div class="product-single">
                        <!-- Start model close -->
                        <a href="javascript:void()" wire:click="$emit('closeQuickView')" class="model-close-btn pull-right" title="close">
                            <span class="icon icon anm anm-times-l"></span>
                        </a>
                        <!-- End model close -->
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="product-details-img">
                                    <div class="pl-20">
                                        <!-- Display product image here -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="product-single__meta">
                                    <h2 class="product-single__title">{{ $product->name }}</h2>
                                    <p class="product-single__description rte">{{ $product->description }}</p>
                                    <p class="product-single__price product-single__price-product-template">{{ $product->price }}</p>
                                    <!-- Other product details -->
                                </div>
                                <!-- Product Action -->
                                <!-- Add to cart form and other actions -->
                            </div>
                        </div>
                    </div>
                    <!--End-product-single-->
                </div>
            </div>
        </div>
    </div>
</div>
