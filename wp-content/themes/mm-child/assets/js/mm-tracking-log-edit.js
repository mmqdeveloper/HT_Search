jQuery(document).ready(function($){
    // save setting tracking log
    const mm_setting_tracking_log_form = $('#mm_setting_tracking_log_form');
    if (mm_setting_tracking_log_form.length > 0) {
        mm_setting_tracking_log_form.submit(function(e) {
            e.preventDefault();
            $('#mm_setting_tracking_log_notification').html('<span class="mm-tracking-log-notification-loading"></span> <span style="margin-left: 10px;">Saving</span>');
            let postTypeSelected = $(this).find('input[name="mm_setting_tracking_log_post_type"]:checked');
            let postTypeSelectedValue = postTypeSelected.map(function() {
                return this.value;
            }).get();
            let rolesSelected = $(this).find('input[name="mm_setting_tracking_log_roles"]:checked');
            let rolesSelectedValue = rolesSelected.map(function() {
                return this.value;
            }).get();
            let showPopupNote = $(this).find('input[name="mm_setting_tracking_log_show_popup_note"]:checked').val();
            let trackingAddonProduct = $(this).find('input[name="mm_setting_tracking_log_product_addon"]:checked').val();
            let trackingThemeOptions = $(this).find('input[name="mm_setting_tracking_log_theme_options"]:checked').val();
            let trackingResource = $(this).find('input[name="mm_setting_tracking_log_resource"]:checked').val();
            $.ajax({
                type : "post",
                dataType : "html",
                url : ajax_mm_tracking_log_edit_js.ajax_url,
                data : {
                    action: "mm_save_setting_tracking_log",
                    postTypeSelected: postTypeSelectedValue,
                    rolesSelected: rolesSelectedValue,
                    showPopupNote: showPopupNote,
                    productAddon: trackingAddonProduct,
                    themeOptions: trackingThemeOptions,
                    resource: trackingResource
                },
                success: function(response) {
                    if( response !== ''){
                        $('#mm_setting_tracking_log_notification').html('<p style="padding: 7px 10px;background-color:#28a745;color:#fff;">Saved successfully.</p>');         
                        setTimeout(function () {
                            $('#mm_setting_tracking_log_notification').html('');
                        }, 5000);           
                    }
                },
                error: function( jqXHR, textStatus, errorThrown ){
                    
                }
            });
        });
    }

    // save note before update
    const mm_tracking_edit_log_popup_note_form = $('#mm-tracking-edit-log-popup-note-form');
    if (mm_tracking_edit_log_popup_note_form.length > 0) {
        mm_tracking_edit_log_popup_note_form.submit(function(e) {
            e.preventDefault();
            
            let note = $(this).find('#mm-tracking-edit-log-popup-note').val();
            let id_post = $(this).find('#mm-tracking-edit-log-popup-note-id-post').val();

            if (!note) {
                $(this).find('#mm-tracking-edit-log-notification').html('<span>Please entering notes</span>');
                return;
            } else {
                $(this).find('#mm-tracking-edit-log-notification').html('<span class="mm-tracking-log-notification-loading"></span>');
            }

            $.ajax({
                type : "post",
                dataType : "html",
                url : ajax_mm_tracking_log_edit_js.ajax_url,
                data : {
                    action: "mm_save_tracking_log_note",
                    mm_tracking_log_note: note,
                    mm_tracking_log_note_id_post: id_post
                },
                success: function(response) {
                    $('.mm-tracking-edit-log-popup-note-wrap').addClass('skiped');
                    $('#publishing-action input[type="submit"][name="save"]').click();
                },
                error: function( jqXHR, textStatus, errorThrown ){
                    
                }
            });
        });
    }
});