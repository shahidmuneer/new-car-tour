var summary = {
    icon: $('.float-cart-btn'),
    getBoxContent: function () {
        $.ajax({
            type: 'GET',
            url: '/summary/summary/renderBox',
            data: {cartOnly: cartOnly},
            async: true,
            success: function (response) {
                summary.icon.after(response);
                $(document).find('.summary-panel').fadeIn();    
            }
        });
    },
    show: function () {
        this.getBoxContent();
        $(this.icon).removeClass('active');
        $(this.box).addClass('visible');
        $(this.box).removeClass('hidden');

    },
    hide: function () {
        $(this.icon).addClass('active');
        $('.summary-panel').fadeOut(500, function () {
            $(this).remove();
        });
    }
};
//$(document).on('click', '.float-cart-btn', function (event) {
//    event.preventDefault();
//    var self = $(this);
//    if (self.hasClass('active')) {
//        summary.show();
//    } else {
//        summary.hide();
//    }
//}).on('click', '.summary-panel .close', function (event) {
//    event.preventDefault();
//    summary.hide();
//});