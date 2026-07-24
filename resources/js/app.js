
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById('quickViewModal');
    if (!modal) return;

    modal.addEventListener('show.bs.modal', function (e) {
        var btn = e.relatedTarget;
        if (btn && btn.dataset.productSlug) {
            fetchQuickView(btn.dataset.productSlug);
        }
    });

    function fetchQuickView(slug) {
        fetch('/product/' + slug + '/quickview')
            .then(function (res) { return res.json(); })
            .then(function (p) {
                document.getElementById('qv-name').textContent = p.name;
                document.getElementById('qv-name').href = p.url;
                document.getElementById('qv-vendor').textContent = p.brand || '-';
                document.getElementById('qv-sku').textContent = p.sku || '-';
                document.getElementById('qv-rating-bar').style.width = p.rating_pct + '%';
                document.getElementById('qv-reviews').textContent = '(' + p.review_count + ' reviews)';

                var badge = document.getElementById('qv-badge');
                var discountWrap = document.getElementById('qv-discount-wrap');
                var priceEl = document.getElementById('qv-price');
                if (p.has_discount) {
                    badge.style.display = '';
                    badge.textContent = p.discount_pct + '% Off';
                    discountWrap.style.display = '';
                    document.getElementById('qv-discount-pct').textContent = p.discount_pct + '% Off';
                    document.getElementById('qv-old-price').textContent = '$' + Number(p.price).toFixed(2);
                    priceEl.textContent = '$' + Number(p.sale_price).toFixed(2);
                } else {
                    badge.style.display = 'none';
                    discountWrap.style.display = 'none';
                    priceEl.textContent = '$' + Number(p.price).toFixed(2);
                }

                var imagesContainer = document.getElementById('qv-images');
                var thumbsContainer = document.getElementById('qv-thumbnails');

                if (window.$ && $.fn.slick) {
                    if ($(imagesContainer).hasClass('slick-initialized')) {
                        $(imagesContainer).slick('unslick');
                    }
                    if ($(thumbsContainer).hasClass('slick-initialized')) {
                        $(thumbsContainer).slick('unslick');
                    }
                }

                imagesContainer.innerHTML = '';
                thumbsContainer.innerHTML = '';

                p.images.forEach(function (img) {
                    var fig = document.createElement('figure');
                    fig.className = 'border-radius-10';
                    var imgEl = document.createElement('img');
                    imgEl.src = img;
                    imgEl.alt = p.name;
                    fig.appendChild(imgEl);
                    imagesContainer.appendChild(fig);

                    var thumb = document.createElement('div');
                    var thumbImg = document.createElement('img');
                    thumbImg.src = img;
                    thumbImg.alt = p.name;
                    thumb.appendChild(thumbImg);
                    thumbsContainer.appendChild(thumb);
                });

                var cartForm = document.getElementById('qv-cart-form');
                cartForm.action = '/cart/add/' + p.id;

                if (window.$ && $.fn.slick) {
                    $(imagesContainer).slick({
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        arrows: false,
                        fade: false,
                        asNavFor: '.slider-nav-thumbnails',
                    });

                    $(thumbsContainer).slick({
                        slidesToShow: 4,
                        slidesToScroll: 1,
                        asNavFor: '.product-image-slider',
                        dots: false,
                        focusOnSelect: true,
                        prevArrow: '<button type="button" class="slick-prev"><i class="fi-rs-arrow-small-left"></i></button>',
                        nextArrow: '<button type="button" class="slick-next"><i class="fi-rs-arrow-small-right"></i></button>'
                    });

                    $('.slider-nav-thumbnails .slick-slide').removeClass('slick-active');
                    $('.slider-nav-thumbnails .slick-slide').eq(0).addClass('slick-active');

                    $(imagesContainer).on('beforeChange', function (event, slick, currentSlide, nextSlide) {
                        $('.slider-nav-thumbnails .slick-slide').removeClass('slick-active');
                        $('.slider-nav-thumbnails .slick-slide').eq(nextSlide).addClass('slick-active');
                    });
                }
            });
    }
});
