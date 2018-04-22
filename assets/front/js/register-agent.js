jQuery(document).ready(function($) {
    $('#agent_login').submit(function(event){
        event.preventDefault();

        var redirect_after_reg = $(this).data('redirect');
        var ajaxurl = $(this).data('ajaxurl');
        var data = $(this).serialize();
        
        if ($('input[name="password"]').val() == $('input[name="repassword"]').val()) {

            $('.agent-register-info .msg').html('Please Wait...');
            $('.agent-register-info').show();
            
            $.post(ajaxurl, data, function(resp) {
                if (resp.status == 'already') {
                    $('.agent-register-info .msg').html(resp.msg);
                    $('.agent-register-info').show();
                } else {
                    $('.agent-register-info .msg').html(resp.msg);
                    $('.agent-register-info').removeClass('alert-info').addClass('alert-success');
                    if (redirect_after_reg != '' && redirect_after_reg != undefined) {
                        window.location = redirect_after_reg;
                    } else {
                        window.location = resp.message;
                    }
                }
            }, 'json');
        } else {
            alert('Passwords did not match!');
        }

    });
});