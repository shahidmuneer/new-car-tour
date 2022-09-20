/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var newsletterForm                = $('#newsletter-subscription-form');
var messageSubscribeMessage       = $('#newsletter-subscribe-message');

$('#btnAddNewsletterEmail').click(function() {
    $('#addNewsletterEmailLoading').show();
    $.ajax({
        type: 'POST',
        url: '/subscription/subscription/addnewsletteremail',
        async: true,
        cache: false,
        data: {
            email: $('#inputAddNewsletterEmail').val(),
        },
        success: function(response) {
            var result = $.parseJSON(response);
            $('#inputAddNewsletterEmailContainer').removeClass('success');
            $('#inputAddNewsletterEmailContainer').removeClass('error');
            if (result.success === 'true') {
                $('#inputAddNewsletterEmailContainer').addClass('success');
                $('#messageAddNewsletterEmail').css('color', 'green');
            } else {
                $('#inputAddNewsletterEmailContainer').addClass('error');
                $('#messageAddNewsletterEmail').css('color', 'red');
            }
            $('#messageAddNewsletterEmail').html(result.message);
        },
        complete: function() {
            $('#addNewsletterEmailLoading').hide();
        }
    });
});

function newsletterShowMessage(el, mssg, type) {
    el.removeClass('success');
    el.removeClass('error');
    if(type === 'success') {
          el.addClass('success');
    } else {
          el.addClass('error');
    }
    
    el.html(mssg);
    
}


function newsletterClearForm() {
    newsletterForm.find("input[type=text], textarea").val("");
}

function newsletterLoading(action) {
    if(action === 'show') {
      $('#newsletter-processing').show();
    } else {
      $('#newsletter-processing').hide(); 
    }
}





