var vehicleSwiper;

$(function () {

    vehicleSwiper = new Swiper('.checkout-page .swiper-box.cars-swiper:not(.disable-swiper-box) .swiper-container', {
        slidesPerView: 6,
        nextButton: '.checkout-page .swiper-box.cars-swiper .swiper-button-next',
        prevButton: '.checkout-page .swiper-box.cars-swiper .swiper-button-prev',
        spaceBetween: 4,
        breakpoints: {
            1280: {
                slidesPerView: 5,
                spaceBetween: 40,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            640: {
                slidesPerView: 1,
                spaceBetween: 20,
            }
        }
    });

    function calculateTotal()
    {
        var price = 0,
            fullPrice = 0;

        $('#booked-items .booked-item.vehicle').each(function() {
            var $container = $(this).closest('.booked-item');
            price += parseFloat($container.find('.calculated-price.active').data('price'));
            fullPrice += parseFloat($container.find('.calculated-price.full-price').data('price'));
        });

        $('#booked-items .booked-item.gift-package .info-card .calculated-price').each(function() {
            var $el = $(this),
                $select = $el.closest('.booked-item').find('select.quantity'),
                quantity = $select.length ? $select.val() : 1;
            price += parseFloat($el.data('price')) * quantity;
            fullPrice += parseFloat($el.data('full-price')) * quantity;
        });

        $('input[name="CartExperience[giftpackage_amount]"]:checked').each(function() {
            var $el = $(this),
                $container = $el.parent();
            price += parseFloat($container.find('.price.normal').data('price'));
            fullPrice += parseFloat($container.find('.price.full-price').data('price'));
        });

        var $customAmount = $('#custom-amount');
        if ($customAmount.length > 0) {
            var amount = $customAmount.val(),
                $container = $customAmount.parent().next('.price');
            if (amount) {
                price += parseFloat($container.data('price'));
                fullPrice += parseFloat($container.data('full-price'));
            }
        }

        $('.addon-item input:checked').each(function() {
            var $el = $(this),
                $container = $el.closest('.addon-item'),
                $select = $container.find('select');
            if ($container.find('.free').length === 0) {
                if ($select.length) {
                    var $option = $select.find('option:selected');
                    price += parseFloat($option.data('price'));
                    fullPrice += parseFloat($option.data('full-price'));
                } else {
                    price += parseFloat($el.data('price'));
                    fullPrice += parseFloat($el.data('full-price'));
                }
            }
        });

        price = Math.round((price + Number.EPSILON) * 100) / 100;
        fullPrice = Math.round((fullPrice + Number.EPSILON) * 100) / 100;
        var $fullPrice = $('.totals .crossed-out-price'),
            $price = $('.totals .real-price'),
            $savings = $('.totals .savings-amount');
        if (fullPrice > price) {
            $fullPrice.text(fullPrice.toLocaleString('en-US', {
                style: 'currency',
                currency: 'USD',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }));
            $price.addClass('discount-price');
            $savings.text('SAVE ' + (fullPrice - price).toLocaleString('en-US', {
                style: 'currency',
                currency: 'USD',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }));
        } else {
            $fullPrice.text('');
            $savings.text('');
            $price.removeClass('discount-price');
        }
        $price.text(price.toLocaleString('en-US', {
            style: 'currency',
            currency: 'USD',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }) + ' TOTAL');
        $('.float-cart-btn strong').text(price.toLocaleString('en-US', {
            style: 'currency',
            currency: 'USD',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }));
    }
    
    $('#packages').on('click', '.swiper-slide:not(.disabled)', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var el = $(this);
        $('#packages .disabled').addClass('swiper-slide').removeClass('disabled');
        el.addClass('disabled').removeClass('swiper-slide');
        vehicleSwiper.update();
        $('.block-layer').show();
        $.post('/experience/booking/selectGift', el.data(), function (response) {
            var el = $(response);
            var package = $('#booked-items .gift-package:not(.gift-package-custom)');
            if (package.length > 0) {
                package.replaceWith(el);
            } else {
                $('#booked-items').prepend(el);
            }
            $('.gift-package-custom .check-laps input[type=radio]').prop('checked', false);
            var container = $('#custom-amount').val('').parent().next();
            container.find('.crossed-out').text('');
            container.find('.price').text('');
            $('html, body').animate({
                scrollTop: ($('#booked-items .booked-item:first-child').offset().top) - $('header').outerHeight() - 150
            }, 500);
            calculateTotal();
        }).always(function() {
            $('.block-layer').hide();
        });
    });

    // Remove selected gift package
    $('#booked-items').on('click', '.remove', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var package = $('#booked-items .gift-package:not(.gift-package-custom)');
        package.remove();
        $('#packages .disabled').addClass('swiper-slide').removeClass('disabled');
        vehicleSwiper.update();
        calculateTotal();
    });

    $('.addon-item:not(.disabled)').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        var $el = $(this).find('.custom-control-input'),
            $select = $el.closest('.addon-item').find('select'),
            checked = $el.prop('checked');
        if (checked) {
            $el.prop('checked', false);
            if ($select.length) {
                $select.hide();
            }
            $el.closest('.label').removeClass('active');
        } else {
            $el.prop('checked', true);
            if ($select.length) {
                $select.show();
            }
            $el.closest('.label').addClass('active');
        }
        calculateTotal();
    });
    $('.addon-item .b-btn__video-play').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var self = $(this),
            item = self.closest('.video'),
            frameTemplate = item.find('.iframe'),
            params = frameTemplate.data('params'),
            videoSrc = '//www.youtube.com/embed/' + params + '&rel=0&controls=0&showinfo=0&autoplay=1&mute=1';
        e.preventDefault();
        frameTemplate.replaceWith('<iframe class="iframe" data-params="' + params + '" src="' + videoSrc + '" style="border: none;"></iframe>');
        item.find('img').hide();
        self.hide();
    }).on('change', function () {
        calculateTotal();
    });

    $('#booked-items').on('click', '.check-laps label', function (e) {
        calculateTotal();
    });
    $('#custom-amount').on('change', function () {
        calculateTotal();
    });

    $('.addon-item select').click(function(e) {
        e.stopPropagation();
    });
});

