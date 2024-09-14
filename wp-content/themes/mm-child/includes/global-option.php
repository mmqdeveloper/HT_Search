<?php
function mm_register_meta_boxes_global_option() {
   add_meta_box('mm_metaboxes_option', __('Global Option', 'avia_framework'), 'mm_metabox_golbal_option_form', array('page', 'post', 'product'), 'normal', 'low');
}

add_action('add_meta_boxes', 'mm_register_meta_boxes_global_option');

if (!function_exists('mm_metabox_golbal_option_form')) {

   function mm_metabox_golbal_option_form() {
      global $post;
      $section_footer = get_post_meta($post->ID, 'mm_disable_section_footer', true);
      $PageClass = get_post_meta($post->ID, 'mm_page_class', true);
      ?>
      <div class="meta-box">

         <div class="rwmb-field rwmb-select-wrapper" style="padding-bottom: 15px;">
            <div class="rwmb-label">
               <strong><?php esc_html_e('Footer Setting', 'avia_framework'); ?></strong>
            </div>
            <div class="rwmb-input">
               <label><input type="checkbox" name="mm_disable_section_footer" value="Yes" <?php if($section_footer=='Yes') echo 'checked';  ?>>Disable widget Section Footer</label>
            </div>
         </div>
         <div class="rwmb-field rwmb-select-wrapper">
            <div class="rwmb-label">
               <strong for="page-class-custom"><?php esc_html_e('Page Class', 'avia_framework'); ?></strong>
            </div>
            <div class="rwmb-input">
               <input id="page-class-custom" type="text" name="mm_page_class" value="<?php echo esc_attr($PageClass); ?>">
               <p class="description"><?php esc_html_e('Add page class', 'avia_framework'); ?></p>
            </div>
         </div>
      </div>
      <?php
   }

}

// Save meta values
if (!function_exists('mm_save_metadata_global_option')) {

   function mm_save_metadata_global_option($post_id, $post) {
      if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
         return;
      }
      if ( ! isset( $_POST['mm_page_class'] ) ) {
         return;
      }
      if (!current_user_can('edit_post', $post->ID)) {
         return $post->ID;
      }
      update_post_meta($post->ID, 'mm_page_class', $_POST['mm_page_class']);
      update_post_meta($post->ID, 'mm_disable_section_footer', $_POST['mm_disable_section_footer']);

   }

}
add_action('save_post', 'mm_save_metadata_global_option', 10, 2);
