// Restricts input for the given textbox to the given inputFilter function.
/*function setInputFilter(textbox, inputFilter) {
    ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
        textbox.addEventListener(event, function() {
            if (inputFilter(this.value)) {
                this.oldValue = this.value;
                this.oldSelectionStart = this.selectionStart;
                this.oldSelectionEnd = this.selectionEnd;
            } else if (this.hasOwnProperty("oldValue")) {
                this.value = this.oldValue;
                this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
            } else {
                this.value = "";
            }
        });
    });
}
setInputFilter(document.querySelector(".numeric"), function(value) {
    // return /^\d*\.?\d*$/.test(value); // Allow digits and '.' only, using a RegExp
    return /^\d*\?\d*$/.test(value); // Allow digits and '.' only, using a RegExp
});

setInputFilter(document.querySelector(".alpha"), function(value) {
    return /^[a-z]*$/i.test(value);
});*/


jQuery(document).ready(function($) {
    'use strict'

    //called when key is pressed in textbox
    jQuery(".numeric").keypress(function (e) {
        if (e.which != 8 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });
    
    jQuery('.alpha').bind('keyup blur',function(){ 
        var node = $(this);
        node.val(node.val().replace(/[^a-z\s]/gi,'') );
    });
    
    var show_password = jQuery('#show_password');
    $(show_password).on('click',function(){
        // alert($(this).is(':checked'));
        $(this).is(':checked') ? $('#user_password').attr('type', 'text') : $('#user_password').attr('type', 'password');
    });
    
    var show_pass = jQuery('#show_pass');
    $(show_pass).on('click',function(){
        // alert($(this).is(':checked'));
        $(this).is(':checked') ? $('#user_pass').attr('type', 'text') : $('#user_pass').attr('type', 'password');
    });
    
    jQuery('a.add_new_family_option').on('click', function(){
        jQuery('#edit_profile .edit_family_details_option').slideDown(400);
    });
    
    // Show the login dialog box on click
    jQuery('a#pop_login').on('click', function(e){
        jQuery('body').prepend('<div class="login_overlay"></div>');
        jQuery('form#login').fadeIn(500);
        jQuery('div.login_overlay, form#login a.close').on('click', function(){
            jQuery('div.login_overlay').remove();
            jQuery('form#login').hide();
        });
        e.preventDefault();
    });

    if(jQuery('#edit_profile #living_status').val() == 'yes') {
        // Registration Family Details
        jQuery(document).delegate('a.add_new_spouse', 'click', function(e) {
            e.preventDefault();
            var content = jQuery(this).parent('.input-group').parent('.row.spouse_details'),
            size = jQuery('.family-details > .row.spouse_details').length + 1,
            element = null,
            element = content.clone().insertAfter(".row.spouse_details:last-of-type");
            element.attr('id', 'spouse-'+size);
            element.find('.remove_spouse_row').attr('data-id', size);
            element.appendTo('.family-details.spouse');
        });
        jQuery(document).delegate('a.remove_spouse_row', 'click', function(e) {
            e.preventDefault();
            var didConfirm = confirm("Are you sure You want to delete");
            if (didConfirm == true) {
                var id = jQuery(this).attr('data-id');
                var targetDiv = jQuery(this).attr('targetDiv');
                jQuery('#spouse-' + id).remove();
                return true;
            } else {
                return false;
            }
        });

        jQuery(document).delegate('a.add_new_child', 'click', function(e) {
            e.preventDefault();
            var content = jQuery(this).parent('.input-group').parent('.row.child_details'),
            size = jQuery('.family-details.child > .row.child_details').length + 1,
            element = null,
            element = content.clone().insertAfter(".row.child_details:last-of-type");
            element.attr('id', 'child-'+size);
            element.find('.remove_child_row').attr('data-id', size);
            element.appendTo('.family-details.child');
        });
        jQuery(document).delegate('a.remove_child_row', 'click', function(e) {
            e.preventDefault();
            var didConfirm = confirm("Are you sure You want to delete");
            if (didConfirm == true) {
                var id = jQuery(this).attr('data-id');
                var targetDiv = jQuery(this).attr('targetDiv');
                jQuery('#child-' + id).remove();
                return true;
            } else {
                return false;
            }
        });
    }
    
    jQuery('#living_status').on('change', function(){
        if(jQuery(this).val() == 'yes') {
            jQuery('.with_family_details').slideDown(400);
            jQuery('.spouse-name').addClass("required");
            jQuery('.child-name').addClass("required");

            // Registration Family Details
            jQuery(document).delegate('a.add_new_spouse', 'click', function(e) {
                e.preventDefault();
                var content = jQuery(this).parent('.input-group').parent('.row.spouse_details'),
                size = jQuery('.family-details > .row.spouse_details').length + 1,
                element = null,
                element = content.clone().insertAfter(".row.spouse_details:last-of-type");
                element.attr('id', 'spouse-'+size);
                element.find('.remove_spouse_row').attr('data-id', size);
                element.appendTo('.family-details.spouse');
            });
            jQuery(document).delegate('a.remove_spouse_row', 'click', function(e) {
                e.preventDefault();
                var didConfirm = confirm("Are you sure You want to delete");
                if (didConfirm == true) {
                    var id = jQuery(this).attr('data-id');
                    var targetDiv = jQuery(this).attr('targetDiv');
                    jQuery('#spouse-' + id).remove();
                    return true;
                } else {
                    return false;
                }
            });

            jQuery(document).delegate('a.add_new_child', 'click', function(e) {
                e.preventDefault();
                var content = jQuery(this).parent('.input-group').parent('.row.child_details'),
                size = jQuery('.family-details.child > .row.child_details').length + 1,
                element = null,
                element = content.clone().insertAfter(".row.child_details:last-of-type");
                element.attr('id', 'child-'+size);
                element.find('.remove_child_row').attr('data-id', size);
                element.appendTo('.family-details.child');
            });
            jQuery(document).delegate('a.remove_child_row', 'click', function(e) {
                e.preventDefault();
                var didConfirm = confirm("Are you sure You want to delete");
                if (didConfirm == true) {
                    var id = jQuery(this).attr('data-id');
                    var targetDiv = jQuery(this).attr('targetDiv');
                    jQuery('#child-' + id).remove();
                    return true;
                } else {
                    return false;
                }
            });

        } else {
            jQuery('.with_family_details').slideUp(400);
            jQuery('.spouse-name').removeClass("required");
            jQuery('.child-name').removeClass("required");
        }
    });
});