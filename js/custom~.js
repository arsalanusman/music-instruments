(function(){
   "use strict";
     jQuery('#district').change(function(e){
        var postid = jQuery(this).val();
        jQuery.ajax({
           type : "post",
           dataType : "json",
           url : _ajax.ajaxurl,
           data : {action: "update_instruments", rule:'changedistrict', post_id : postid},
           success: function(response) {
           //console.log(response);
              //update session dropdown
              if(response.session) {

                 jQuery('#sessions').html('');
                 jQuery('#sessions').append('<option value="">Select a Session</option>');
                    jQuery.each( response.session, function( i, item ) {
                       jQuery('#sessions').append('<option value="'+item+'">'+item+'</option>');
                       jQuery('#sessions').selectpicker('refresh');
                       jQuery('#sessions').trigger('change');
                       jQuery('#district').attr('data-did',   response.postid);
                       jQuery('#district').attr('data-title', response.post_title);
                       

                 });
              } 
              /////
              ////update instruments
              if(response.items) {
                 //console.log(response.postid);
                 jQuery('#instruments').attr('data-post', response.postid);
                 jQuery('#instruments').html('');
                    jQuery.each( response.items, function( i, item ) {
                       jQuery('#instruments').append('<option value="'+item+'">'+item+'</option>');
                       jQuery('#instruments').selectpicker('refresh');
                       jQuery('#instruments').trigger('change');
                 });
              }
              /////
              ////Update sizes
              if(response.sizes) {
                 jQuery('#size').html('<option value="0">Choose Size </option>');
                    jQuery.each( response.sizes, function( i, item ) {
                       jQuery('#size').append('<option value="'+i+'">'+item+'</option>');
                       jQuery('#size').selectpicker('refresh');
                      // jQuery('#size').trigger('change');
                 });
              }
              ///
              ////Update rent terms 
              if(response.rterm != '') {
                 jQuery('#box-rental, #box-optional').css('display','block');
                 //jQuery('#terms').html('<option value="0">Choose Rent Terms</option>');
                 jQuery('#termlist').html('');
                    jQuery.each( response.rterm, function( i, item ) {
                       //console.log(item.term_value);
                      // jQuery('#terms').append('<option value="'+item.term_value+'">'+item.tern_name+'</option>');
                       //jQuery('#terms').selectpicker('refresh');
                       //jQuery('#terms').trigger('change');
                       jQuery('#termlist').append('<p id="checked"><input type="radio" data-name="'+item.tern_name+'" class="require" name="terms" id="terms" value="'+item.term_value+'"/> <label>'+item.tern_name+' </label></p><p style="font-size: 14px;font-weight: bold;">'+response.term_ins+'</p>');
                       jQuery('#termlist p#checked input').click();
                    });
                 
                
              }else{
                 jQuery('#box-rental, #box-optional').css('display','none');
              }
              ///
              ///update optionals
              if(response.optional.length !=0 || response.optional == 'undefine' ) {
                 jQuery('#optionsl_list').css('display','block');
                 jQuery('#optionals').html('');
                 
                 jQuery.each( response.optional, function( i, item ) {

                  jQuery('#optionals').append(
                    '<div class="form-check" id="'+i+'opt">'
                       +'<input class="form-check-input _optionals_" type="checkbox" name="optionsls[]" value="'+i+'" id="'+i+'" data-name="'+item.name+'">'
                       +'<label class="" for="'+i+'">'+item.name+' <strong>$'+item.price+'</strong> </label></div>');
                 
                       if(item.colors) {
                          jQuery('#'+i+'opt').append('<select class="selectpicker form-control" name="colors"  id="colors"><option value="" >Choose Color</option></select>');
                          jQuery.each( item.colors, function( c,n ) {
                             jQuery('#'+i+'opt #colors' ).append('<option value="'+n+'">'+n+'</option>');
                          });
                         
                       }
                       jQuery('#colors').selectpicker('refresh');
                    });
              }else{
                 jQuery('#optionals').html('');
                 jQuery('#optionsl_list').css('display','none');
              }

              /*Require Book*/

              if(response.require_book.length !=0 || response.require_book == 'undefine' ) {
                 jQuery('#require_book').css('display','block');
                 jQuery('#require_book .items').html('');
                 
                 jQuery.each( response.require_book, function( i, item ) {
                  jQuery('#require_book .items').append(
                    '<div class="form-check" id="'+i+'opt">'
                       +'<input class="form-check-input _optionals_" type="checkbox" name="optionsls[]" value="'+i+'" id="'+i+'" data-name="Required Books-'+item.name+'">'
                       +'<label class="" for="'+i+'">'+item.name+' <strong>$'+item.price+'</strong> </label></div>');
                 
                       if(item.colors) {
                          jQuery('#'+i+'opt').append('<select class="selectpicker form-control" name="colors"  id="colors"><option value="" >Choose Color</option></select>');
                          jQuery.each( item.colors, function( c,n ) {
                             jQuery('#'+i+'opt #colors' ).append('<option value="'+n+'">'+n+'</option>');
                          });
                         
                       }
                       jQuery('#colors').selectpicker('refresh');
                    });
              }else{
                 jQuery('#require_book .items').html('');
                 jQuery('#require_book').css('display','none');
              }





           }
        }) 

        setTimeout(function(){ 
         
         }, 2000);
      });

      /////
      ///on change items
      jQuery("body").on("change","#instruments", function(e){
        var postid  =  jQuery('#instruments').attr('data-post');
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
                       jQuery('#size').append('<option value="'+item+'">'+item+'</option>');
                       jQuery('#size').selectpicker('refresh');
                       //jQuery('#size').trigger('change');
                       
                 });
              }
              /////
              if(response.rterm) {
                 jQuery('#terms').html('');
                 jQuery('#termlist').html('');
                    jQuery.each( response.rterm, function( i, item ) {
                      // jQuery('#terms').append('<option value="'+item.term_value+'">'+item.tern_name+'</option>');
                     //  jQuery('#terms').selectpicker('refresh');
                     //  jQuery('#terms').trigger('change');
                     jQuery('#termlist').append('<p id="checked"><input type="radio" data-name="'+item.tern_name+'" class="require" name="terms" id="terms" value="'+item.term_value+'"/> <label>'+item.tern_name+' </label></p><p style="font-size: 14px;font-weight: bold;">'+response.term_ins+'</p>');
                     jQuery('#termlist p#checked input').click();
                    });
                  }

                  jQuery('#size_options').html('');
              if(response.extra_optionals.length !=0 || response.extra_optionals == 'undefine' ) {
                       
               jQuery('#optionsl_list').css('display','block');
               jQuery.each( response.extra_optionals, function( i, item ) {
                    jQuery('#size_options').append(
                     '<div class="form-check" id="'+i+'opt">'
                        +'<input class="form-check-input _optionals_" type="checkbox" name="extra_optionals[]" value="'+item.acf_feild+'" id="'+i+'" data-name="'+item.name+'" data-arrayoff="'+item.name+'">'
                        +'<label class="" for="'+i+'">'+item.name+' <strong>$'+item.price+'</strong> </label></div>');
                              
               }); 

               }else{
                     jQuery('#size_options').html('');
               }
                jQuery('#size').change();
           } 
        }) 
        setTimeout(function(){  
          
           //console.log('trigger');
        }, 2000);
     });   

     


     //Trigger to District
     jQuery( document ).ready(function() {
        //jQuery('#district').prop('selectedIndex',1);
        //jQuery('#district').trigger('change');

        jQuery('.wpf_form').submit(function(e){
        

        });

        
       
      //  setTimeout(function(){ 
           jQuery("body").on("click","#submitbooking", function(e){
              var require = jQuery('#booking').find('input.require, select.require');
              
              //var require = jQuery('#booking').find('.require');
              var validate = 1;
              jQuery(require).each(function(){
                 var data = jQuery(this).val();
                 var dataname = jQuery(this).attr('name');
               //  console.log(data + ' = ' + dataname);
                 if(data == '' ) {
                    jQuery(this).parent().addClass('error');
                 }else{
                    jQuery(this).parent().removeClass('error');
                 }
              });


           var checkedState  = jQuery('input[name="agree"]').is(":checked");
           var termset       = jQuery('input[name="terms"]').is(":checked");
           //var options       = jQuery('input[name="optionsls[]"]').is(":checked");
           
           jQuery('#optionals input').each(function(){
              var options = jQuery(this).is(":checked");

              if(options) {
                 //jQuery(this).parent().removeClass('error');
              }else{
                // jQuery(this).parent().addClass('error');
               }

             
           });
          // console.log(options);
             if(checkedState) {
                 jQuery('#agreecheck').removeClass('error');
             }else{
                 jQuery('#agreecheck').addClass('error');
             }

             if(termset) {
                 jQuery('#termlist input').removeClass('error');
              }else{
                 jQuery('#termlist input').addClass('error');
               }


               


             var errors = jQuery('#booking').find('.error');

             if(errors.length >= 1){
                 validate = 1;
                 jQuery('html, body').animate({scrollTop: jQuery(".error").offset().top-100 }, 500);
                 return ;
              }             
             

             var emailaddress  = jQuery('#wpf_customer_email').val();
             var phone         = jQuery('#phone_number').val();
             var name          = jQuery('#student_name').val() + ' '+jQuery('#student_last_name').val();
            
             setTimeout(function(){
                 if (jQuery('div[name="stripe_card_element"]').hasClass('StripeElement--invalid') || jQuery('div[name="stripe_card_element"]').hasClass('StripeElement--empty') ) {
                    validate = 1;
                    jQuery('html, body').animate({scrollTop: jQuery('div[name="stripe_card_element"]').offset().top-100 }, 500);
                    jQuery('div[name="stripe_card_element"]').css('border', '1px solid red');
                   // console.log('payment failed');
                 }else{
                    validate = 0;
                 }

                 if(validate == 0){
                    if( !validateEmail(emailaddress)) {
                       jQuery('#wpf_customer_email').parent().addClass('error');
                       jQuery('html, body').animate({scrollTop: jQuery(".error").offset().top }, 500);
                       validate = 1;
                    // jQuery('.loader').fadeOut();
                    } else {
                    jQuery.ajax({
                          type : "post",
                          url : _ajax.ajaxurl,
                          data : {action: "get_customer", email:emailaddress,name:name,phone:phone},
                          success: function(response) {
                             ////
                             jQuery('#wpf_input_288_hidden_input_18').val(response);
                             jQuery('.wpf_submit_button').click();
                          }
                    }); 
                    }
                 }
              }, 500);

             



              
             

        
           
              // jQuery.ajax({
              //    type : "post",
              //    // dataType : "json",
              //    url : _ajax.ajaxurl,
              //    data : {action: "custom_submit"},
              //    success: function(response) {
              //       console.log(response);
              //    }
              // }) 


           });
        // }, 1000);

     }); 
     
     function validateEmail($email) {
         var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
         return emailReg.test( $email );
       }
     jQuery("body").on("change","select.require, input.require, #alt_phone", function(e){
       
            
        var changeid = jQuery(this).attr('id');
        var data = jQuery(this).val();
        
        var dis = jQuery('#district').attr('data-title');
        //console.log('sasas'+dis);
        
        if(data == '' ) {
           jQuery(this).parent().addClass('error');
          // console.log('empty');
        }else{
           jQuery(this).parent().removeClass('error');
        }

       
        
        if(jQuery('#phone_number').val() == jQuery('#alt_phone').val() && jQuery('#phone_number').val() != '' ) {
            jQuery('#phone_number').parent().addClass('error');
            jQuery('#alt_phone').parent().addClass('error');
        }else{
         jQuery(this).parent().removeClass('error');
            jQuery('#alt_phone').parent().removeClass('error');
            jQuery('#phone_number').parent().removeClass('error');
        }
        
        jQuery('input.'+changeid).val(data);
        jQuery('input.district').val(dis);
     });

     


     jQuery("body").on("change","textarea", function(e){
        var changeid = jQuery(this).attr('id');
        var data = jQuery(this).val();
        
        if(data == '' ) {
           jQuery(this).parent().addClass('error');
          // console.log('empty');
        }else{
           jQuery(this).parent().removeClass('error');
          // console.log(changeid);
        }

        jQuery('textarea.'+changeid).val(data);
     }); 

     jQuery("body").on("change","date", function(e){
        var changeid = jQuery(this).attr('id');
        var data = jQuery(this).val();

        if(data == '' ) {
           jQuery(this).parent().addClass('error');
          // console.log('empty');
        }else{
           jQuery(this).parent().removeClass('error');
        }
        jQuery('texarea.'+changeid).val(data);
     });


     //trigger to classes
     jQuery("body").on("change","select", function(e){
        var changeid = jQuery(this).attr('id');
        var values = jQuery(this).find('option:selected').html();
        var textval = jQuery(this).val();
        //console.log(values);
        jQuery('input.'+changeid).val(values);
        jQuery('input.'+changeid).val(textval);
     });
     
     jQuery("body").on("change","#terms", function(e){
        var did           =  jQuery('#district').attr('data-did');
        var instruments   =  jQuery('#instruments').val();
        //var terms         =  jQuery(this).find('option:selected').html(); 
        
        var terms = jQuery('input#terms:checked').map(function() {
           return this.value;
        }).get();


       



        var vals = jQuery('input._optionals_:checked').map(function() {
           return this.value;
         }).get();
         var name = jQuery('input._optionals_:checked').map(function() {
           return jQuery(this).data('name');
         }).get();
        
     
      


         jQuery('input.optional_aceess').val(name);

        //console.log(arroff);
         var size_val = jQuery('#size').val();
        jQuery.ajax({
           type : "post",
           dataType : "json",
           url : _ajax.ajaxurl,
           data : {action: "update_instruments", rule:'get_price', post_id:did, instruments:instruments, terms:terms[0], optname:vals, size_val:size_val},
           success: function(response) {             
              console.log(response.postid);
              if(response){
                 if(response.options_name) {
                    jQuery('#ess_amount').html('');
                    jQuery.each( response.options_name, function( i, item ) {
                       if(item.type == 'reuirebook'){
                          jQuery('#ess_amount').append('<p>Require Book -  <strong>$'+ item.opt_price +'</strong> '+ item.opt_name +'</p>');
                       }else{
                          jQuery('#ess_amount').append('<p>Optionals - <strong>$'+ item.opt_price +'</strong> '+ item.opt_name +'</p>');
                       }

                       
                    });
                    //jQuery('#ess_amount').append('<p><strong>$'+ response.options +'</strong> Total Optionals</p>');
                 }else{
                    jQuery('#ess_amount').html('$0');
                 }

                 jQuery('#order-detail th#itemtitle').html(response.title);
                 jQuery('#order-detail td#itemamount').html('$'+response.price);
                 jQuery('#order-detail td#taxamount').html('$'+response.tax);

                 if(response.postid == '248' || response.postid == '443') {
                    jQuery('#order-detail td#insamount').html('Included First 3 Months');
                 }else{
                    jQuery('#order-detail td#insamount').html('$'+response.insurance);
                 }
                  
                 
                 jQuery('#order-detail td#total').html('$'+response.total.toFixed(2));
                 jQuery('input[name="custom_payment_input"]').val(response.price);
                 jQuery('input[name="custom_payment_input_1"]').val(response.tax);
                 jQuery('input[name="custom_payment_input_2"]').val(response.options);
                 jQuery('input[name="custom_payment_input_3"]').val(response.insurance);
                 //jQuery('input.tax').val(response.tax);
                 jQuery('input._total_amount_').val(response.total);
              }
           }
        }) 
     });
     setTimeout(function(){ 
       //jQuery('div#optionals .form-check').each(function(){
           //var checkbx = jQuery(this).find('input[type="checkbox"]');      
           jQuery("body").on('change','#colors',function(e){
               e.preventDefault();
               jQuery('input.color').val(jQuery(this).val());
           });
           
           
           
           jQuery("body").on('change','#size',function(e){
              e.preventDefault();
              var postid  =  jQuery('#instruments').attr('data-post');
              var data_value    =  jQuery('#instruments').val();
              console.log('here is sizes');
              var size_val = jQuery(this).val();
              console.log(size_val);
              jQuery.ajax({
                 type : "post",
                 dataType : "json",
                 url : _ajax.ajaxurl,
                 data : {action: "update_instruments", rule:'update_size_terms', data_value:data_value, post_id:postid, size_val:size_val},
                 success: function(response) {
                 
                    if(response.rterm) {
                       jQuery('#terms').html('');
                       jQuery('#termlist').html('');
                          jQuery.each( response.rterm, function( i, item ) {
                             // jQuery('#terms').append('<option value="'+item.term_value+'">'+item.tern_name+'</option>');
                             //  jQuery('#terms').selectpicker('refresh');
                             //  jQuery('#terms').trigger('change');
                           jQuery('#termlist').append('<p id="checked"><input type="radio" data-name="'+item.tern_name+'" class="require" name="terms" id="terms" value="'+item.term_value+'"/> <label>'+item.tern_name+' </label></p><p style="font-size: 14px;font-weight: bold;">'+response.term_ins+'</p>');
                           jQuery('#termlist p#checked input').click();
                    });
                 }
                 jQuery('#size_options').html('');
                 if(response.extra_optionals.length !=0 || response.extra_optionals == 'undefine' ) {
                    
                    jQuery('#optionsl_list').css('display','block');
                    jQuery.each( response.extra_optionals, function( i, item ) {
                         jQuery('#size_options').append(
                          '<div class="form-check" id="'+i+'opt">'
                             +'<input class="form-check-input _optionals_" type="checkbox" name="extra_optionals[]" value="'+item.acf_feild+'" id="'+i+'" data-name="'+item.name+'" data-arrayoff="'+item.name+'">'
                             +'<label class="" for="'+i+'">'+item.name+' <strong>$'+item.price+'</strong> </label></div>');
                                   
                    }); 

             }else{
                   jQuery('#size_options').html('');
             }
                 } 
              }) 
           });
           
           
           jQuery("body").on("change","._optionals_", function(e){
             
              var did           =  jQuery('#district').attr('data-did');
              var optname       = jQuery(this).attr('id')
              var value         = 0;
              var instruments   =  jQuery('#instruments').val();
              //var terms         = jQuery('#terms').find('input:checked').val(); 

              var terms = jQuery('input#terms:checked').map(function() {
                 return this.value;
              }).get();
               var vals = jQuery('input._optionals_:checked').map(function() {
                 return this.value;
               }).get();
               var name = jQuery('input._optionals_:checked').map(function() {
                 return jQuery(this).data('name');
               }).get();
              

              var arroff = jQuery('input._optionals_:checked').map(function() {
                       return jQuery(this).data('arrayoff');
                 }).get();

                 var currentsize = jQuery('#size').val();
               jQuery('input.optional_aceess').val(name);

              
               if (jQuery('#music_stand').is(':checked')) {
                  jQuery('#music_standopt .dropdown').css('display','inline-block');
                  jQuery('input.color').val(jQuery('#colors').val());
                  jQuery('#music_standopt select').addClass('require');
               }else{
                 jQuery('#music_standopt .dropdown').css('display','none');
                 jQuery('input.color').val('');
                 jQuery('#music_standopt select').removeClass('require');
                 jQuery('#music_standopt select').parent().removeClass('error');
               }
              
              jQuery.ajax({
                 type : "post",
                 dataType : "json",
                 url : _ajax.ajaxurl,
                 data : {action: "update_instruments", rule:'get_price', post_id:did, instruments:instruments, terms:terms[0], optname:vals, arroff:arroff, currentsize:currentsize},
                 success: function(response) {             
                    if(response){
                       if(response.options_name) {
                          jQuery('#ess_amount').html('');
                          jQuery.each( response.options_name, function( i, item ) {
                             if(item.type == 'reuirebook'){
                                jQuery('#ess_amount').append('<p>Require Book -  <strong>$'+ item.opt_price +'</strong> '+ item.opt_name +'</p>');
                             }else{
                                jQuery('#ess_amount').append('<p>Optionals - <strong>$'+ item.opt_price +'</strong> '+ item.opt_name +'</p>');
                             }
                          });
                          //jQuery('#ess_amount').append('<p><strong>$'+ response.options +'</strong> Total Optionals</p>');
                       }else{
                          jQuery('#ess_amount').html('$0');
                       }
                       
                       jQuery('input.optionals').val(response.options);
                      // jQuery('#ess_amount').html('$'+response.options);
                       jQuery('#order-detail td#total').html('$'+response.total.toFixed(2));
                       jQuery('input[name="custom_payment_input_2"]').val(response.options);
                       jQuery('input[name="custom_payment_input_1"]').val(response.tax);
                       jQuery('#order-detail td#taxamount').html('$'+response.tax);
                       jQuery('input._total_amount_').val(response.total);
                    }
                 }
              })
           });
       
       
       
       jQuery('body').on('click','#send-email',function(e){
           e.preventDefault();
           var postID = jQuery('#post_ID').val();
           var message = jQuery('#message').find('textarea').val();
          // console.log(message);
           //console.log(postID);
           jQuery.ajax({
             type : "post",
             dataType : "json",
             url : _ajax.ajaxurl,
             data : {action: "email_to_customer", post_id:postID,message:message},
             success: function(response) {             
                if(response){
                    jQuery('#message').find('textarea').val('');
                    jQuery('#send-email').find('.acf-input').text("Successfully send response to customer");
                   ///location.reload();
                }
             }
           })
       });
     //  });
     }, 2500);
     jQuery('#alt_phone, #phone_number').mask('(000) 000-0000');

 })(); 