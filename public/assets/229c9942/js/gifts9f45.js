//gift.js
$(document).ready(function() {
    $('#add-gift-package-custom').click(function(event) {
       var amount =  $('#giftpackage_amount').val().replace('$', '');
       if( amount < giftPackageByAmountMinimum) {
            event.preventDefault();
            $('#giftCertificateByAmountMssg').show();
            $('#giftpackage_amount').css('border-color', '#ee0000');
            $('#giftCertificateByAmountMssg').html('Amount must be greater than $' + giftPackageByAmountMinimum);
       }
    });
});