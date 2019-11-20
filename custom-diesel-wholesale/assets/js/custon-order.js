/*
* custon-order.js
*/ 
jQuery(document).ready(function(){ //alert(objData.post_id);
  
 
if(objData.display_name == 'shop_order'){
    
    //Start::Order edit page
    var htm = "";
    var html_div_target = "";

    jQuery.fn.get_payment_option = function(){ 
  
        var user_id = jQuery('#customer_user').find('option:selected').val();  
        var order_id = objData.order_id;
         
        jQuery.ajax({
            url: objData.ajaxurl,
            type: "POST",
            data: {'action': 'get_wholesale_payment_option_ac', 'user_id': user_id, 'order_id': order_id},
            cache: false,
            dataType: 'json',
            beforeSend: function(){
                //jQuery('#cus_wholesale_payment_option').addClass('custom-wpc-loader');
            },
            complete: function(){
                //jQuery('#cus_wholesale_payment_option').removeClass('custom-wpc-loader');
            },
            success: function (response) {  

               // console.log(response);
                //alert(response['target_action']);

                if(response['target_action'] == "paypal"){

                    /*response['invoice_number'] = '';
                    response['invoice_id'] = '';*/

                   
                    if (response['invoice_number'] && response['invoice_id']) {

                     htm = '<ul class="custom-wpc==">'+
                            '<li>'+
                            '<strong>Paypal Invoice Info</strong><hr>'+
                            '</li>'+

                            '<li>'+
                            '<strong>Email id:</strong>'+
                            '<span> '+response['paypal_id']+'</span>'+
                            '</li>'+
                            
                            '<li>'+
                            '<strong>Invoice id:</strong>'+
                            '<span> '+response['invoice_id']+'</span>'+
                            '</li>'+
                            
                            '<li>'+
                            '<strong>Invoice no.:</strong>'+
                            '<span> #'+response['invoice_number']+'</span>'+
                            '</li>'+
                            
                            '<li>'+
                            '<strong>Invoice status:</strong>'+
                            '<span> '+response['invoice_status']+'</span>'+
                            '</li>'+
                    '</ul>'+
                    '<input type="hidden" name="cus_paypal_id" id="cus_paypal_id" value="'+response['paypal_id']+'" disabled>'+
                    '<input type="hidden" name="cus_hwspo" id="cus_hwspo" value="'+response['target_action']+'">';

                    }else{
                        htm = '<div class="custom-wpc">'+
                        '<strong>Wholesaler Payment Option : </strong>'+'</br>'+
                        '<input type="text" name="cus_paypal_id" id="cus_paypal_id" value="'+response['paypal_id']+'" disabled>'+
                        '<input type="hidden" name="cus_hwspo" id="cus_hwspo" value="'+response['target_action']+'">'+
                        '<div style="display: inline-block;width: 100%;"><br/><button style="float:right" class="button button-primary" id="paypal_invoice_aj_action">Send Paypal Invoice</button></div>'
                        '</div>';
                    }

                    html_div_target = jQuery('#cus_wholesale_payment_option');
                    html_div_target.html(htm);
                    
                   /* //user_paypal_id
                    var custom_paypal_email_id = response['paypal_id'];
                    if(custom_paypal_email_id!=""){
                        jQuery('#custom_paypal_email_id').html('<span><strong>Paypal email:</strong></span> <span>'+custom_paypal_email_id+'</span>');
                    }else{
                        //jQuery('#custom_paypal_email_id').html('No');
                    }*/
                    
                    html_div_target.find('.custom-wpc').addClass('custom-wpc-active==');

                    setTimeout(function(){ 
                        jQuery('#cus_wholesale_payment_option').removeClass('custom-wpc-loader');
                        //jQuery('#custom_paypal_email_id').removeClass('custom-wpc-loader');
                    }, 1000);
                    

                }


                if(response['target_action'] == "net_30"){


                    //response['net30_invoice_number'] = '';


                    if (response['net30_invoice_number']) {

                       
                        if(response['order_status'] == "completed"){

                            htm = '<ul class="custom-wpc==">'+
                                    '<li>'+
                                    '<strong>Net 30</strong><hr>'+
                                    '</li>'+

                                    '<li>'+
                                    '<strong>Invoice No.:</strong>'+
                                    '<span> '+response['net30_invoice_number']+'</span>'+
                                    '</li>'+

                                    '<li>'+
                                    '<strong>Status:</strong>'+
                                    '<span> PAID</span>'+
                                    '</li>'+
                                    
                                    '<li>'+
                                    '<a href="'+response['view_pdf_path']+'?pdfn='+response['pdf_path']+'" target="_blank">View</a>'+
                                    '</li>'+

                            '</ul>'+
                            '<input type="hidden" name="cus_hwspo" id="cus_hwspo" value="'+response['target_action']+'">';
                            html_div_target = jQuery('#cus_wholesale_payment_option');
                            html_div_target.html(htm);
                            html_div_target.find('.custom-wpc').addClass('custom-wpc-active==');

                            setTimeout(function(){ 
                                jQuery('#cus_wholesale_payment_option').removeClass('custom-wpc-loader');
                            }, 1000);

                        }else{

                            htm = '<ul class="custom-wpc==">'+
                                    '<li>'+
                                    '<strong>Net 30</strong><hr>'+
                                    '</li>'+

                                    '<li>'+
                                    '<strong>Invoice No.:</strong>'+
                                    '<span> '+response['net30_invoice_number']+'</span>'+
                                    '</li>'+

                                    '<li>'+
                                    '<strong>Status:</strong>'+
                                    '<span> SENT</span>'+
                                    '</li>'+
                                    
                                    '<li>'+
                                    '<a href="'+response['view_pdf_path']+'?pdfn='+response['pdf_path']+'" target="_blank">View</a>'+
                                    '</li>'+
                                    
                                    '<li>'+
                                    '<div style="display: inline-block;width: 100%;"><br/><button style="float:right" class="button button-primary" id="net_30_aj_action">Update</button></div>'+
                                    '</li>'+

                            '</ul>'+
                            '<input type="hidden" name="cus_hwspo" id="cus_hwspo" value="'+response['target_action']+'">';
                            html_div_target = jQuery('#cus_wholesale_payment_option');
                            html_div_target.html(htm);
                            html_div_target.find('.custom-wpc').addClass('custom-wpc-active==');

                            setTimeout(function(){ 
                                jQuery('#cus_wholesale_payment_option').removeClass('custom-wpc-loader');
                            }, 1000);

                        }


                    
                    }else{

                        htm = '<ul class="custom-wpc==">'+
                                '<li>'+
                                '<strong>Net 30</strong><hr>'+
                                '</li>'+

                                '<li>'+
                                '<strong>Reference No.:</strong>'+
                                '<input type="text" name="net_30_ref_no" id="net_30_ref_no" value="'+order_id+'">'+
                                '<div style="display: inline-block;width: 100%;"><br/><button style="float:right" class="button button-primary" id="net_30_aj_action">Send Invoice</button></div>'+
                                '</li>'+
                        '</ul>'+
                        '<input type="hidden" name="cus_hwspo" id="cus_hwspo" value="'+response['target_action']+'">';
                        html_div_target = jQuery('#cus_wholesale_payment_option');
                        html_div_target.html(htm);
                        html_div_target.find('.custom-wpc').addClass('custom-wpc-active==');

                        setTimeout(function(){ 
                            jQuery('#cus_wholesale_payment_option').removeClass('custom-wpc-loader');
                        }, 1000);

                    }

                }


                if(response['target_action'] == "credit_card"){
                    
                    //response['wholesaler_firstdata_isError'] = '';
                    
                    if(response['wholesaler_firstdata_isError'] == 'transaction_passed'){
                        
                        htm = '<ul class="custom-wpc==">'+
                                '<li>'+
                                '<strong>Credit Card</strong><hr>'+
                                '</li>'+
                                
                                '<li>'+
                                '<strong>Transaction Passed</strong><hr>'+
                                '</li>'+
                                
                                '<li>'+
                                '<a href="#TB_inline?width=600&height=550&inlineId=modal-window-id-firstdata" class="button button-primary thickbox">View Record</a>'+
                                '</li>'+
                                
                        '</ul>'+
                        '<input type="hidden" name="cus_hwspo" id="cus_hwspo" value="'+response['target_action']+'">';
                        
                        
                        html_div_target = jQuery('#cus_wholesale_payment_option');
                        html_div_target.html(htm);
                        html_div_target.find('.custom-wpc').addClass('custom-wpc-active==');
    
                        setTimeout(function(){ 
                            jQuery('#cus_wholesale_payment_option').removeClass('custom-wpc-loader');
                        }, 1000);
                        
                    }else{
                        
                        htm = '<ul class="custom-wpc==">'+
                                '<li>'+
                                '<strong>Credit Card</strong><hr>'+
                                '</li>'+
                                
                                '<li>'+
                                '<label>Credit Card Number</label><br>'+
                                '<input type="text" name="fd_card_no" id="fd_card_no" value="">'+
                                '<span class="fd-error1"></span>'+
                                '</li>'+
                                
                                '<li>'+
                                '<label>Expiry Date(MM/YY)</label><br>'+
                                '<input type="text" name="fd_card_exp" id="fd_card_exp" value="">'+
                                '<span class="fd-error2"></span>'+
                                '</li>'+
                                
                                '<li>'+
                                '<label>CVV</label><br>'+
                                '<input type="text" name="fd_card_cvv" id="fd_card_cvv" value="">'+
                                '<span class="fd-error3"></span>'+
                                '</li>'+
                                
                                '<li>'+
                                '<a href="#" class="button button-primary" id="custom_action_firstdata_aj">Submit</a>'+
                                '</li>'+
                                
                               
                                
                        '</ul>'+
                        '<input type="hidden" name="cus_hwspo" id="cus_hwspo" value="'+response['target_action']+'">';
                        html_div_target = jQuery('#cus_wholesale_payment_option');
                        html_div_target.html(htm);
                        html_div_target.find('.custom-wpc').addClass('custom-wpc-active==');
    
                        setTimeout(function(){ 
                            jQuery('#cus_wholesale_payment_option').removeClass('custom-wpc-loader');
                        }, 1000);
                        
                    }

                    

                }

                if(response['target_action'] == "no_payment_option"){

                    htm = '<ul>';   
                    
                    
                    
                    htm +='<li>'+
                                '<input type="radio" name="admin-pm-option" class="admin-pm-option" value="paypal">'+
                                '<label>Paypal</label> '+
                                '<span class="pm-error1"></span>'+
                                '<span class="paypal-api-reponce-error"></span>'+
                                '<div class="pm-option-items pm-option-item-paypal" style="display:none;"><hr>'+
                                    '<input type="text" name="cus_paypal_id" id="cus_paypal_id" value="'+response['user_paypal_id']+'">'+
                                    '<a class="button button-primary" id="paypal_invoice_aj_action">Send Paypal Invoice</a>'+
                                '<hr></div>'+
                            '</li>';
                            
                    htm += '<li>'+
                                '<input type="radio" name="admin-pm-option" class="admin-pm-option" value="credit_card">'+
                                 '<label>Credit Card</label> '+
                                '<span class="pm-error2"></span>'+
                                '<div class="pm-option-items pm-option-item-creadit-cart" style="display:none;"><hr>'+
                                    '<ul>'+
                                        '<li>'+
                                        '<label>Credit Card Number</label><br>'+
                                        '<input type="text" name="fd_card_no" id="fd_card_no" value="">'+
                                        '<span class="fd-error1"></span>'+
                                        '</li>'+
                                        
                                        '<li>'+
                                        '<label>Expiry Date(MM/YY)</label><br>'+
                                        '<input type="text" name="fd_card_exp" id="fd_card_exp" value="">'+
                                        '<span class="fd-error2"></span>'+
                                        '</li>'+
                                        
                                        '<li>'+
                                        '<label>CVV</label><br>'+
                                        '<input type="text" name="fd_card_cvv" id="fd_card_cvv" value="">'+
                                        '<span class="fd-error3"></span>'+
                                        '</li>'+
                                        
                                        '<li>'+
                                        '<a href="#" class="button button-primary" id="custom_action_firstdata_aj">Submit</a>'+
                                        '</li>'+
                                            
                                    '</ul>'+
                                '<hr></div>'+
                            '</li>';
                            
                    
                    
                        if(response['user_role'] == true){
                            
                            if(response['custom_wholesaler_payment_option'] == "net_30"){
                                htm +='<li>'+
                                        '<input type="radio" name="admin-pm-option" class="admin-pm-option" value="net_30">'+
                                        '<label>Net 30</label> '+
                                        '<span class="pm-error2=3"></span>'+
                                        '<div class="pm-option-items pm-option-item-net-30" style="display:none;"><hr>'+
                                            '<ul>'+
                                                    '<li>'+
                                                    '<strong>Reference No.:</strong>'+
                                                    '<input type="text" name="net_30_ref_no" id="net_30_ref_no" value="'+order_id+'">'+
                                                    '<button class="button button-primary" id="net_30_aj_action">Send Invoice</button>'+
                                                    '</li>'+
                                            '</ul>'+
                                        '<hr></div>'+
                                '</li>';
                            }
                            
                        }
                            
                    
                            
                    htm +='</ul>';
                    
                    htm +='<input type="hidden" name="cus_hwspo" id="cus_hwspo" value="">';
                    
                    
                    
                    
                    html_div_target = jQuery('#cus_wholesale_payment_option');
                    html_div_target.html(htm);
                    
                    
                    //user_paypal_id
                    /*var custom_paypal_email_id = response['user_paypal_id'];
                    if(custom_paypal_email_id!=""){
                        
                        var pdata = "";
                        pdata += '<span><strong>Paypal email:</strong></span> <span>'+custom_paypal_email_id+'</span>';
                        pdata += '<input type="hidden" name="custom_paypal_email_id" id="user_paypal_id" value="'+response['user_paypal_id']+'">';
                        
                        jQuery('#custom_paypal_email_id').html(pdata);
                        
                    }else{
                        //jQuery('#custom_paypal_email_id').html('No');
                    }*/
                    
                    
                    
                    html_div_target.find('.custom-wpc').addClass('custom-wpc-active==');

                    setTimeout(function(){ 
                        jQuery('#cus_wholesale_payment_option').removeClass('custom-wpc-loader');
                        //jQuery('#custom_paypal_email_id').removeClass('custom-wpc-loader');
                    }, 1000);

                }


                if(response['target_action'] == "customer"){

                     jQuery('.custom-wpc').remove();

                }
                
            }
        });

    }
   
    jQuery(this).get_payment_option();
   
    jQuery(document).on('change', '#customer_user', function(e){  
       
       jQuery(this).get_payment_option();
       
       
       //Get paypal email is
       
       

    }); 
    
    
    //Admin Payment options
    jQuery(document).on('click', '.admin-pm-option', function(){ 

        //e.preventDefault();
        
        var target2 = jQuery(this);
        
        if(target2.is(":checked")){
           
           
           var pm_option_name = target2.val();
           
           jQuery('#cus_hwspo').val(pm_option_name);
           
           //alert('pm_option_name : '+pm_option_name);
           
           jQuery('.pm-option-items').hide();
           
           if(pm_option_name == 'paypal'){
               jQuery('.pm-option-item-paypal').show();
           }
           
           if(pm_option_name == 'credit_card'){
               jQuery('.pm-option-item-creadit-cart').show();
           }
           
           if(pm_option_name == 'net_30'){
               jQuery('.pm-option-item-net-30').show();
           }
        }
        
        
    });
    
    
    
    
    
    
    
    //First Data service
    jQuery('#fd_card_no').mask('0000-0000-0000-0000');
    jQuery('#fd_card_exp').mask('00/00');
    jQuery('#fd_card_cvv').mask('000');
    
    jQuery(document).on('click', '#custom_action_firstdata_aj', function(e){ 

        e.preventDefault();
        
        var user_id = jQuery('#customer_user').find('option:selected').val();
        var order_id = objData.order_id;
        var cus_hwspo = jQuery('#cus_hwspo').val();
        var fd_card_no = jQuery('#fd_card_no').val();
        var fd_card_exp = jQuery('#fd_card_exp').val();
        var fd_card_cvv = jQuery('#fd_card_cvv').val();
        
        var flag1 = 1;
        var flag2 = 1;
        var flag3 = 1;
        var flag = '';
        
        jQuery('.fd-error1').text('');
        if(fd_card_no == ""){
            jQuery('.fd-error1').text('This field is required').css('color', 'red');
            flag1 = 0;
        }
        
        jQuery('.fd-error2').text('');
        if(fd_card_exp == ""){
            jQuery('.fd-error2').text('This field is required').css('color', 'red');
            flag2 = 0;
        }
        
        jQuery('.fd-error3').text('');
        if(fd_card_cvv == ""){
            jQuery('.fd-error3').text('This field is required').css('color', 'red');
            flag3 = 0;
        }
        
        flag = flag1+flag2+flag3;
        
        if(flag == 3){
            //alert('all fields are validated');
            jQuery.ajax({
                url: objData.ajaxurl,
                type: "POST",
                data: {'action': 'custom_first_data_api_save_aj_fun', 'user_id': user_id, 'order_id': order_id, 'cus_hwspo':cus_hwspo, 'fd_card_no':fd_card_no, 'fd_card_exp':fd_card_exp, 'fd_card_cvv':fd_card_cvv},
                cache: false,
                dataType: 'json',
                beforeSend: function(){
                    jQuery('#cus_wholesale_payment_option').addClass('custom-wpc-loader');
                },
                complete: function(){
                    jQuery('#cus_wholesale_payment_option').removeClass('custom-wpc-loader');
                },
                success: function (response) {  
    
                    console.log(response);
                    
                   location.href = location.href;
                }
            });
        }
        
    });



    //Paypal Service
    jQuery(document).on('click', '#paypal_invoice_aj_action', function(e){ 

        e.preventDefault();
        
        var flag = 1;

        var user_id = jQuery('#customer_user').find('option:selected').val();
        var order_id = objData.order_id;
        var cus_hwspo = jQuery('#cus_hwspo').val();
        
        var cus_paypal_id = jQuery('#cus_paypal_id').val();
        
        var user_paypal_id = jQuery('#user_paypal_id').val();
        
       /* if(user_paypal_id == cus_paypal_id){
             jQuery('.pm-error1').text('');
            flag = 1;
        }else{
            jQuery('.pm-error1').text('Invalid paypal email').css('color', 'red');
            flag = 0;
        }
        
        if(flag == 1){
            //alert('submit form');
            
        }*/
        
        /**/
        jQuery('.pm-error1').text('');
        if(cus_paypal_id == ""){
            jQuery('.pm-error1').text('This field is required.').css('color', 'red');
            flag = 0; 
        }else{
            var custom_validateEmail = validateEmail(cus_paypal_id); //alert(custom_validateEmail);
            
            if(custom_validateEmail == false){
                jQuery('.pm-error1').text('Invalid paypal email id.').css('color', 'red');
                flag = 0;
            }
        }
        
        if(flag == 1){
            
           // alert('submit form');
            
             jQuery.ajax({
                url: objData.ajaxurl,
                type: "POST",
                data: {'action': 'custom_paypal_invoice_aj', 'user_id': user_id, 'order_id': order_id, 'cus_hwspo':cus_hwspo, 'cus_paypal_id':cus_paypal_id},
                cache: false,
                dataType: 'json',
                beforeSend: function(){
                    jQuery('#cus_wholesale_payment_option').addClass('custom-wpc-loader');
                },
                complete: function(){
                    jQuery('#cus_wholesale_payment_option').removeClass('custom-wpc-loader');
                },
                success: function (response) {  
    
                    console.log(response);
                     
                    if (response['status'] == 'Success') {  //console.log(response);
    
                        location.href = location.href;
    
                    }
    
                    if (response['status'] == 'Error') {
                        alert('Error: An error occurred in (Paypal Invoice API)');
                        
                        jQuery('.paypal-api-reponce-error').addClass('paypal-api-reponce-error_style');
                        jQuery('.paypal-api-reponce-error').append( response['reponce_data']['details']).css('color', 'red');
                       
                    }
     
                    
                }
            });
            
        }
        /**/
        
    

        
    });






    //net_30_aj_action
    jQuery(document).on('click', '#net_30_aj_action', function(e){ 

        e.preventDefault();

        var user_id = jQuery('#customer_user').find('option:selected').val();
        var order_id = objData.order_id;
        var cus_hwspo = jQuery('#cus_hwspo').val();
        var net_30_ref_no = jQuery('#net_30_ref_no').val();
        
        jQuery.ajax({
            url: objData.ajaxurl,
            type: "POST",
            data: {'action': 'custom_net_30_aj_action', 'user_id': user_id, 'order_id': order_id, 'cus_hwspo':cus_hwspo, 'net_30_ref_no':net_30_ref_no},
            cache: false,
            dataType: 'json',
            beforeSend: function(){
                jQuery('#cus_wholesale_payment_option').addClass('custom-wpc-loader');
            },
            complete: function(){
                jQuery('#cus_wholesale_payment_option').removeClass('custom-wpc-loader');
            },
            success: function (response) {  

                location.href = location.href;

                console.log(response);

                //alert(response);
                
            }
        });
    });
    
    
    
       
   //Refund Core charges
    jQuery(document).on('click', '#core_charges_return_aj', function(e){ 

        e.preventDefault(); 
        
        var user_id = jQuery('#customer_user').find('option:selected').val();
        var order_id = objData.order_id;
        
        var suborder_item_id = jQuery('#suborder_items').find('option:selected').val();  
    
        jQuery.ajax({
            url: objData.ajaxurl,
            type: "POST",
            data: {'action': 'core_charges_return_aj', 'user_id': user_id, 'order_id': order_id, 'suborder_item_id':suborder_item_id},
            cache: false,
            dataType: 'json',
            beforeSend: function(){ 
                jQuery('#core_return_charges').addClass('custom-wpc-loader');
            },
            complete: function(){
                jQuery('#core_return_charges').removeClass('custom-wpc-loader');
            },
            success: function (response) {  //alert(response['refund_amount']);
                 location.href = location.href;
                console.log(response);

          
                
            }
        });
        
    });
    
    
    
    
    //Start :: Shipping rate
    jQuery.fn.get_shipping_rate_list = function(){ 
        
        var user_id = jQuery('#customer_user').find('option:selected').val();
        var order_id = objData.order_id;
    
        jQuery.ajax({
            url: objData.ajaxurl,
            type: "POST",
            data: {'action': 'custom_get_shipping_rate_aj', 'user_id': user_id, 'order_id': order_id},
            cache: false,
            dataType: 'json',
            beforeSend: function(){ 
                //jQuery('#core_return_charges').addClass('custom-wpc-loader');
            },
            complete: function(){
                //jQuery('#core_return_charges').removeClass('custom-wpc-loader');
            },
            success: function (response) {  
                
                setTimeout(function(){ 
                    jQuery('#custom_shipping_rate').removeClass('custom-wpc-loader');
                }, 1000);
               
                if(response['htm_data'] =="filled"){
                    jQuery('#custom_shipping_rate').html(response['reponce_data']).css('color', 'green');
                }else{
                    jQuery('#custom_shipping_rate').html(response['htm_data']);
                }
                
                if(response['reponce_data']['HighestSeverity'] == 'ERROR'){
                    jQuery('#custom_shipping_rate').html(response['reponce_data']['Notifications']['Message']).css('color', 'red');
                    console.log(response);
                }
                
                if(response['reponce_data']['faultstring'] == 'Fault'){
                    jQuery('#custom_shipping_rate').html(response['reponce_data']['detail']['desc']).css('color', 'red');
                    console.log(response);
                }
                
                console.log(response);
                
               
            }
        });
    }
    
    jQuery(this).get_shipping_rate_list();
    
    jQuery(document).on('click', '#btn_get_shipping_rate_js', function(e){ 
        
        jQuery('#custom_shipping_rate').addClass('custom-wpc-loader');

        e.preventDefault(); 
        
        var target = jQuery(this);
        
        var shipping_rate_vl =  jQuery("input[name='admin_shipping_rates']:checked").val();
        
        var user_id = jQuery('#customer_user').find('option:selected').val();
        
        var order_id = objData.order_id;
        
        var shipping_method_id = jQuery("input[name='admin_shipping_rates']:checked").data('shipping_method_id');
        
        var shipping_method_title = jQuery("input[name='admin_shipping_rates']:checked").data('shipping_method_title');
        
        //alert(shipping_method_id+'____'+shipping_method_title+'__'+shipping_rate_vl);
        
        
        jQuery('.shipping-rate-error1').text('');
        if(shipping_rate_vl == undefined){
             jQuery('.shipping-rate-error1').text('Please select the rate!').css('color', 'red');
        }else{
   
            //Add Shipping Rate
            jQuery.ajax({
                url: objData.ajaxurl,
                type: "POST",
                data: {'action': 'custom_admin_add_shipping_rate', 'user_id': user_id, 'order_id': order_id, 'shipping_method_id':shipping_method_id, 'shipping_method_title':shipping_method_title, 'shipping_rate_vl':shipping_rate_vl},
                cache: false,
                dataType: 'json',
                beforeSend: function(){ 
                    //jQuery('#core_return_charges').addClass('custom-wpc-loader');
                },
                complete: function(){
                    //jQuery('#core_return_charges').removeClass('custom-wpc-loader');
                },
                success: function (response) {  
                    location.href = location.href;
                    //console.log(response);
                }
            });
        }
        
        
    });
    //End :: Shipping rate
     
     
   

   jQuery(document).on('click', '#custom_diese_ajax_action_add_user', function(e){ 
       
       e.preventDefault()
       
        var custom_fname = jQuery('#custom_fname').val();
        var custom_lname = jQuery('#custom_lname').val();
        var custom_email = jQuery('#custom_email').val();
        var custom_username = jQuery('#custom_username').val();
        //var custom_role = jQuery('#custom_role').val(); 
        
        var custom_role =  jQuery("input[name='custom_role']:checked").val(); 
        if(custom_role){ 
            
        }else{ 
            custom_role = "";
        }
        
        var msg = "";
        var flag = 0;
        var flag1 = 0;
        var flag2 = 0;
        var flag3 = 0;
        
        
        if(custom_username == ""){ 
            flag1 = 1;
            jQuery('#custom_diese_user_msg').show();
            msg = "Username field is required";  //alert("flag1: "+msg);
            jQuery('#custom_diese_user_msg').text(msg);
            jQuery('#custom_diese_user_msg').css('background-color', '#d25b5b'); 
        }
        
    
        if(custom_email == ""){
            flag2 = 1; 
            jQuery('#custom_diese_user_msg').show();
            msg = "Email field is required";  //alert("flag2: "+msg);
            jQuery('#custom_diese_user_msg').text(msg);
            jQuery('#custom_diese_user_msg').css('background-color', '#d25b5b'); 
        }else{
            var custom_validateEmail = validateEmail(custom_email); //alert(custom_validateEmail);
            
            if(custom_validateEmail == false){
                flag3 = 1; 
                jQuery('#custom_diese_user_msg').show();
                msg = "Invalid email address";  //alert("flag3: "+msg);
                jQuery('#custom_diese_user_msg').text(msg);
                jQuery('#custom_diese_user_msg').css('background-color', '#d25b5b'); 
            }
        }
        
        
        
        setTimeout(function(){ 
                    
            jQuery('#custom_diese_user_msg').fadeOut(); 
            //tb_remove();
            
        }, 4000);
        
        
        flag = flag1+ flag2 + flag3; 
        
        
        if(flag == 0){  //alert('flag: '+flag);
        
              /**/
           jQuery.ajax({
            url: objData.ajaxurl,
            type: "POST",
            data: {'action': 'custom_diese_ajax_action_add_user', 'post_id': objData.post_id, 'custom_fname': custom_fname, 'custom_lname': custom_lname, 'custom_email': custom_email, 'custom_username': custom_username, 'custom_role': custom_role},
            //cache: false,
            //dataType: 'json',
            beforeSend: function(){
                jQuery('#custom_diese_user_loader').show();
            },
            complete: function(){
                jQuery('#custom_diese_user_loader').hide();
            },
            success: function (response) {  //alert(response);
                
                if(response == 1){ 
                    msg = "User created successfully";  //alert(msg);
                    jQuery('#custom_diese_user_msg').text(msg); 
                    jQuery('#custom_diese_user_msg').css('background-color', '#396f39'); 
                    
                    setTimeout(function(){ 
                    
                    jQuery('#custom_diese_user_msg').fadeOut(); 
                    tb_remove();
                    
                    }, 3000);
                
                    
                }else if(response ==2){
                     msg = "Error: user not created";  //alert(msg);
                     jQuery('#custom_diese_user_msg').text(msg);
                     jQuery('#custom_diese_user_msg').css('background-color', '#d25b5b'); 
                    
                }else if(response ==3){
                     msg = "email already exist";  //alert(msg);
                     jQuery('#custom_diese_user_msg').text(msg);
                     jQuery('#custom_diese_user_msg').css('background-color', '#d25b5b'); 
                    
                }else{
                     msg = "User already exist";  //alert(msg);
                     jQuery('#custom_diese_user_msg').text(msg);
                     jQuery('#custom_diese_user_msg').css('background-color', '#d25b5b'); 
                }
                
                jQuery('#custom_diese_user_msg').show();
                
                setTimeout(function(){ 
                    
                    jQuery('#custom_diese_user_msg').fadeOut(); 
                    //tb_remove();
                    
                }, 3000);
                
                console.log(response);
            }
            });
           /**/
            
        }
        
        
   });
    
    //End::Order edit page      
}

   
   
    //Start::core charges order list
    var o_data = '';
    jQuery(document).on('change', '#core_charges_order_list', function(e){ 
        
        var core_o_status = jQuery(this).find('option:selected').val();  
        
        //alert(core_o_status);
        
        if(core_o_status!=""){
            
            //
            jQuery.ajax({
                url: objData.ajaxurl,
                type: "POST",
                data: {'action': 'core_charges_order_list', 'core_o_status': core_o_status},
                cache: false,
                dataType: 'json',
                beforeSend: function(){ 
                    jQuery('#core_order_loader').show();
                },
                complete: function(){
                    jQuery('#core_order_loader').hide();
                },
                success: function (response) {  
                    
                    
                    o_data = response['o_data'];
                    
                    jQuery('#core_order_tb').html(o_data);
                  
                    console.log(response);
                    
                   
                }
            });
            //
            
        }else{
            //
        }
        
    });
    //End::core charges order list
   

   
   
  
});





function validateEmail(sEmail) {
    var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    if (filter.test(sEmail)) {
        return true;
    }
    else {
        return false;
    }
}