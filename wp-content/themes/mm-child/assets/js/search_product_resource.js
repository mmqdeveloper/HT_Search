// window.addEventListener('load', function () {
//     var input = document.createElement("input");
//     input.setAttribute("type", "text");

//     var select = document.querySelector(".add_resource_id");
//     select.parentNode.insertBefore(input, select);

//     input.addEventListener("keyup", function() {
//         let filter = input.value.toLowerCase();
//         let options = select.getElementsByTagName("option");
//         for (let i = 0; i < options.length; i++) {
//             let text = options[i].text.toLowerCase();
//             let match = text.indexOf(filter) >= 0;
//             options[i].style.display = match ? "" : "none";
//         }
//     });
// });

jQuery(document).ready(function ($) {
    $('.add_resource_id').select2({
        width: '100%',
        'font-size': '14px',
        'margin': '10px 0 16px',
        containerCssClass: 'admin_product_custom_resource',
        "dropdownCss": { "border": "none" },
        "dropdownCss": { "box-shadow": "none" },
        "dropdownCss": { "border-color": "none" },
        dropdownCssClass: "admin_product_custom_resource_dropdown"
    });
});