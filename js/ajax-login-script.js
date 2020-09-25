jQuery(document).ready(function($) {
    // Show the login dialog box on click
    $('a#pop_login').on('click', function(e){
        $('body').prepend('<div class="login_overlay"></div>');
        $('form#loginForm').fadeIn(500);
        $('div.login_overlay, form#loginForm a.close').on('click', function(){
            $('div.login_overlay').remove();
            $('form#loginForm').hide();
        });
        e.preventDefault();
    });
    
    // Perform AJAX login on form submit
    /*$('#loginForm').on('submit', login);

    function login(e) {
        e.preventDefault();
        
        var $form = $(this);
        var data = {
            'action': 'login_check',
            'username': $form.find('#username').val(),
            'password': $form.find('#password').val(),
            //'rememberme': $form.find('#rememberme').is(':checked') ? true : false,
            // 'security': $form.find('#security').val()
        };
        
        $.ajax({
            url: ajax_login_object.ajaxUrl,
            type: 'POST',
            dataType: 'json',
            data: data,
            // beforeSend: function (jqXHR, settings) { $('.register-message').html(”); },
            success: function (data, textStatus, xhr) { onAjaxSuccess(data); },
            error: function (jqXHR, textStatus, errorThrown) {
                $('.register-message').html('There was an unexpected error');
                $('.register-message').addClass('error');
                
            }
        });
    }
    function onAjaxSuccess(data) {
    
    if (typeof data.message !== 'undefined')
        $('.register-message').html(data.message);
        // reload on success
        if (typeof data.success !== 'undefined' && data.success === true) {
            location.reload();
        }
    }*/

});