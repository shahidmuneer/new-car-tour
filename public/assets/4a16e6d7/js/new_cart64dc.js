var codeSent = false;
var duplicate = false;
var cartForm = (function ($) {
    var pub = {
            init: function() {
                initAjax();
                initDuplicateExperience();
                initRemoveExperience();
                initGoToCheckout();
                initCarDetails();
                initSlider();
                initDiscountCode();
            }
        };
    function initAjax() {
        $.ajaxSetup({
            beforeSend: function(){
                $('#loadmoreajaxloader').show();
            },
            complete: function(){
                $('#loadmoreajaxloader').hide();
            }
        });      
    }    
    function initDuplicateExperience() {
        $(document).on('click', '.duplicate-experience', function(e) {
            e.preventDefault();
            if (!duplicate) {
                duplicate = true;
                var el = $(this);
                $.ajax({
                    type: 'GET',
                    url: '/cart/cart/duplicatecartexperience',
                    async: true,
                    cache: false,
                    dataType: 'json',
                    data: {
                        id: el.data('id')
                    },
                    success: function(result) {
                        if (result.success) {
                            $('#experiencesContainer').append(result.html);
                            scrollContentTo($('#experience-0'));
                        } else {
                            alert(result.message);
                        }
                    }
                });
            }
        }).on('submit', '.duplicate-form', function(e) {
            e.preventDefault();
            var form = $(this);
            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                async: true,
                cache: false,
                data: form.serialize(),
                dataType: 'json',
                success: function(result) {
                    $('.help-block').text('').hide();
                    if (result.success) {
                        form.closest('.gift-certificate-detail').replaceWith(result.html);
                        initSlider();
                        updateTotals(result.totals);
                        duplicate = false;
                    } else if (result.errors) {
                        for (var key in result.errors) {
                            form.find('#CartExperience_' + key + '_em_').text(result.errors[key][0]).addClass('error').show();
                        }
                    } else {
                        alert(result.message);
                    }
                }
            });
        }).on('click', '#CartExperience_driver_buyer_y', function() {
            var form = $(this).closest('form');
            form.find('#CartExperience_notify').prop('checked', false);
            form.find('#driver-notify-container').hide();
        }).on('click', '#CartExperience_driver_buyer_n', function() {
            var form = $(this).closest('form');
            form.find('#CartExperience_notify').prop('checked', true);
            form.find('#driver-notify-container').show();
            form.find('#CartExperience_firstname').val('');
            form.find('#CartExperience_lastname').val('');
            form.find('#CartExperience_email').val('');
            form.find('#CartExperience_phone').val('');
            form.find('#CartExperience_dob').val('');
            form.find('.birthday-picker select').val(0);
        }).on('change', '.select select', function() {
            var el = $(this);
            if (el.val() == '') {
                el.parent().removeClass('selected');
            } else {
                el.parent().addClass('selected');
            }
        });
    }
    function initRemoveExperience() {
        $(document).on('click', '.remove-experience', function(e) {
            e.preventDefault();
            var el = $(this),
                id = el.data('id');
            if (el.hasClass('duplicated')) {
                duplicate = false;
                el.closest('.gift-certificate-detail').remove();
                emptyCart();
            } else if (confirm('Are you sure you want to remove this experience?')) {
                $.ajax({
                    type: 'POST',
                    url: '/cart/cart/removecartexperience',
                    async: true,
                    cache: false,
                    dataType: 'json',
                    data: {
                        index: id
                    },
                    success: function(result) {
                        eval(result.tracking);

                        updateTotals(result.totals);

                        el.closest('.gift-certificate-detail').remove();

                        emptyCart();
                    }
                });
            }
        });
    }
    function initGoToCheckout() {
        $(document).on('change', '#Cart_terms', function () {
            var el = $(this);
            if (el.is(':checked')) {
                $('.checkout-btn').removeClass('disabled disable');
            } else {
                $('.checkout-btn').addClass('disabled disable');
            }
        }).on('click', '.checkout-btn', function (event) {
            if ($(this).hasClass('disabled') || $(this).hasClass('disable')) {
                event.stopPropagation();
                event.preventDefault();
            }
        });
    }
    function initCarDetails() {
        $(document).on('click', '.driving-experience-item-details', function (e) {
            e.preventDefault();
            var el = $(this),
                container = el.closest('.gift-certificate-detail').find('.driving-experience-item');
            container.find('.book-image-car').attr('href', el.data('href')).find('img').attr('src', el.data('image'));
            container.find('.time-attack-info > span:first i').text(el.data('top-speed'));
            container.find('.time-attack-info > span:nth-child(2) i').text(el.data('power'));
            container.find('.time-attack-info > span:nth-child(3) i').text(el.data('acceleration'));
            container.find('.time-attack-info > span:last i').text(el.data('price'));
        });
    }
    function initSlider() {
        $('.products-slider').each(function () {
            var el = $(this),
                loops = true;

            if (el.find('.product-item').length < 4) {
                loops = false;
            }

            el.owlCarousel({
                loop: loops,
                items: 3,
                margin: 5,
                nav: true,
                navText: ['', ''],
                navClass: ['b-prev icon-chevron-thin-left', 'b-next icon-chevron-thin-right'],
                autoHeight: false,
                lazyLoad: true
            });
        });
    }    
    function scrollContentTo(el) {
        $('html, body').animate({
            scrollTop: el.offset().top - 150
        }, 500);
    }
    function updateTotals(totals) {
        if (totals.totalWithoutSavigs) {
            $('.total-price .crossed-out-price').text(totals.totalWithoutSavigs).show();
            $('.total-price .savings-amount').text(totals.savings).show();
        } else {
            $('.total-price .crossed-out-price, .total-price .savings-amount').text('').hide();
        }
        $('.float-cart-btn strong').text(totals.total);
        $('.total-price .real-price').text(totals.total);
        var count = $('.w-control__site .b-cart .caption .count').text(totals.totalExperiences);
        if (totals.totalExperiences) {
            count.show();
        } else {
            count.hide();
        }
        reloadSummary()
    }
    function emptyCart() {
        if ($('#experiencesContainer .gift-certificate-detail').length === 0) {
            $('.not-empty').remove();
            $('.empty').show();
            $('.continue-shopping').parent().removeClass('span6').addClass('span12');
        }
    }
    function initDiscountCode() {
        $(document).on('change', '.code', function(e) {
            if (!codeSent) {
                var el = $(this);
                applyCode(el);
                codeSent = true;
                setTimeout(function() {
                    codeSent = false;
                }, 100);
            }
        }).on('keydown', '.code', function(e) {
            if (e.which == 13 || e.keyCode == 13) {
                e.preventDefault();
                if (!codeSent) {
                    var el = $(this);
                    applyCode(el);
                    codeSent = true;
                    setTimeout(function() {
                        codeSent = false;
                    }, 100);
                }
            }
        }).on('click', '.apply', function(e) {
            e.preventDefault();
            var el = $(this);
            if (!codeSent) {
                applyCode(el.closest('.referral-code').find('.code'));
                codeSent = true;
                setTimeout(function() {
                    codeSent = false;
                }, 100);
            }
        });
    }
    function applyCode(el) {
        var type = el.data('type');
        $.ajax({
            type : 'POST',
            url : type == 'promo' ? '/cart/cart/applyDiscount' : '/cart/cart/applyGiftCode',
            async : false,
            cache : false,
            data  : {
                code: el.val()
            },
            dataType: 'json',
            success : function(result) {
                updateTotals(result.totals);
                if (!result.success) {
                    el.val('');
                } else if (type == 'gift') {
                    $('input.code[data-type="promo"]').val('');
                }
                if (result.message) {
                    alert(result.message);
                }
                $('#experiencesContainer').html(result.experiences);
            }
        });
    }
    function reloadSummary() {
        if (!$('.float-cart-btn').hasClass('active')) {
            $('.summary-panel').remove();
            if (typeof summary != 'undefined') {
                summary.getBoxContent();
            }
        }
    }
    
    return pub;
})(jQuery);

function resolveTransportationTypeContent(el, id) {
    var transportationType = $(el).val();

    if (transportationType == 0) {
        $('.transportation-type-container, .transportation-address').hide();
        $('.transportation-type-content, .shuttle-container').empty();
        return false;
    } else {
        $('.transportation-type-container').show();
    }

    $.ajax({
        type: 'POST',
        url: '/cart/cart/resolveTransportationTypeContent?id=' + id,
        async: false,
        cache: false,
        dataType: 'json',
        data: {
            transportationType: transportationType
        },
        success: function (result) {
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

            if (transportationType == 1 || transportationType == 4 || transportationType == 5 || transportationType == 10) {
                $('.transportation-address').show();
            } else {
                $('.transportation-address').hide();
            }

            if (transportationType == 2) {
                $('.pickup-info-location-guest').show();
            } else {
                $('#CartExperience_guest').val('');
                $('.pickup-info-location-guest').hide();
            }
        }
    });
}

function pickupLocationChange() {
    
}