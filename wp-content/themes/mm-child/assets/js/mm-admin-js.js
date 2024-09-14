
function disable_mce_editor_tabs() {
	if(jQuery('#yikes_woocommerce_custom_product_tabs').length){
		jQuery('#yikes_woocommerce_custom_product_tabs .wp-editor-tabs').each(function () {
			
			jQuery(this).find('.switch-html').trigger('click');
			jQuery(this).find('.switch-tmce').css('display','none');
			
		});
	}
}
//jQuery(document).ready(disable_mce_editor_tabs);
//jQuery(window).on('load', disable_mce_editor_tabs);