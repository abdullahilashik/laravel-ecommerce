(function () {
    function getCsrfToken() {
        var meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.content : '';
    }

    function sendCartRequest(url, formData) {
        return fetch(url, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: formData,
        });
    }

    function handleCartResponse(response) {
        return response.json().then(function (data) {
            if (!data || !data.success) {
                showCartToast((data && data.error) ? data.error : 'Something went wrong.', 'error');
                return;
            }
            updateCartUI(data);
            showCartToast(data.message || 'Cart updated.');
            closeQuickView();
        });
    }

    function handleCartError() {
        showCartToast('Could not update your cart.', 'error');
    }

    function updateCartUI(data) {
        var count = data.count;

        var countDesktop = document.getElementById('cart-count-desktop');
        var countMobile = document.getElementById('cart-count-mobile');
        if (countDesktop) countDesktop.textContent = count;
        if (countMobile) countMobile.textContent = count;

        document.querySelectorAll('[data-cart-badge]').forEach(function (el) {
            el.textContent = count;
        });

        var dd = document.getElementById('cart-dropdown-desktop');
        var dm = document.getElementById('cart-dropdown-mobile');
        if (dd && data.dropdownDesktop) dd.innerHTML = data.dropdownDesktop;
        if (dm && data.dropdownMobile) dm.innerHTML = data.dropdownMobile;
    }

    function closeQuickView() {
        var qv = document.getElementById('quickViewModal');
        if (qv && window.bootstrap && bootstrap.Modal && bootstrap.Modal.getInstance(qv)) {
            bootstrap.Modal.getInstance(qv).hide();
        }
    }

    function showCartToast(message, type) {
        var toast = document.createElement('div');
        toast.textContent = message;
        toast.style.cssText =
            'position:fixed;bottom:20px;left:50%;transform:translateX(-50%) translateY(20px);' +
            'z-index:999999;color:#fff;padding:12px 24px;border-radius:8px;font-size:14px;' +
            'font-weight:600;box-shadow:0 8px 24px rgba(0,0,0,.18);opacity:0;transition:all .3s ease;' +
            (type === 'error' ? 'background:#e8532e;' : 'background:#07a87f;');
        document.body.appendChild(toast);

        requestAnimationFrame(function () {
            requestAnimationFrame(function () {
                toast.style.opacity = '1';
                toast.style.transform = 'translateX(-50%) translateY(0)';
            });
        });

        setTimeout(function () {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(-50%) translateY(20px)';
            setTimeout(function () { toast.remove(); }, 300);
        }, 2500);
    }

    document.addEventListener('submit', function (event) {
        var form = event.target.closest('form[data-cart-add]');
        if (form) {
            event.preventDefault();
            sendCartRequest(form.action, new FormData(form))
                .then(handleCartResponse)
                .catch(handleCartError);
            return;
        }

        var removeForm = event.target.closest('form[data-cart-remove]');
        if (removeForm) {
            event.preventDefault();
            sendCartRequest(removeForm.action, new FormData(removeForm))
                .then(function (response) {
                    return handleCartResponse(response).then(function () {
                        if (!removeForm.closest('.cart-dropdown-wrap')) {
                            window.location.reload();
                        }
                    });
                })
                .catch(handleCartError);
        }
    });

    document.addEventListener('click', function (event) {
        var addBtn = event.target.closest('[data-cart-add-product]');
        if (!addBtn) return;

        event.preventDefault();
        event.stopPropagation();

        var formData = new FormData();
        formData.append('_token', getCsrfToken());
        formData.append('quantity', 1);

        sendCartRequest('/cart/add/' + addBtn.dataset.cartAddProduct, formData)
            .then(handleCartResponse)
            .catch(handleCartError);
    });

    // Wishlist toggle (heart icons)
    document.addEventListener('click', function (event) {
        var toggleBtn = event.target.closest('[data-wishlist-toggle]');
        if (!toggleBtn) return;

        event.preventDefault();
        event.stopPropagation();

        var productId = toggleBtn.dataset.wishlistToggle;
        var formData = new FormData();
        formData.append('_token', getCsrfToken());

        fetch('/wishlist/toggle/' + productId, {
            method: 'POST',
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            body: formData,
        })
        .then(function (response) {
            if (response.redirected) {
                showCartToast('Please sign in to manage your wishlist.', 'error');
                setTimeout(function () { window.location.href = response.url; }, 1000);
                return;
            }
            return response.json();
        })
        .then(function (data) {
            if (!data) return;
            showCartToast(data.message || 'Wishlist updated.');

            var dd = document.getElementById('wishlist-count-desktop');
            var dm = document.getElementById('wishlist-count-mobile');
            if (dd) dd.textContent = data.count;
            if (dm) dm.textContent = data.count;

            toggleBtn.classList.toggle('wishlisted', data.wishlisted);
        })
        .catch(function () { showCartToast('Could not update wishlist.', 'error'); });
    });

    // Wishlist page remove
    document.addEventListener('submit', function (event) {
        var wlForm = event.target.closest('form[data-wishlist-remove]');
        if (!wlForm) return;

        event.preventDefault();
        sendCartRequest(wlForm.action, new FormData(wlForm))
            .then(function (response) {
                return response.json().then(function (data) {
                    if (!data || !data.success) {
                        showCartToast((data && data.error) ? data.error : 'Something went wrong.', 'error');
                        return;
                    }
                    showCartToast(data.message || 'Removed from wishlist.');
                    var dd = document.getElementById('wishlist-count-desktop');
                    var dm = document.getElementById('wishlist-count-mobile');
                    if (dd) dd.textContent = data.count;
                    if (dm) dm.textContent = data.count;
                    window.location.reload();
                });
            })
            .catch(function () { showCartToast('Could not update wishlist.', 'error'); });
    });
})();