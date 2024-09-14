var mm_customDatePicker = Marionette.Object.extend( {
    initialize: function() {
        // Listen to our date pickers as they are created on the page.
        this.listenTo( Backbone.Radio.channel( 'pikaday' ), 'init', this.modifyDatepicker );
    },
 
    modifyDatepicker: function( dateObject, fieldModel ) {
        
        // Limit Ninja Forms Flatpickr datepicker to current and future dates
        //console.log(fieldModel);
        var get_key = fieldModel.attributes.key;
        if(get_key.indexOf("travel_date") >= 0 || get_key.indexOf("tour_date") >= 0  || get_key.indexOf("date_of_travel") >= 0){
            dateObject.set(
                "minDate", new Date()          
            );
        }
    }
});
jQuery(document).ready(function($) {
    new mm_customDatePicker();
});