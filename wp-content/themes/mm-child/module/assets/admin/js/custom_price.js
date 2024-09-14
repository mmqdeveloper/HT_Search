(function ($) {
    "use strict";

    jQuery(document).on('ready', function () {
        jQuery("input.add-new-custom-price").click(function () {
            var count_item = jQuery('#custom_price_panel .mm-custom-item').length;
            var data_item = count_item;
            var get_html = jQuery('#custom_price_panel .mm-custom-item').html();
            get_html = get_html.replace('data-item="0"', 'data-item="' + data_item + '"');
            get_html = get_html.replace('mm_custom_price[0][price]', 'mm_custom_price[' + data_item + '][price]');
            get_html = get_html.replace('mm_custom_price[0][person]', 'mm_custom_price[' + data_item + '][person]');
            get_html = get_html.replace('mm_custom_price[0][resource]', 'mm_custom_price[' + data_item + '][resource]');
            get_html = '<div class="mm-custom-item" data-item="' + data_item + '">' + get_html + '</div>';
            jQuery("#custom_price_panel .options_group").append(get_html);
            jQuery('#custom_price_panel input[name="mm_custom_price[' + data_item + '][price]"]').val('');
            jQuery('#custom_price_panel select[name="mm_custom_price[' + data_item + '][person]"]').val('');
            jQuery('#custom_price_panel select[name="mm_custom_price[' + data_item + '][resource]"]').val('');
        });
        jQuery(document).on('click', 'input.remove-custom-price', function (e) {
            if (jQuery('.mm-custom-item').length > 1) {
                jQuery(this).closest('.mm-custom-item').remove();
            }else{
				jQuery('#custom_price_panel #person').val('');
				jQuery('#custom_price_panel #resource').val('');
				jQuery('#custom_price_panel input[type="text"]').val('');
			}
        });

    });
})(jQuery);
