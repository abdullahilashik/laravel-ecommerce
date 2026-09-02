<div class="modal fade custom-modal" id="quickViewModal" tabindex="-1" aria-labelledby="quickViewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12 mb-md-0 mb-sm-5">
                        <div class="detail-gallery">
                            <span class="zoom-icon"><i class="fi-rs-search"></i></span>
                            <div class="product-image-slider" id="qv-images">
                            </div>
                            <div class="slider-nav-thumbnails" id="qv-thumbnails">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="detail-info pr-30 pl-30">
                            <span class="stock-status out-stock" id="qv-badge" style="display:none"></span>
                            <h3 class="title-detail"><a href="#" class="text-heading" id="qv-name">-</a></h3>
                            <div class="product-detail-rating">
                                <div class="product-rate-cover text-end">
                                    <div class="product-rate d-inline-block">
                                        <div class="product-rating" id="qv-rating-bar" style="width: 0%"></div>
                                    </div>
                                    <span class="font-small ml-5 text-muted" id="qv-reviews"> (0 reviews)</span>
                                </div>
                            </div>
                            <div class="clearfix product-price-cover">
                                <div class="product-price primary-color float-left">
                                    <span class="current-price text-brand" id="qv-price">$0</span>
                                    <span id="qv-discount-wrap" style="display:none">
                                        <span class="save-price font-md color3 ml-15" id="qv-discount-pct"></span>
                                        <span class="old-price font-md ml-15" id="qv-old-price"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="detail-extralink mb-30">
                                <div class="detail-qty border radius">
                                    <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                    <span class="qty-val">1</span>
                                    <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                </div>
                                <div class="product-extra-link2">
                                    <form id="qv-cart-form" method="POST" data-cart-add>
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="button button-add-to-cart"><i class="fi-rs-shopping-cart"></i>Add to cart</button>
                                    </form>
                                </div>
                            </div>
                            <div class="font-xs">
                                <ul>
                                    <li class="mb-5">Vendor: <span class="text-brand" id="qv-vendor">-</span></li>
                                    <li class="mb-5">SKU: <span class="text-brand" id="qv-sku">-</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
