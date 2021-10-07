(function(){
    "use strict";

     
      // jQuery("body").on("click",".dropdown-menu a", function(e){
      //    e.preventDefault();
      //    var text = jQuery(this).html();
      //    var fb = jQuery(this).closest('.dropdown');
      //    jQuery(fb).find('button').html(text);
        
      // });

      //Onchange district
      jQuery( document ).ready(function() {
         jQuery('form.wpf_form').addClass('row');
         
         jQuery.ajax({
            type : "post",
            dataType : "json",
            url : _ajax.ajaxurl,
            data : {action: "update_instruments", rule:'update_district'},
            success: function(response) {
             //  jQuery('select.wpf_form_control.disticts').append('<option value="0">Select District</option>');
              // console.log(response.districts);
               jQuery.each( response.districts, function( i, item ) {
                  console.log(item.id);
                  jQuery('select.wpf_form_control.disticts').append('<option value="'+item.value+'" data-post="'+item.id+'">'+item.value+'</option>');
                  jQuery('select.wpf_form_control.disticts').selectpicker('refresh');
            });
            }
         })
      });
      
      jQuery('#district').change(function(e){
         var postid = jQuery(this).val();
         jQuery.ajax({
            type : "post",
            dataType : "json",
            url : _ajax.ajaxurl,
            data : {action: "update_instruments", post_id : postid},
            success: function(response) {
            console.log(response);
               //update session dropdown
               if(response.session) {
                  jQuery('#sessions').html('');
                     jQuery.each( response.session, function( i, item ) {
                        jQuery('#sessions').append('<option value="'+i+'">'+item+'</option>');
                        jQuery('#sessions').selectpicker('refresh');
                  });
               } 
               /////
               ////update instruments
               if(response.items) {
                  jQuery('#instruments').html('');
                     jQuery.each( response.items, function( i, item ) {
                        jQuery('#instruments').append('<option value="'+item+'">'+item+'</option>');
                        jQuery('#instruments').selectpicker('refresh');
                  });
               }
               /////
               ////Update sizes
               if(response.sizes) {
                  jQuery('#size').html('');
                     jQuery.each( response.sizes, function( i, item ) {
                        jQuery('#size').append('<option value="'+i+'">'+item+'</option>');
                        jQuery('#size').selectpicker('refresh');
                  });
               }
               ///
               ////Update rent terms
               if(response.rterm) {
                  jQuery('#terms').html('');
                     jQuery.each( response.rterm, function( i, item ) {
                        jQuery('#terms').append('<option value="'+i+'">'+item+'</option>');
                        jQuery('#terms').selectpicker('refresh');
                  });
               }
               ///
            }
         }) 
       });
       /////
       ///on change items
       jQuery("body").on("change","#instruments", function(e){
      
         var postid  =  jQuery('#instrument').attr('data-post');
         console.log(postid);
         var data_value    =  jQuery(this).val();
         jQuery.ajax({
            type : "post",
            dataType : "json",
            url : _ajax.ajaxurl,
            data : {action: "update_instruments", rule:'update_size_terms', data_value:data_value, post_id:postid},
            success: function(response) {
               ////
               if(response.sizes) {
                  jQuery('#size').html('');
                     jQuery.each( response.sizes, function( i, item ) {
                        jQuery('#size').append('<option value="'+i+'">'+item+'</option>');
                        jQuery('#size').selectpicker('refresh');
                  });
               }
               /////
               if(response.rterm) {
                  jQuery('#terms').html('');
                     jQuery.each( response.rterm, function( i, item ) {
                        jQuery('#terms').append('<option value="'+i+'">'+item+'</option>');
                        jQuery('#terms').selectpicker('refresh');
                  });
               }
            }
         }) 
      });  

   
    

  })();
  