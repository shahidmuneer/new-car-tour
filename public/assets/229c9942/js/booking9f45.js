var vehicleSwiper;

$(function () {
    init();
});

function init() {
    if (window.history) {
        window.history.replaceState('', '', document.location.origin + '/driving-experience');
    }
    handleCarSlider();
    handleItems();
    handleAddons();
    handleTransportation();
    handleDateSection();
    handleLapsClick();
    recalculateItems();
    calculateTotal();
    handleSelectType();
}

function handleCarSlider() {
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
}

function handleItems() {
    $('#packages').on('click', '.swiper-slide:not(.disabled)', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var el = $(this),
            type = el.data('type');
        if (type === 'gift_package' || type === 'gokart_race') {
            $('#packages .disabled').addClass('swiper-slide').removeClass('disabled');
        }
        el.addClass('disabled').removeClass('swiper-slide');
        vehicleSwiper.update();
        $('.block-layer').show();
        $.post('/experience/booking/addPackage', el.data(), function (response) {
            var $el = $(response);
            if (type === 'gift_package' || type === 'gokart_race') {
                $.get(el.closest('form').attr('action'),  function(data) {
                    $('#date-section').replaceWith($(data).find('#date-section'));
                    handleDateSection();
                    var $session = $('.choose-time :checked');
                    loadTransportationTime($session.data('date'), $session.data('session'), $session.data('is-anytime'));
                    var $package = $('#booked-items .gift-package:not(.gift-package-custom)');
                    if ($package.length > 0) {
                        $package.replaceWith($el);
                    } else {
                        $('#booked-items').prepend($el);
                    }
                    $('.gift-package-custom .check-laps input[type=radio]').prop('checked', false);
                    var $container = $('#custom-amount').val('').parent().next();
                    $('#CartExperience_giftpackage_amount').val('');
                    $container.find('.crossed-out').text('');
                    $container.find('.price').text('');
                    $('html, body').animate({
                        scrollTop: ($('#booked-items .booked-item:first-child').offset().top) - $('header').outerHeight() - 150
                    }, 500);
                    recalculateItems();
                    calculateTotal();
                }).fail(function() {
                    alert('Error');
                }).always(function() {
                    $('.block-layer').hide();
                });
            } else {
                $('#booked-items').append($el);
                $('.block-layer').hide();
                setTimeout(function () {
                    $el.attr('data-show', 'true');
                    setTimeout(function () {
                        $el.removeClass('animate-show');
                    }, 400);
                    if (type === 'vehicle') {
                        if ($('#packages .price.discounted').data('price') !== $('#packages .price.default').data('price')) {
                            $('#packages .price.discounted').addClass('active');
                            $('#packages .price.default').removeClass('active');
                        } else {
                            $('#packages .price.discounted').removeClass('active');
                            $('#packages .price.default').addClass('active');
                        }
                        if ($('#packages .price.full-price').data('price') !== $('#packages .price.discounted').data('price')) {
                            $('#packages .price.full-price').addClass('active');
                        } else {
                            $('#packages .price.full-price').removeClass('active');
                        }
                        $('html, body').animate({
                            scrollTop: ($('#booked-items .booked-item:last-child').offset().top) - $('header').outerHeight() - 150
                        }, 500);
                    } else {
                        $('html, body').animate({
                            scrollTop: ($('#booked-items .booked-item:first-child').offset().top) - $('header').outerHeight() - 150
                        }, 500);
                    }
                    recalculateItems();
                    calculateTotal();
                }, 50);
            }
        });
    });
    
    $('#booked-items').on('click', '.remove', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var $el = $(this),
            $target = $el.closest('.booked-item');
        var type = $el.data('type');
        $.post('/experience/booking/removePackage', $el.data(), function (response) {
            $target.css('max-height', $target.height() + 'px');
            $target.attr('data-hide', 'true').promise().done(function () {
                setTimeout(function () {
                    $target.remove();
                    if (type === 'gift_package' || type === 'gokart_race') {
                        $('#packages .disabled').addClass('swiper-slide').removeClass('disabled');
                    }
                    $('#packages .disabled[data-model-id=' + $el.data('id') + ']').addClass('swiper-slide').removeClass('disabled');
                    vehicleSwiper.update();
                    if ($('#booked-items .booked-item').length === 0) {
                        $('#packages .swiper-slide').each(function() {
                            var $el = $(this);
                            $el.find('.price.discounted').removeClass('active');
                            $el.find('.price.default').addClass('active');
                            if ($el.find('.price.price.full-price').data('price') !== $el.find('.price.price.default').data('price')) {
                                $el.find('.price.price.full-price').addClass('active');
                            } else {
                                $el.find('.price.price.full-price').removeClass('active');
                            }
                        });
                    }
                    recalculateItems();
                    calculateTotal();
                }, 400);
            });
        });
    }).on('change', '.select-driving-laps', function (e) {
        e.preventDefault();
        var $el = $(this),
            $container = $el.closest('.booked-item'),
            params = $el.data(),
            laps = $el.val();
        $container.find('.check-laps input').prop('checked', false);
        $container.find('.check-laps input[value=' + laps + ']').prop('checked', true);
        params['laps'] = laps;
        updateLaps($container, params);
    }).on('click', '.gift-package-custom .check-laps label', function() {
        $('#booked-items .gift-package:not(.gift-package-custom)').remove();
        $('#packages .disabled').addClass('swiper-slide').removeClass('disabled');
        vehicleSwiper.update();
        setAmountPackage();
        setTimeout(function() {
            calculateTotal();
        }, 200);
    }).on('change', '#custom-amount', function() {
        $('#booked-items .gift-package:not(.gift-package-custom)').remove();
        $('#packages .disabled').addClass('swiper-slide').removeClass('disabled');
        vehicleSwiper.update();
        setAmountPackage();
        setTimeout(function() {
            calculateTotal();
        }, 200);
    }).on('change', '.quantity', function() {
        calculateTotal();
    });
}

function handleSelectType()
{
    if (isMobile) {
        var position = 0,
            $active = $('.step-1 > .choose-booking-type .choose-type-item.active');
        if ($active.length) {
            position = $('.step-1 > .choose-booking-type .choose-type-item').index($active);
        }
        $('.step-1 > .choose-booking-type').owlCarousel({
            loop: false,
            responsive : {
                0 : {
                    items: 1
                },
                768 : {
                    items: 2
                },
                1024 : {
                    items: 3
                },
                1280 : {
                    items: 4
                }
            },
            startPosition: position,
            margin: 20,
            nav: true,
            navText: ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>'],
            navClass: ['b-prev icon-chevron-thin-left', 'b-next icon-chevron-thin-right'],
            autoHeight: true,
            lazyLoad: true
        });
        $('.step-1 .modal-body .choose-booking-type').owlCarousel({
            loop: false,
            responsive : {
                0 : {
                    items: 1
                },
                768 : {
                    items: 2
                },
                1024 : {
                    items: 3
                },
            },
            margin: 20,
            nav: true,
            navText: ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>'],
            navClass: ['b-prev icon-chevron-thin-left', 'b-next icon-chevron-thin-right'],
        });
    }
    $('.checkout-page').on('click', '.type-section .choose-booking-type .choose-type-item', function(e) {
        e.preventDefault();
        var $el = $(this),
            target = $el.data('target');
        $('.block-layer').show();

        if($(this).hasClass('redirect') && $(this).data('url')) {
            window.location.href = $(this).data('url') + '?type=' + $(this).data('type');
            return;
        }

        $.get($el.closest('form').attr('action'), $el.data(),  function(data) {
            $('.modern').replaceWith(data);
            init();
            if (target) {
                var $target = $(target);
            } else {
                var $target = $('#customize-experience');
            }
            $('html, body').animate({
                scrollTop: ($target.offset().top) - $('header').outerHeight() - 150
            }, 500);
        }).fail(function() {
            alert('Error');
        }).always(function() {
            $('.block-layer').hide();
        });
    }).on('click', '.type-section .choose-booking-type .choose-type-item .expirience-type', function(e) {
        e.stopPropagation();
        e.preventDefault();
        $(this).closest('.choose-type-item').trigger('click');
    }).on('click', '.type-section .choose-booking-type .choose-type-item .learn-more', function(e) {
        e.stopPropagation();
    });
}

function handleDateSection() {
    $(".month a").click(function(e) {
        e.preventDefault();
        $('#dates').focus();
    });
    
    $('.choose-date').on('click', 'input', function (e) {
        var $el = $(this),
            date = $el.data('date'),
            anytime = $el.data('anytime');
        $('#CartExperience_anydate').prop('checked', false);
        if ($el.closest('.choose-date').hasClass('race')) {
            loadTransportationTime($el.data('date'), $el.data('session'), $el.data('is-anytime'));
            $('#time-' + $el.data('key')).prop('checked', true);
        } else {
            if ($el.hasClass('spare')) {
                e.preventDefault();
                bootbox.confirm($el.data('reason'), function(result) {
                    if (result) {
                        $el.prop('checked', true).attr('checked', true);
                        $('.block-layer').show();
                        $.post($('#booking-form').attr('action'), {
                            track: $el.data('track'),
                            date: date,
                        }, function(data) {
                            $('.modern').replaceWith(data);
                            init();
                        }).fail(function() {
                            alert('Error');
                        }).always(function() {
                            $('.block-layer').hide();
                        });
                    }
                });
            } else {
                loadTimes(date, anytime);
                $('#CartExperience_gift_certificate').prop('checked', false);
            }
        }
    });
    
    $('.choose-time').on('click', 'input', function (e) {
        var $el = $(this);
        if ($(this).closest('.choose-time').hasClass('race')) {
            return false;
        } else {    
            $('#CartExperience_anydate').prop('checked', false);
            loadTransportationTime($el.data('date'), $el.data('session'), $el.data('is-anytime'));
            $('#CartExperience_gift_certificate').prop('checked', false);
        }
    });
    
    $('#CartExperience_gift_certificate').on('click', function (e) {
        $(this).prop('checked', true);
        $.post('/experience/booking/selectDateLater');
        $('.choose-date input:checked').prop('checked', false);
        $('.choose-time input:checked').prop('checked', false);
    });
}

function handleTransportation() {
    $('#CartExperience_transportation_type_id').on('change', function() {
        updateTransportation();
    });
    $('#CartExperience_location_time_entry_id').on('change', function() {
        updateTransportation();
    });
    $('#CartExperience_guest').on('change', function() {
        updateTransportation();
    });
    function updateTransportation() {
        $.post('/experience/booking/updateTransportation', {
            type: $('#CartExperience_transportation_type_id').val(),
            time: $('#CartExperience_location_time_entry_id').val(),
            guest: $('#CartExperience_guest').val()
        });
    }
}
  
function handleAddons() {
    $('.addon-item:not(.disabled)').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        var $el = $(this).find('.custom-control-input'),
            $select = $el.closest('.addon-item').find('select'),
            val = $el.val(),
            checked = $el.prop('checked');
        if (checked) {
            $el.prop('checked', false);
            if ($select.length) {
                $select.hide();
            }
            $el.closest('.label').removeClass('active');
        } else {
            if (window.addonPopups[val] != undefined) {
                Swal.fire({
                        icon: 'info',
                        html: window.addonPopups[val].message,
                        confirmButtonText: 'Ok'
                });
            }
            $el.prop('checked', true);
            if ($select.length) {
                $select.show();
            }
            $el.closest('.label').addClass('active');
        }
        calculateTotal();
        var params = {
            index: $el.data('index'),
            quantity: checked === true ? 0 : 1
        }
        if ($select.length) {
            params[$select.data('type')] = $select.val();
        }
        $.post('/experience/booking/updateAddon', params);
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
    });
    $('.addon-item select').click(function(e) {
        e.stopPropagation();
    });
    $('.addon-item select').change(function(e) {
        e.stopPropagation();
        var $el = $(this),
            params = {
                index: $el.closest('.addon-item').find('.custom-control-input').data('index'),
                quantity: 1
            };
            params[$el.data('type')] = $el.val();
        $.post('/experience/booking/updateAddon', params);
        calculateTotal();
    });
}

function handleLapsClick()
{
    $('#booked-items').on('click', '.check-laps label', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var $el = $(this),
            $input = $el.find('input').prop('checked', true),
            $container = $el.closest('.booked-item'),
            params = $el.data(),
            laps = $input.val();
        $container.find('.select-driving-laps').val(laps);
        params['laps'] = laps;
        if ($container.hasClass('gift-package-custom')) {
            var $container = $('#custom-amount').val('').parent().next();
            $('#CartExperience_giftpackage_amount').val('');
            $container.find('.crossed-out').text('');
            $container.find('.price').text('');
            calculateTotal();
        } else {
            updateLaps($container, params);
        }
    });
}

function updateLaps($container, params) {
    $.post('/experience/booking/updatePackage', params, function(data) {
        for (var i in data) {
            $container.find('.calculated-price.' + i).data('price', data[i]).text(parseFloat(data[i]).toLocaleString('en-US', {
                style: 'currency',
                currency: 'USD',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }));
        }
        recalculateItems();
        calculateTotal();
    }, 'json');
}

function setAmountPackage() {
    $.post('/experience/booking/setAmountPackage')
}

function loadDates(date, anytime, except) {
    $.get('/experience/booking/getDates', {
        date: date,
        anytime: anytime,
        except: except,
        track: $('#track').val()
    }, function (response) {
        var d = new Date(date);
        $('.choose-date-time .month .month').text(d.toLocaleString("en-us", {month: "long"}));
        $('.choose-date').html(response);
    });
}

function loadTimes(date, anytime) {
    $.get('/experience/booking/getTimes', {
        date: date,
        anytime: anytime,
        track: $('#track').val()
    }, function (response) {
        $('.choose-time').html(response);
        var $el = $('.choose-time :checked');
        loadTransportationTime(date, $el.data('session'), $el.data('is-anytime'));
    });
}

function loadTransportationTime(date, session, isAnytime) {
    $.get('/experience/booking/getTransportationTime', {date: date, session: session, isAnytime: isAnytime}, function (response) {
        $('#pickup-booking-description').replaceWith($('<div>' + response + '</div>').find('#pickup-booking-description'));
    });
}

function recalculateItems() {
    var $items = $('#booked-items .booked-item.vehicle'),
        length = $items.length;
    $('#booked-items .booked-item.vehicle').each(function (index) {
        var $item = $(this),
            category = parseInt($item.data('category')),
            $select = $item.find('.select-driving-laps'),
            selectB1G1LapsFrom = parseInt($select.data('b1g1-laps-from')),
            selectB1G1LapsTo = parseInt($select.data('b1g1-laps-to')),
            selectB1G1LapsAmount = parseInt($select.data('b1g1-laps-amount'));
        $item.find('.price').removeClass('active');
        $item.find('.calculated-price').removeClass('active');
        if (index === 0) {
            $select.find('option').each(function() {
                var $el = $(this),
                    text = $el.text(),
                    laps = parseInt($el.attr('value')),
                    fullSelectB1G1 = parseInt($el.data('discount'));
                if (category === 1 && laps > 3) {
                    if (fullSelectB1G1 > 0) {
                       if (text.indexOf('%') === -1) {
                           $el.text(text + ' - ' + fullSelectB1G1 + '% Off');
                       } else {
                           $el.text(text.replace(/(\d)+%/, fullSelectB1G1 + '%')); 
                       }
                    } else {
                       $el.text(text.replace(/\s\-\s(\d)+%\sOff/, ''));
                    }
                }
            });
            if (length > 1) {
                $item.find('.calculated-price.normal').addClass('active');
            } else {
                $item.find('.calculated-price.cotw').addClass('active');
            }
        } else {
            $select.find('option').each(function() {
                var $el = $(this),
                    text = $el.text(),
                    laps = parseInt($el.attr('value')),
                    fullSelectB1G1 = parseInt($el.data('discount')) + getB1g1Discount(laps, $select.data('track-vehicle-id'));
                if (category === 1 && laps > 3) {
                    /*if (laps >= selectB1G1LapsFrom && laps <= selectB1G1LapsTo) {
                        fullSelectB1G1 = selectB1G1LapsAmount;
                    }*/
                    if (fullSelectB1G1 > 0) {
                       if (text.indexOf('%') === -1) {
                           $el.text(text + ' - ' + fullSelectB1G1 + '% Off');
                       } else {
                           $el.text(text.replace(/(\d)+%/, fullSelectB1G1 + '%')); 
                       }
                    } else {
                       $el.text(text.replace(/\s\-\s(\d)+%\sOff/, ''));
                    }
                }
            });
            $item.find('.calculated-price.b1g1').addClass('active');
        }
        $item.find('.check-laps label').each(function() {
            var $el = $(this);
            if (index === 0) {
                $el.find('.laps.b1g1').hide();
                $el.find('.laps.normal').show();
                if (length > 1) {
                    $el.find('.laps.cotw').hide();
                    $el.find('.price.normal').addClass('active');
                    if (parseFloat($el.find('.price.normal').data('price')) !== parseFloat($el.find('.price.full-price').data('price'))) {
                        $el.find('.price.full-price').show();
                    } else {
                        $el.find('.price.full-price').hide();
                    }
                } else {
                    $el.find('.laps.cotw').show();
                    $el.find('.price.cotw').addClass('active');
                    if (parseFloat($el.find('.price.cotw').data('price')) !== parseFloat($el.find('.price.full-price').data('price'))) {
                        $el.find('.price.full-price').show();
                    } else {
                        $el.find('.price.full-price').hide();
                    }
                }
            } else {
                $el.find('.laps.normal').hide();
                $el.find('.laps.cotw').hide();
                $el.find('.laps.b1g1').show();
                $el.find('.price.b1g1').addClass('active');
                if (parseFloat($el.find('.price.b1g1').data('price')) !== parseFloat($el.find('.price.full-price').data('price'))) {
                    $el.find('.price.full-price').show();
                } else {
                    $el.find('.price.full-price').hide();
                }
            }
        });
    });
    if (length > 0) {
        $('#additional').show();
    } else {
        $('#additional').hide();
    }
}

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
    var $addon = $('#addon-3');
    if (price >= 2000) {
        $addon.prop('checked', true).closest('.label').addClass('active');
        $addon.data('price', 0);
        var $b = $addon.next('label').find('b');
        if ($b.next('.free').length === 0) {
            $b.hide().after('<b class="free">Free</b>');
        }
    } else {
        $addon.data('price', $addon.data('price-const'));
        $addon.next('label').find('b').show().next('.free').remove();
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

function resolveTransportationTypeContent(element) {
    var $element = $(element),
        transportationType = $(element).val();

    if (transportationType === 0 || transportationType == '') {
        $('.transportation-type-container, .transportation-address').hide();
        $('.transportation-type-content, .shuttle-container').empty();
        $('.pickup-info-location-guest').hide();

        return false;
    } else {
        $('.transportation-type-container').show();
    }

    if (transportationType) {
        $.ajax({
            type: 'POST',
            url: '/experience/booking/resolveTransportationTypeContent',
            async: false,
            cache: false,
            data: {
                transportationType: transportationType
            },
            success: function (response) {
                var result = $.parseJSON(response);
                if (result.types) {
                    $('.transportation-type-content').empty();
                    $('.children-types-container').empty().append(result.content);
                } else {
                    $('.transportation-type-content').empty().append(result.content);
                }

                if (!result.hasChildrens && !result.hasParent) {
                    $('.children-types-container').empty();
                }

                if (result.shuttle.length > 0) {
                    $('.shuttle-container').empty().append(result.shuttle);
                } else {
                    $('.shuttle-container').empty();
                }

                transportationType = parseInt(transportationType);

                if (transportationType === 1 || transportationType === 4 || transportationType === 5 || transportationType === 10) {
                    $('.transportation-address').show();
                } else {
                    $('.transportation-address').hide();
                }

                if(transportationType === 2) {
                    $('.pickup-info-location-guest').show();
                } else {
                    $('#CartExperience_guest').val('');
                    $('.pickup-info-location-guest').hide();
                }
            }
        });
    } else {
        $('.transportation-address').hide();
        $('.transportation-type-content, .shuttle-container, .children-types-container').html('');
    }
}

function getB1g1Discount(laps, trackVehicleId)
{
    const vehicleB1G1Discounts = b1g1Discounts[trackVehicleId];
    let discountValue = 0;
    if (vehicleB1G1Discounts !== undefined && vehicleB1G1Discounts.length > 0) {
        vehicleB1G1Discounts.map((discount) => {
            if (laps >= discount.laps_from && laps <= discount.laps_to) {
                discountValue += parseInt(discount.amount);
            }
        });
    }

    return discountValue;
}
