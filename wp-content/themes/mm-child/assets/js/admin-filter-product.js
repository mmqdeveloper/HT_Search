jQuery(document).ready(function ($) {
    jQuery('#aviaTBsort_tag_name-form-container').attr('disabled','disabled');   
    var optVal = [];
    var tempVal = [];
    var textVal = [];
    jQuery(document).on('change', '#aviaTBmm_tag', function (e) {
        $("#aviaTBmm_tag option").each(function () {
            var val = jQuery(this).val();
            var text = jQuery(this).text();
            var tempVal = jQuery("#aviaTBmm_tag").val();

            if (tempVal.indexOf(val) >= 0 && optVal.indexOf(val) < 0) {
                optVal.push(val);
                textVal.push(text);
            } else if (tempVal.indexOf(val) < 0 && optVal.indexOf(val) >= 0) {
                optVal.splice(optVal.indexOf(val), 1);
                textVal.splice(textVal.indexOf(text), 1);
            }

        });
//        console.log("Opt: " + optVal);
        jQuery('#aviaTBsort_tag_name').val(textVal.join(","));
        jQuery('#aviaTBsort_tag').val(optVal.join(","));
    });

    //fix faq search
    var faq_error = new RegExp('(^[0-9]+[.][ ]|^[0-9]+[.][ ][0-9]*)$');
    jQuery('.column-pp_faq div').each(function () {
        var faq_text = jQuery(this).children('a').text();
        if(faq_error.test(faq_text)){
            jQuery(this).closest('div').addClass("hidden-title-faq");
        }
    });
});

