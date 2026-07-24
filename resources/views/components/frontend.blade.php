<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <title>Nest - Multipurpose eCommerce HTML Template</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:title" content="" />
    <meta property="og:type" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/imgs/theme/favicon.svg" />
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/animate.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/main.css?v=6.0') }}" />
</head>

<body>
    <!-- Modal -->
    <div class="modal fade custom-modal" id="onloadModal" tabindex="-1" aria-labelledby="onloadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="deal" style="background-image: url('assets/imgs/banner/popup-1.png')">
                        <div class="deal-top">
                            <h6 class="mb-10 text-brand-2">Deal of the Day</h6>
                        </div>
                        <div class="deal-content detail-info">
                            <h4 class="product-title"><a href="shop-product-right.html" class="text-heading">Organic fruit for your family's health</a></h4>
                            <div class="clearfix product-price-cover">
                                <div class="product-price primary-color float-left">
                                    <span class="current-price text-brand">$38</span>
                                    <span>
                                        <span class="save-price font-md color3 ml-15">26% Off</span>
                                        <span class="old-price font-md ml-15">$52</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="deal-bottom">
                            <p class="mb-20">Hurry Up! Offer End In:</p>
                            <div class="deals-countdown pl-5" data-countdown="2025/03/25 00:00:00">
                                <span class="countdown-section"><span class="countdown-amount hover-up">03</span><span class="countdown-period"> days </span></span><span class="countdown-section"><span class="countdown-amount hover-up">02</span><span class="countdown-period"> hours </span></span><span class="countdown-section"><span class="countdown-amount hover-up">43</span><span class="countdown-period"> mins </span></span><span class="countdown-section"><span class="countdown-amount hover-up">29</span><span class="countdown-period"> sec </span></span>
                            </div>
                            <div class="product-detail-rating">
                                <div class="product-rate-cover text-end">
                                    <div class="product-rate d-inline-block">
                                        <div class="product-rating" style="width: 90%"></div>
                                    </div>
                                    <span class="font-small ml-5 text-muted"> (32 rates)</span>
                                </div>
                            </div>
                            <a href="shop-grid-right.html" class="btn hover-up">Shop Now <i class="fi-rs-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Quick view -->
    <x-frontend.quickview />
    <x-frontend.header />
    <!--End header-->
    <main class="main">
        {{ $slot }}
    </main>
    <x-footer />
    <!-- Preloader Start -->
    {{-- <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="text-center">
                    <img src="assets/imgs/theme/loading.gif" alt="" />
                </div>
            </div>
        </div>
    </div> --}}
    <!-- Vendor JS-->
    <script src={{ asset('assets/js/vendor/modernizr-3.6.0.min.js') }}></script>
    <script src={{ asset('assets/js/vendor/jquery-3.6.0.min.js') }}></script>
    <script src={{ asset('assets/js/vendor/jquery-migrate-3.3.0.min.js') }}></script>
    <script src={{ asset('assets/js/vendor/bootstrap.bundle.min.js') }}></script>
    <script src={{ asset('assets/js/plugins/slick.js') }}></script>
    <script src={{ asset('assets/js/plugins/jquery.syotimer.min.js') }}></script>
    <script src={{ asset('assets/js/plugins/waypoints.js') }}></script>
    <script src={{ asset('assets/js/plugins/wow.js') }}></script>
    <script src={{ asset('assets/js/plugins/perfect-scrollbar.js') }}></script>
    <script src={{ asset('assets/js/plugins/magnific-popup.js') }}></script>
    <script src={{ asset('assets/js/plugins/select2.min.js') }}></script>
    <script src={{ asset('assets/js/plugins/counterup.js') }}></script>
    <script src={{ asset('assets/js/plugins/jquery.countdown.min.js') }}></script>
    <script src={{ asset('assets/js/plugins/images-loaded.js') }}></script>
    <script src={{ asset('assets/js/plugins/isotope.js') }}></script>
    <script src={{ asset('assets/js/plugins/scrollup.js') }}></script>
    <script src={{ asset('assets/js/plugins/jquery.vticker-min.js') }}></script>
    <script src={{ asset('assets/js/plugins/jquery.theia.sticky.js') }}></script>
    <script src={{ asset('assets/js/plugins/jquery.elevatezoom.js') }}></script>
    <!-- Template  JS -->
    <script src={{ asset('assets/js/main.js?v=6.0') }}></script>
    <script src={{ asset('assets/js/shop.js?v=6.0') }}></script>
</body>

</html>
