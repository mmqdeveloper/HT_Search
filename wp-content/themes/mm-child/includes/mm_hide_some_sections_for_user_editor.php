<?php

if (is_admin()) {
    if (!function_exists('mm_hide_some_sections_for_user_editor')) {
        function mm_hide_some_sections_for_user_editor () {
            if (current_user_can( 'editor' )) {
                ?>
                    <style>
                        
                        #mm_metaboxes_option.postbox,
                        #admin-speedup-postcustom.postbox,
                        #revisionsdiv.postbox,
                        #ht_custom_content_email_meta_box.postbox,
                        #slider_revolution_metabox.postbox,
                        
                        #revisionsdiv-wp-rev-ctl.postbox {
                            display: none;
                        }
                    </style>
                <?php
            }
        }
        add_action('admin_head', 'mm_hide_some_sections_for_user_editor');
    }
}