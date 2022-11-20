(function ($) {
    var VIDEO_SLIDE = '.w-video__slide';
    var INIT_VIDEO_BUTTON = '.b-btn__play';
    var MUTE_BUTTON = '.video-mute';
    var MUTE_BUTTON_LABEL = '.b-btn__mute';
    var $mainSlider = $('#slider');


    // call global funcs
    initLazyLoad();

    // call local funcs
    initSliders();
    initMainMenu();
    initCarsChooser();
    initStepsWidget();
    initProductStats();
    initScrollBtn();
    initSupercar();
    initCounter();
    initEffectForComboDisclaimer();
    initVipMembershipBlock();
    handleDynamicBlocks();
    handleBVideo();
    handleSelectLapsWidget();
    handleContentVisibilityButtons();
    handleSearchWidget();
    handleCircle();
    handleGokartForm();
    handlePrintPreview();
    handleRemovePerson();
    handleAddPerson();
    hanleGiftCertificate();
    handleRaceWidgetSelector();

    function handleRemovePerson() {
        $('body').on('click', '.row .btn-remove-contributor', function (e) {
            e.preventDefault();
            $(this).closest('.row').remove();
            checkContributorCount();
        });
    }

    function handleAddPerson() {
        $('body').on('click', '#btnAddContributor', function (e) {
            e.preventDefault();
            $($('#contributor-template').html()).insertBefore('#addBlock');
            checkContributorCount();
        });
    }
    
    function checkContributorCount() {
        var cnt = 0;

        $.each($('.contributor:not(:hidden)'), function () {
            cnt++;
        });

        if (cnt >= 5)
            $('#btnAddContributor').hide();
        else
            $('#btnAddContributor').show();

        return cnt;
    }
    
    function hanleGiftCertificate() {
        $('body').on('click', '#custom-amount', function () {
            $('.gift-package-custom .check-laps input[type=radio]').prop('checked', false);
            $('#booked-items .gift-package:not(.gift-package-custom)').remove();
            $('#packages .disabled').addClass('swiper-slide').removeClass('disabled');
            vehicleSwiper.update();
        }).on('click', '.gift-package-custom .check-laps label', function () {
            var $container = $('#custom-amount').val('').parent().next();
            $('#CartExperience_giftpackage_amount').val('');
            $container.find('.crossed-out').text('');
            $container.find('.price').text('');
            $('#booked-items .gift-package:not(.gift-package-custom)').remove();
            $('#packages .disabled').addClass('swiper-slide').removeClass('disabled');
            vehicleSwiper.update();
        }).on('change', '#custom-amount', function() {
            $('#CartExperience_giftpackage_amount').val($(this).val());
        });
    }
    
    function handlePrintPreview() {
        $('#print-preview').click(function(e) {
            e.preventDefault();
            var $form = $('#booking-form'),
                settings = $form.data('settings');
            $form.find('.help-block').hide();
            settings.submitting = true;
            $.fn.yiiactiveform.validate($form, function(data) {
                if($.isEmptyObject(data)) {
                    $('#previewModal .modal-body').html('<iframe></iframe>');
                    $('#previewModal iframe')
                        .attr('src', '/order/order/printPreview?' + $form.serialize())
                        .css({'width': '100%', 'height': window.innerHeight*0.8, 'overflow': 'auto', 'border': '0'});
                    $('#previewModal').modal('show');
                } else {
                    $.each(settings.attributes, function () {
                        $.fn.yiiactiveform.updateInput(this, data, $form);
                    });

                    $('html, body').animate({
                        scrollTop: ($('.help-block:visible').first().closest('.checkout-step').offset().top) - $('header').outerHeight()
                    },500);
                }
            });
        });
    }
    
    function handleGokartForm() {
        $('.gokart-form').on('click', '.item', function(e) {
            var el = $(this),
                form = el.closest('form');
            form.find('.item').removeClass('active');
            el.addClass('active');
            form.find('#gokart').val(el.data('id'));
            form.find('#gokartLaps').val(el.data('laps'));
        });
    }

    function handleCircle() {
        var circleTimer = null;
        function setTimer() {
            circleTimer = setTimeout(function () {
                var $el = $('.circle-container .circle-list .circle-item.active'),
                        $nextEl = $el.next();
                if ($nextEl.length) {
                    $nextEl.trigger('click');
                } else {
                    $('.circle-container .circle-list .circle-item').eq(0).trigger('click');
                }
            }, 6000);
        }
        setTimer();
        $('.circle-container .circle-list .circle-item').on('click mouseenter', function () {
            var $el = $(this),
                    $contentContainer = $el.closest('.circle-container').find('.circle-content');
            if (!$el.hasClass('active')) {
                clearTimeout(circleTimer);
                setTimer();
                $el.closest('.circle-list').find('.circle-item').removeClass('active');
                $el.addClass('active');
                $contentContainer.find('> div').stop(true, true);
                $contentContainer.find('.active').fadeOut(400, function () {
                    $(this).removeClass('active');
                    $contentContainer.find('.circe-content-item-' + $el.data('content')).stop(true, true).fadeIn(400, function () {
                        $(this).addClass('active');
                    });
                });
            }
        });
    }

    function handleRaceWidgetSelector()
    {
        $('.races-track-date-selection').on('click', '.item', function () {
            const el = $(this);
            const form = el.closest('form');
            form.find('.item').removeClass('active');
            let sessionInput = form.find('[name=gokartTrackDateSessionId]');
            const data = el.data();
            sessionInput.val(data.trackdatesession);
            el.addClass('active');
        });
    }

    // declare local funcs
    //////////////////////////

    function initSliders() {
        initMainSlider();
        initMapSlider();
        initReviewSlider();
    }

    function initMainSlider() {
        $mainSlider.on('initialized.owl.carousel', function () {
            handleSliderTranslated();
        });

        if ($mainSlider.length) {
          $mainSlider.owlCarousel({
            items: 1,
            singleItem: true,
            loop: true,
            video: true,

            nav: true,
            dots: true,

            autoplay: true,
            autoplayHoverPause: true,
            autoplayTimeout: 10000,

            videoHeight: 740,
            videoWidth: '100%',

            navClass: [
              'b-prev b-prev_main-slider icon-chevron-thin-left',
              'b-next b-next_main-slider icon-chevron-thin-right'
            ],
            navText: ['', '']
          });
        }

        $mainSlider.on('translate.owl.carousel', function () {
            handleSliderTranslate();
        });

        $mainSlider.on('translated.owl.carousel', function () {
            handleSliderTranslated();
        });

        initMainSliderVideoWrapper();
    }
    
    function handleSearchWidget() {
        $('body').on('change', '.b-experience__search select, .b-experience__search input', function() {
            var $el = $(this);
            $.get('/experience/search/getWidget', $el.closest('form').serialize(), function(data) {
                $('.b-experience__search').replaceWith(data);
            }, 'html');
        });
    }

    function handleSliderTranslate() {
        var $activeSlide;
        var $videoSlide;

        $activeSlide = $mainSlider.find('.owl-item.active');

        $videoSlide = $activeSlide.find(VIDEO_SLIDE);
        if ($videoSlide.length) pauseVideo($videoSlide);
    }

    function handleSliderTranslated() {
        var $activeSlide;
        var $videoSlide;

        $activeSlide = $mainSlider.find('.owl-item.active');

        $videoSlide = $activeSlide.find(VIDEO_SLIDE);
        if ($videoSlide.length) playVideo($videoSlide);
    }

    function playVideo($videoSlide) {
        var initialized;
        var $player;
        var player;
        var autoplay;

        initialized = $videoSlide.data('initialized');
        if (initialized) {
            $player = $videoSlide.data('ytPlayer');
            if (!$player) return;
            player = $player.player;
            if (!Object.keys(player).length) return;
            if (!player.playVideo) return;
            player.playVideo();
        } else {
            autoplay = $videoSlide.data('youtubeAutoplay');
            if (autoplay) {
                initMainSliderVideo();
            }
        }
    }

    function pauseVideo($videoSlide) {
        var $player;
        var player;

        $player = $videoSlide.data('ytPlayer');
        if (!$player) return;
        player = $player.player;
        if (!Object.keys(player).length) return;
        if (!player.pauseVideo) return;
        player.pauseVideo();
    }

    function muteVideo($videoSlide, mute) {
        var $player;
        var player;

        $player = $videoSlide.data('ytPlayer');
        if (!$player) return;
        player = $player.player;
        if (!Object.keys(player).length) return;

        if (mute) {
            if (!player.mute) return;
            player.mute();
        } else {
            if (!player.unMute) return;
            player.unMute();
        }
    }

    function initMainSliderVideoWrapper() {
        $(VIDEO_SLIDE).each(function () {
            var $this = $(this);
            var $muteButtonLabel;
            var $muteButton;

            $this.append(
                '<label class="b-btn__mute animated infinite pulse">' +
                    '<input type="checkbox" class="video-mute">' +
                '</label>'
            );
            $this.append('<button class="b-btn__play"></button>');

            $muteButtonLabel = $this.find(MUTE_BUTTON_LABEL);
            $muteButton = $this.find(MUTE_BUTTON);

            if ($this.data('youtube-mute')) {
                $muteButton.prop('checked', true);
                $muteButtonLabel.addClass('icon-mute');
            } else {
                $muteButton.prop('checked', false);
                $muteButtonLabel.addClass('icon-volume');
            }

            if (!$this.data('youtube-autoplay'))
                $this.find('.ytplayer-container').hide();
        });

        $('body')
            .on('change', MUTE_BUTTON, function () {
                var $this = $(this);
                var $activeSlide;
                var $videoSlide;

                $activeSlide = $mainSlider.find('.owl-item.active');

                $videoSlide = $activeSlide.find(VIDEO_SLIDE);
                if (!$videoSlide.length) return;

                if ($this.is(':checked')) {
                    $this.parent().removeClass('icon-volume');
                    $this.parent().addClass('icon-mute');

                    muteVideo($videoSlide, true);
                } else {
                    $this.parent().addClass('icon-volume');
                    $this.parent().removeClass('icon-mute');

                    muteVideo($videoSlide, false);
                }
            })
            .on('click', INIT_VIDEO_BUTTON, function () {
                initMainSliderVideo();
            })
    }

    function initMainSliderVideo() {
        var $activeSlide = $mainSlider.find('.owl-item.active');
        var $videoSlide = $activeSlide.find(VIDEO_SLIDE);
        var options = {
            videoId: $videoSlide.data('youtube-id'),
            playerVars: {
                origin: window.location.origin, // for secure reason
                autoplay: 0,

                modestbranding: 0,
                branding: 0,
                controls: 0,
                showinfo: 0,

                rel: 0,
                autohide: 0,

                wmode: 'transparent', // ????
            },
            fitToBackground: true,
            events: {
                'onStateChange': function (d) {
                    if (d.data == YT.PlayerState.PLAYING) {
                        $mainSlider.trigger('stop.owl.autoplay');
                    }
                    if (d.data == YT.PlayerState.ENDED) {
                        $videoSlide.data('ytPlayer').player.playVideo();
                        $mainSlider.trigger('play.owl.autoplay');
                        $mainSlider.trigger('next.owl.carousel');
                    }
                },
                'onReady': function (e) {
                    var $initButton = $videoSlide.find(INIT_VIDEO_BUTTON);
                    var mute = $videoSlide.data('youtube-mute') || $videoSlide.find(MUTE_BUTTON).is(':checked');
                    var volume = $videoSlide.data('youtube-volume');

                    $initButton.hide();
                    $activeSlide.find('.w-caption').hide();
                    $videoSlide.find('.poster').hide();

                    if (mute)
                        muteVideo($videoSlide, true);

                    if (!volume)
                        volume = 2;

                    e.target.setVolume(volume);

                    playVideo($videoSlide);

                    $videoSlide.find('.ytplayer-container').show();
                }
            }
        };
        var initialized = $videoSlide.data('initialized');

        if (initialized) return;
        $videoSlide.YTPlayer(options);
        $videoSlide.data('initialized', '1');
    }

    function initMapSlider() {
        var $mapSlider = $('#map-slider');
        var $mapSliderVsk = $('#map-slider_vsk');
        var $mapSliderOffroad = $('#map-slider_offroad');

        if ($mapSlider.length) {
          $mapSlider.owlCarousel({
            items: 1,
            dots: false,
            loop: false,
            autoplay:true,
            autoplayTimeout:10000,
            autoplaySpeed: 700,
            autoplayHoverPause:true
          });
        }
        if ($mapSliderVsk.length) {
            $mapSliderVsk.owlCarousel({
                items: 1,
                dots: false,
                loop: false,
                autoplay:true,
                autoplayTimeout:10000,
                autoplaySpeed: 700,
                autoplayHoverPause:true
            });
        }
        if ($mapSliderOffroad.length) {
            $mapSliderOffroad.owlCarousel({
                items: 1,
                dots: false,
                loop: false,
                autoplay:true,
                autoplayTimeout:10000,
                autoplaySpeed: 700,
                autoplayHoverPause:true
            });
        }

        $('.b-next.map').click(function () {
            $mapSlider.trigger('next.owl.carousel');
        });
        $('.b-prev.map').click(function () {
            $mapSlider.trigger('prev.owl.carousel');
        });
        $('.b-map-navigation').click(function () {
            $mapSlider.trigger('to.owl.carousel', $(this).data('slide'));
        });
    }

    function initReviewSlider() {
        var $reviewSlider = $('#review-slider');

        if ($reviewSlider.length) {
          $reviewSlider.owlCarousel({
            items: 1,
            dots: false,
            loop: true,
            nav: true,
            navText: [
              '<i class="icon-chevron-thin-left">&nbsp;</i>',
              '<i class="icon-chevron-thin-right">&nbsp;</i>'
            ]
          });
        }

        (function () {
            $('.b-next.review').click(function () {
                $reviewSlider.trigger('next.owl.carousel');
            });
            $('.b-prev.review').click(function () {
                $reviewSlider.trigger('prev.owl.carousel');
            });
        })();
    }

    function initMainMenu() {
        var superMenu = '#super-menu';
        var dropDown = '.b-dropdown';

        $(superMenu).superfish({
            delay: 100,
            speed: 'fast',
            speedOut: 'fast',

            onShow: function () {
                var el = $(this);

                if (el.find(dropDown).length) {
                    el.prev().addClass('opened');
                }
            }
        });

        $(dropDown).hover(
            function () {
                $(this).addClass('open');
                $('.overlay_menu').fadeIn(0);
            },
            function () {
                $(this).removeClass('open');
                $('.overlay_menu').fadeOut(0);
            }
        );

        $(superMenu + ' ' + dropDown + ' .model-link').hover(function() {
            var el = $(this).closest('li'),
                menu = el.find('> .level4'),
                top = 0;
            if (menu.length) {
                if (!el.parent().hasClass('level2')) {
                    top =  el.closest('.level2').find('> .sfHover').position().top;
                }
                menu.css('top', $(superMenu).position().top - top - el.closest('.level1').find('> .sfHover').position().top - 30);
            }
        });

        $(superMenu + ' .model-link').hover(function() {
            var $this = $(this),
                el = $this.next('.level4').find('li'),
                dataToSend;
            

            if (el.length && !el.hasClass('loaded')) {
                dataToSend = {
                    id: el.data('id'),
                    track: $this.data('track'),
                };

                $.get('/site/getMenuModel', dataToSend, function(data) {
                    el.addClass('loaded').html(data);
                });
            }
        });
    }

    function initScrollBtn() {
        var scrollButton = $('.b-top');

        $(window).scroll(function () {
            $(this).scrollTop() > 500 ?
                scrollButton.addClass('active') :
                scrollButton.removeClass('active');
        });

        scrollButton.click(function (e) {
            e.preventDefault();
            $('html, body').animate({ scrollTop: 0 }, 800);
        });
    }

    function initSupercar() {
        var hoverItemFlag = false;

        $('.b-supercar .b-car__info-list li:not(.inactive)').on('mouseenter', function () {
            var $this = $(this);
            var href = $this.find('a').attr('href');
            var tgbox = $this.closest('.b-car__info-list').next();

            $(tgbox).find('.tab-pane').removeClass('active');
            $(tgbox).find(href).addClass('active');

            changeHeightPanel($this.closest('.b-supercar_panel'));
        });

        $('.b-supercar .b-supercar__item .controls li:not(.inactive)')
            .on('mouseenter', function () {
                var item = $(this).closest('.b-supercar');
                checkPosSubPanel(item);
            })
            .on('mouseleave', function () {
                var item = $(this).closest('.b-supercar');

                setTimeout(function () {
                    if (!hoverItemFlag)
                        closeSubPanel(item.find('.b-supercar_panel'));
                }, 500);
            });

        $('.b-supercar .b-supercar_panel')
            .on('mouseenter', function () {
                hoverItemFlag = true;
            })
            .on('mouseleave', function () {
                closeSubPanel($(this));
                hoverItemFlag = false;
            });
    }

    function initCounter() {
        $('.counter').counterUp({
            delay: 50,
            time: 5000
        });
    }

    function initEffectForComboDisclaimer() {
        $('.combo-disclaimer').click(function () {
            $(this)
                .children('.combo-disclaimer-content')
                .slideToggle(300);
        });
    }

    function initVipMembershipBlock() {
        var $vipMembership = $('.vip-memebership');

        $vipMembership.find('.text-box .open-includes').on('click', function (e) {
            e.preventDefault();
            var box = $(this).closest('.story-text');
            box.find('.text-box').hide();
            box.find('.icons-box').show();
        });

        $vipMembership.find('.icons-box .hide-includes').on('click', function (e) {
            e.preventDefault();
            var box = $(this).closest('.story-text');
            box.find('.text-box').show();
            box.find('.icons-box').hide();
        });
    }

    function initStepsWidget() {
        var $stepsTabs = $('.tabs-steps');
        var $stepsContent = $('.b-steps__content');

        $stepsTabs.find('.b-steps__list > li > a.step').hover(function () {
            var self = $(this);
            var tbId = self.attr('href');

            self.trigger('click');

            $stepsTabs.find('.b-steps__list li').removeClass('active');
            self.closest('li').addClass('active');

            $stepsContent.find('.tab-pane').removeClass('active').addClass('fade');
            $(tbId).addClass('active').addClass('in');
        });

        $stepsContent
            .find('.b-btn__video-play')
            .on('click', function (e) {
                var self = $(this),
                    item = self.closest('.item'),
                    frameTemplate = item.find('.iframe'),
                    playParams = '&autoplay=1',
                    videoSrc = '//www.youtube.com/embed/' + frameTemplate.data('id') + '?rel=0&controls=0&showinfo=0' + playParams;

                e.preventDefault();

                // stop all videos
                $stepsContent
                    .find('iframe')
                    .each(function (i) {
                        var $this = $(this);
                        var src = $this.attr('src');

                        $this.attr('src', src.replace(playParams, ''));
                    });

                frameTemplate.replaceWith('<iframe src="' + videoSrc + '" style="border: none;"></iframe>');
                item.find('.img-responsive').hide();
                self.hide();
            });
    }

    function initCarsChooser() {
        var carsChooserHead;
        var $carsChooserHead;
        var $carsChooserHeadItems;
        var carPlace;
        var zI;

        carsChooserHead = '.car-selection-head';
        $carsChooserHead = $(carsChooserHead);
        $carsChooserHeadItems = $carsChooserHead.find('li');
        carPlace = '#car-place';

        zI = 200;
        $carsChooserHeadItems.each(function () {
            $(this).css('z-index', zI);
            zI--;
        });

        $carsChooserHeadItems.hover(
            function() {
                var $this;
                var $carContent;

                $this = $(this);
                $carContent = $this.find('.car-content');

                if ($carContent.length) {
                    $(carPlace).html($carContent.html());
                    $(carPlace + ' .car-selectio-box').css('display', 'block');
                } else {
                    $.get('/site/getCarMenuModel', {id: $this.data('id')}, function(data) {
                        $this.append(data);
                        $carContent = $this.find('.car-content');
                        $(carPlace).html($carContent.html());
                        $(carPlace + ' .car-selectio-box').css('display', 'block');
                    });
                }

                setTimeout(function () {
                    $('.select-count-lap label').css('color', 'red');
                }, 1000)

            }, function() {
            }
        );
        setTimeout(function () {
            $('.select-count-lap label').css('color', 'red');
        }, 2000)


        // TODO refactore
        $(carsChooserHead + ', .b-experience__search, .w-section, .b-fixed__nav').hover(
            function() {

            }, function() {
                $(carPlace + ' .car-selectio-box').css('display', 'none');
            }
        );
    }

    function initProductStats() {
        var $productStats = $('.w-product__stats');
        var updatePackageLapsButton = '.update-package-laps';

        $productStats.on('click', updatePackageLapsButton, function () {
            var el = $(this),
                laps = el.data('laps'),
                passengers = el.data('passengers'),

                $select = el
                    .closest('form')
                    .find('.select-driving-laps'),

                index = el.data('index'),
                type = $select.data('type');

            if (type == 'laps') {
                $select.val(laps);
                setCarPrice(el, index, laps, passengers, passengers);
            } else {
                $select.val(passengers);
                setCarPrice(el, index, laps, passengers, laps);
            }
        });

        $productStats
            .find('.select-driving-laps')
            .on('change', function (e) {
                var el = $(this),
                    type = el.data('type'),
                    id = el.data('index'),
                    val = el.val();

                el
                    .closest('form')
                    .find(updatePackageLapsButton)
                    .each(function () {
                        $(this).prop('checked', false);
                    });

                el
                    .closest('form')
                    .find(updatePackageLapsButton + '[data-' + type + '=' + val + ']')
                    .prop('checked', true);

                if (val.indexOf('giftpackage-') !== -1) {
                    id = val.replace('giftpackage-', '');
                }

                if (type == 'laps') {
                    var passengers = $('#laps-passengers-' + id).val();
                    setCarPrice(el, id, val, passengers, passengers);
                } else {
                    var laps = $('#laps-passengers-' + id).val();
                    setCarPrice(el, id, laps, val, laps);
                }
            });
    }

    function handleDynamicBlocks() {
        $(document)
            .on('submit', '.bookExperience', function (e) {
                var el = $(this).find('.update-package-laps:checked');

                if (el.length > 0 && (el.data('laps').indexOf('giftpackage-') !== -1) || !el.data('laps')) {
                    e.preventDefault();
                    window.location = '/experience/booking/create/gift_package_id/' + el.data('index');
                }
            })
            .on('submit', '.b-specs-rm', function (e) {
                var el = $(this).find('.widget-select-laps-inner input:checked');

                if (el.length > 0 && el.data('index')) {
                    e.preventDefault();
                    window.location = '/experience/booking/create/gift_package_id/' + el.data('index');
                }
            })
            .on('click', '.alert-block', function () {
                $(this).animate({'top': '-100%'}, 500).remove();
            })
            .on('click', '#super-menu a', function (e) {
                var $el = $(this),
                    track = $el.data('track'),
                    href = $el.attr('href');
                if (!href || href === '#') {
                    return false;
                }
                if (track) {
                    $.ajax({
                        type: "POST",
                        url: '/site/setTrack',
                        async: false,
                        data: {track: track}
                    });
                }
                return true;
            })
            .on('hover', '#info__car > li > a', function () {
                $(this).tab('show');
            });
    }

    function handleBVideo() {
        $('.b-video:not(.no-video)').on('click', function () {
            var self = $(this),
                videoFrame = self.find('iframe'),
                videoSrc = videoFrame.attr('src');

            videoFrame.attr('src', videoSrc + "&autoplay=1").show();
            self.find('.b-video__img').hide();
        });
    }

    function handleSelectLapsWidget() {
        var $selectLapsWidget = $('.widget-select-laps');

        $selectLapsWidget
            .find('label')
            .on('click', function (e) {
                var el = $(this);

                $selectLapsWidget
                    .find('input')
                    .each(function () {
                        $(this).prop('checked', false);
                    });

                el
                    .find('input')
                    .prop('checked', true);
            });
    }

    function handleContentVisibilityButtons() {
        var $viewComboDetail = $('.view-combo-detail');
        var $lessBtn = $('.lessbtn');
        var $moreBtn = $('.morebtn');

        $viewComboDetail.click(function () {
            var $this = $(this),
                target = $this.attr('href');

            target = $('#' + target);
            $this.html( (target.is(':visible') ) ?
                'View Details <div class="arrow-closed"></div>' :
                'Hide Details <div class="arrow-opened"></div>');

            target.is(':visible') ? target.slideUp(300) : target.slideDown(300);

            return false;
        });

        $lessBtn.click(function () {
            var moreBtn = $('a.morebtn').first(),
                target = $('div.more-content').first();

            if (target.is(':visible')) {
                moreBtn.show();
                target.hide(300);
            }

            return false;
        });

        $moreBtn.click(function () {
            var t = $(this),
                target = $('div.more-content').first();

            if (undefined !== target && !target.is(':visible')) {
                t.hide();
                target.show(300);
            }

            return false;
        });

        $('.accordion-arrows')
            .on('shown', function () {
                $('[data-target="#' + $(this).attr('id') + '"]')
                    .find('.arrow-closed')
                    .removeClass("arrow-closed")
                    .addClass("arrow-opened");
            })
            .on('hidden', function () {
                $('[data-target="#' + $(this).attr('id') + '"]')
                    .find('.arrow-opened')
                    .removeClass("arrow-opened")
                    .addClass("arrow-closed");
            });
    }

    function changeHeightPanel(item) {
        var parent = item.closest('.b-supercar__item');
        setTimeout(function () {
            item.css({height: 'auto'});
            parent.height(item.height() - 48);
            item.css({height: '100%'});
        }, 50);
    }
    
    function closeSubPanel(item) {
        item.removeClass('open');
        item.closest('.b-supercar').next().removeClass('visible');
        item.closest('.b-supercar__item').height('auto').css({'border-width': '1px'});
    }

    function checkPosSubPanel(item) {
        var winCenter = $(window).width() / 2;
        var itemPos = item.offset().left;
        if (itemPos > winCenter) {
            item.find('.b-supercar_panel').addClass('left-pos');
        }
        else {
            item.find('.b-supercar_panel').removeClass('left-pos');
        }
    }

    function setCarPrice(el, id, laps, passengers, value) {
        $('#laps-passengers-' + id).val(value);

        $.get(
            '/experience/booking/getcarprice',
            {
                id: id,
                laps: laps,
                passengers: passengers
            },
            function(data) {
                var form = el.closest('form');
                var $price = form.find('.price-selector .price');
                var $realPrice = $price.find('.real-price');

                $realPrice.text(data.price);

                if (data.showSavings) {
                    $price
                        .find('.crossed-out')
                        .text(data.priceWithoutDiscoutn)
                        .show();

                    $price
                        .find('.savings-amount')
                        .text(data.savings)
                        .show();

                    $realPrice.addClass('discount-price');
                } else {
                    form
                        .find('.price-selector .price .crossed-out, .price-selector .price .savings-amount')
                        .hide();

                    $realPrice.removeClass('discount-price');
                }
            },
            'json'
        );
    }
}(jQuery));

// declare exrVideoPlayer module that is used only in this file
//////////////////////////////////////
var exrVideoPlayer = (function ($) {
    var pub = {
        config: {
            defaultPlayerParams: 'autoplay=1',
            defaultPlayerUrl: '//www.youtube.com/embed/'
        },
        init: function () {
            var $this = this;

            $('body').on('click', '.extvp-play', function (e) {
                e.preventDefault();

                var self = $(this),
                    playerWrapper = self.closest('.extvp-wrapper'),
                    playerBox = playerWrapper.find('.extvp-box'),
                    playerOverlay = playerWrapper.find('.extvp-overlay'),
                    videoId = playerBox.data('extvp-id'),
                    videoParams = playerBox.data('extvp-params');

                playerBox.html(
                    '<iframe src="' + $this.getVideoSrc(videoId, videoParams) + '" style="border: none;"></iframe>'
                );
                playerOverlay.remove();
                self.remove();
            });
        },
        getVideoSrc: function (videoId, videoParams) {
            return this.config.defaultPlayerUrl + videoId + '?' + this.config.defaultPlayerParams + '&' + videoParams;
        }
    };

    return pub;
})(jQuery);

exrVideoPlayer.init();

// declare global funcs
//////////////////////////////////////
function toAnchor(anchor, offset) {
    if (offset > 0) {
        var target = $('a[name=' + anchor + ']');
        $('html,body').animate({
            scrollTop: target.offset().top - offset
        }, 1000);
    } else {
        location.hash = "#" + anchor;
    }
}

function toAnchorOffset(anchor, offset) {
    var target = $('#' + anchor);
    $('html,body').animate({
        scrollTop: target.offset().top - offset
    }, 1000);
}

function sticky_tab_relocate() {
    var window_top = $(window).scrollTop();
    var div_top = $('#sticky-anchor').offset().top - 180;
    var div_bottom = $('#sticky-bottom-anchor').offset().top - 100;

    if (window_top > div_top && window_top < div_bottom) {
        $('#tabs-view-navs').addClass('stick');
    } else {
        $('#tabs-view-navs').removeClass('stick');
    }
}

function initLazyLoad() {
    $(function() {
        $(".lazy").lazyload({
            effect: "fadeIn",
            placeholder: ''
        });

        $('img.lazy.b-supercar__item__image').on('load', function() {
            var $this = $(this);

            $this
                .closest('.b-supercar__item__image-wrapper')
                .addClass('with-shadow');
        });
    });
}

dateFormat = function date2str(x, y) {
    var z = {
        M: x.getMonth() + 1,
        d: x.getDate(),
        h: x.getHours(),
        m: x.getMinutes(),
        s: x.getSeconds()
    };
    y = y.replace(/(M+|d+|h+|m+|s+)/g, function (v) {
        return ((v.length > 1 ? "0" : "") + eval('z.' + v.slice(-1))).slice(-2)
    });

    return y.replace(/(y+)/g, function (v) {
        return x.getFullYear().toString().slice(-v.length)
    });
};

$(window).on('load', function() {
    handleIframe();
});
    
function handleIframe()
{
    $('.iframe-replace').each(function() {
       var $el = $(this);
       $el.replaceWith('<iframe src="' + $el.data('src')  + '">');
    });
}
