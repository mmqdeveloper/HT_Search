(function ($) {
    "use strict";

    jQuery(document).on('ready', function () {
        if ($('#submitdiv #submitpost #major-publishing-actions').length) {
            var mmSubmitDiv = jQuery(".mm-scroll-to-update");
            if (mmSubmitDiv.length) {
                jQuery("html, body").animate({ scrollTop: mmSubmitDiv.offset().top }, 1000);
            }

            jQuery( document ).scroll( function (e) {
                var scrollPosition = jQuery(window).scrollTop();
                var mmScrollToUpdate = jQuery( '.mm-scroll-to-update' );
                if (scrollPosition >= 500) {
                    
                    if(!mmScrollToUpdate.length){
                        var newElement = jQuery('<a>', {
                            href: '#',
                            class: 'mm-scroll-to-update button-primary',
                            text: ''
                        });
                        
                        jQuery('body').append(newElement);
                    }
                }else{
                    if(mmScrollToUpdate.length){
                        mmScrollToUpdate.remove();
                    }
                }
            });
        }
        if ($('#mmt_add_on_options').length) {
            $(document.body).on('click', '.mmt-header-arrow', function () {
                $(this).parent().parent().parent().find('.mmt-body').toggleClass('toggle-arrow');
            });

            $(document.body).on('change', '.mmt_days_wrap .mmt_date_field input[type="checkbox"]', function () {
                $(this).parent().parent().toggleClass('selected');
            });
        }
        jQuery("#fee_settings_select_fee_type").click(function () {
            var fee_type = jQuery(this).val();
            if(fee_type!='percentage'){
                    jQuery('.fee_per_person').show();
            }else{
                    jQuery('.fee_per_person').hide();
            }
        });
        
        //Audited
        jQuery("body").on("click",".mm-audited-field .audited-content", function (e) {
            e.preventDefault();
            if(jQuery("#edit_mm_audited").length) {
                jQuery('#edit_mm_audited').remove();
            }
            var audited = jQuery(this).closest('.mm-audited-field').data('content');
            jQuery(this).closest('.mm-audited-field').append('<div id="edit_mm_audited"><input type="text" id="input_audited_field" name="input_audited_field" value="'+audited+'"><div id="audited_buttons_wrapper"><div id="audited_buttons"><button id="audited_cancel"><span class="dashicons dashicons-no-alt"></span></button><button id="audited_save"><span class="dashicons dashicons-yes"></span></button></div></div></div>');
            return false;
        });
        jQuery("body").on("click",".mm-audited-field input", function (e) {
            e.preventDefault();
            return false;
        });
        jQuery("body").on("click","#edit_mm_audited #audited_cancel .dashicons ", function(e) {
            e.preventDefault();
            jQuery(this).closest('#edit_mm_audited').remove();
            return false;
        });
        jQuery("body").on("click","#edit_mm_audited #audited_save .dashicons ", function(e) {
            e.preventDefault();
            var postid = jQuery(this).closest('.mm-audited-field').data('post_id');
            var audited = jQuery(this).closest('.mm-audited-field').find('#input_audited_field').val();
            jQuery(this).closest('.mm-audited-field').find('.audited-content').find('span').text(audited);
            jQuery(this).closest('#edit_mm_audited').remove();
            $.ajax({
                type: 'post',
                url: mmt_ajax_obj['ajaxurl'],
                dataType: 'json',
                data: {"action": "mm_save_product_audited_field", "postid": postid, "audited": audited},
                cache: false,
                beforeSend: function () {
                    
                },
                success: function (data) {
                    
                },
                error: function (xhr, textStatus, errorThrown) {
                    
                }
            });
            return false;
        });
        jQuery( document ).on( 'keydown', function ( e ) {
            if ( e.keyCode === 27  && jQuery("#edit_mm_audited").length) { // ESC
                jQuery("#edit_mm_audited").each(function() {
                    jQuery( this).remove();
                });
            }
        });
        jQuery( document ).on( 'keydown', function ( e ) {
            if ( e.keyCode === 13  && jQuery("#edit_mm_audited").length) {
                e.preventDefault();
                jQuery("#edit_mm_audited #audited_save .dashicons").trigger('click');
                return false;
            }
        });
        jQuery("td.mm_cache.column-mm_cache span").click(function () {
            var postid = jQuery(this).data('post_id');
            var jquery_this = jQuery(this);
            $.ajax({
                type: 'post',
                url: mmt_ajax_obj['ajaxurl'],
                dataType: 'json',
                data: {"action": "mm_clear_cache_product", "postid": postid},
                cache: false,
                beforeSend: function () {
                    
                },
                success: function (data) {
                    
                    jQuery(jquery_this).remove();
                },
                error: function (xhr, textStatus, errorThrown) {
                    
                }
            });
            return false;
        });
        if (jQuery('#bookings_availability input[type=text]').length) {
            jQuery("#bookings_availability input[type=text]").each(function () {
                jQuery(this).attr('autocomplete','off');
            });
        }
        //Tag Minimum BLock
        jQuery("body").on("click",".mm_tag_minimum_block .mm_tag_min_date", function (e) {
            e.preventDefault();
            if(jQuery("#edit_mm_tag_min_date").length) {
                jQuery('#edit_mm_tag_min_date').remove();
            }
            var min_date = jQuery(this).closest('.mm_tag_minimum_block').data('min_date');
            var min_date_unit = jQuery(this).closest('.mm_tag_minimum_block').data('min_date_unit');
            var min_date_priority = jQuery(this).closest('.mm_tag_minimum_block').data('min_date_priority');
            var month_select = '';
            var week_select = '';
            var day_select = '';
            var hour_select = '';
            if(min_date_unit == 'month'){
                month_select = 'selected="selected"';
            }
            if(min_date_unit == 'week'){
                week_select = 'selected="selected"';
            }
            if(min_date_unit == 'day'){
                day_select = 'selected="selected"';
            }
            if(min_date_unit == 'hour'){
                hour_select = 'selected="selected"';
            }
            jQuery(this).closest('.mm_tag_minimum_block').append('<div id="edit_mm_tag_min_date"><input type="number" id="min_date" name="min_date" value="'+min_date+'"><select name="min_date_unit" id="min_date_unit"><option value="month" '+month_select+'>Month(s)</option><option value="week" '+week_select+'>Week(s)</option><option value="day" '+day_select+'>Day(s)</option><option value="hour" '+hour_select+'>Hour(s)</option></select><input type="number" id="min_date_priority" name="min_date_priority" value="'+min_date_priority+'"><div id="min_date_buttons_wrapper"><div id="min_date_buttons"><button id="min_date_cancel"><span class="dashicons dashicons-no-alt"></span></button><button id="min_date_save"><span class="dashicons dashicons-yes"></span></button></div></div></div>');
            return false;
        });
        jQuery("body").on("click",".mm_tag_minimum_block input, .mm_tag_minimum_block select", function (e) {
            e.preventDefault();
            return false;
        });
        jQuery("body").on("click","#edit_mm_tag_min_date #min_date_cancel .dashicons ", function(e) {
            e.preventDefault();
            jQuery(this).closest('#edit_mm_tag_min_date').remove();
            return false;
        });
        jQuery("body").on("click","#edit_mm_tag_min_date #min_date_save .dashicons ", function(e) {
            e.preventDefault();
            var term_id = jQuery(this).closest('.mm_tag_minimum_block').data('term_id');
            var min_date = jQuery(this).closest('.mm_tag_minimum_block').find('#min_date').val();
            var min_date_unit = jQuery(this).closest('.mm_tag_minimum_block').find('#min_date_unit').val();
            var min_date_priority = jQuery(this).closest('.mm_tag_minimum_block').find('#min_date_priority').val();
            if(min_date !=''){
                var mm_tag_min_date = min_date+' '+min_date_unit;
                var text_min_date_priority = min_date_priority;
            }else{
                var mm_tag_min_date = '---';
                var text_min_date_priority = '';
            }
            jQuery(this).closest('.mm_tag_minimum_block').find('.mm_tag_min_date').find('span').text(mm_tag_min_date);
            jQuery(this).closest('tr').find('.column-priority').text(text_min_date_priority);
            jQuery(this).closest('#edit_mm_tag_min_date').remove();
            $.ajax({
                type: 'post',
                url: mmt_ajax_obj['ajaxurl'],
                dataType: 'json',
                data: {"action": "mm_save_tag_min_date", "term_id": term_id, "min_date": min_date, "min_date_unit": min_date_unit, "min_date_priority": min_date_priority},
                cache: false,
                beforeSend: function () {
                    
                },
                success: function (data) {
                    
                },
                error: function (xhr, textStatus, errorThrown) {
                    
                }
            });
            return false;
        });
        jQuery( document ).on( 'keydown', function ( e ) {
            if ( e.keyCode === 27  && jQuery("#edit_mm_tag_min_date").length) { // ESC
                jQuery("#edit_mm_tag_min_date").each(function() {
                    jQuery( this).remove();
                });
            }
        });
        jQuery( document ).on( 'keydown', function ( e ) {
            if ( e.keyCode === 13  && jQuery("#edit_mm_tag_min_date").length) {
                e.preventDefault();
                jQuery("#edit_mm_tag_min_date #min_date_save .dashicons").trigger('click');
                return false;
            }
        });
        jQuery( '#sliced-create-user' ).on( 'change', '#email', function(){
        //jQuery('#sliced-create-user #email').keyup(function(e) {
            var value = jQuery(this).val();
            jQuery('.mm-useremail-error').remove();
            if(value !=''){
                $.ajax({
                    type: 'post',
                    url: mmt_ajax_obj['ajaxurl'],
                    dataType: 'json',
                    data: {"action": "mm_invoice_search_contact_hubspot", "value": value},
                    cache: false,
                    success: function (data) {
                        /*$("#sliced-create-user .mm-hub-user").html('');
                        $.each(data['data'], function( index, value ) {
                            $("#sliced-create-user .mm-hub-user").append(value);
                        });*/
                        if(data.success) {
                            var firstname = '';
                            var lastname = '';
                            if(data['data']['firstname'] !== 'undefined'){
                                firstname = data['data']['firstname'];
                                jQuery('#sliced-create-user #first_name').val(data['data']['firstname']);
                            }
                            if(data['data']['last_name'] !== 'undefined'){
                                lastname = data['data']['lastname'];
                                jQuery('#sliced-create-user #last_name').val(data['data']['lastname']);
                            }
                            if(firstname!='' || lastname!=''){
                                jQuery('#sliced-create-user input[name="_sliced_client_business"]').val(firstname+' '+lastname);
                                jQuery('#sliced-create-user input[name="user_login"]').val(value);
                            }
                        }else{
                            jQuery( "<p class='mm-useremail-error'>User existing</p>" ).insertAfter( "#sliced-create-user #email" );
                            jQuery('#sliced-update-user #sliced_update_user_user').val(data['data']['user_id']);
                            jQuery('#sliced-update-user input[name="_sliced_client_business"]').val(data['data']['company_name']);
                            jQuery('#sliced-update-user textarea[name="_sliced_client_address"]').val(data['data']['address']);
                            /*jQuery("#sliced_add_client_type_existing").click();
                            jQuery("#sliced_add_client_type_existing").prop("checked", true);
                            jQuery('#sliced-update-user .select2-selection__placeholder').text(value);*/
                            if(jQuery('#_sliced_client option[value="'+data['user_id']+'"]').length <= 0){
                                jQuery("#_sliced_client option:selected").removeAttr("selected");
                                var new_user = '<option value="'+data['data']['user_id']+'" selected>'+data['data']['company_name']+' ('+value+')</option>';
                                jQuery("#_sliced_client").append( new_user );
                                tb_remove();
                            }
                            
                        }
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        
                    }
                });
            }
        });
        jQuery("body").on("click",".mm-hub-user li:not(.choose-user)", function (e) {
            var firstname = jQuery(this).data('firstname');
            var lastname = jQuery(this).data('lastname');
            var email = jQuery(this).data('email');
            if(firstname !=''){
                jQuery('#sliced-create-user #first_name').val(firstname);
            }
            if(lastname !=''){
                jQuery('#sliced-create-user #last_name').val(lastname);
            }
            jQuery('#sliced-create-user #first_name').change();
            jQuery('#sliced-create-user #email').val(email);
            $("#sliced-create-user .mm-hub-user").html('');
        });
        jQuery( '#sliced-create-user' ).on( 'keyup change', '#first_name, #last_name', function(){
            var firstname = jQuery('#sliced-create-user #first_name').val();
            var lastname = jQuery('#sliced-create-user #last_name').val();
            var email = jQuery('#sliced-create-user #email').val();
            if(firstname !='' && lastname!=''){
                jQuery('#sliced-create-user input[name="_sliced_client_business"]').val(firstname+' '+lastname);
                jQuery('#sliced-create-user input[name="_sliced_client_business"]').change();
            }
            if(email != ''){
                jQuery('#sliced-create-user input[name="user_login"]').val(email);
            }
            
        });
        jQuery( '#sliced-update-user' ).on( 'change', '#sliced_update_user_user', function(){
            var user_id = jQuery(this).val();
            if(user_id!=''){
                $.ajax({
                    type: 'post',
                    url: mmt_ajax_obj['ajaxurl'],
                    dataType: 'json',
                    data: {"action": "mm_invoice_search_contact_for_user_id", "user_id": user_id},
                    cache: false,
                    beforeSend: function () {
                        $('input#sliced-update-user-submit').attr("disabled", true);
                    },
                    success: function (data) {
                        var address = data['data']['address'];
                        var company = data['data']['company_name'];
                        jQuery('#sliced-update-user input[name="_sliced_client_business"]').val(company);
                        jQuery('#sliced-update-user textarea[name="_sliced_client_address"]').val(address);
                        $('input#sliced-update-user-submit').attr("disabled", false);
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        
                    }
                });
            }
        });
        if(jQuery('#acf-group_65138ead4a8c7').length){
            jQuery('#normal-sortables #acf-group_65138ead4a8c7').insertBefore(jQuery('#normal-sortables #wpseo_meta'));
        }
    });

    if (jQuery('#filter_tags_product').length) {
        jQuery('#filter_tags_product').select2();
    }

    $('#mm_export_product_fhdn_form').submit(function (e) {
        e.preventDefault();
        jQuery.ajax({
            type : "post",
            dataType : "html",
            url : mmt_ajax_obj['ajaxurl'],
            data : {
                action: "mm_handle_export_product_fhdn",
                mm_export_product_fhdn: "export"
            },
            beforeSend: function(){
                $('#mm_export_product_fhdn_form').append( $('<span id="mm_export_product_fhdn_loading">Loading....</span>') );
            },
            success: function(response) {
                $('#mm_export_product_fhdn_loading').remove();
                $('#mm_export_product_fhdn_form').append( $(`<span id="mm_export_product_fhdn_done">Done (Download In Folder Uploads mm_export_product_fhdn filename: ${response})</span>`) );
            },
        });
    }); 
})(jQuery);
