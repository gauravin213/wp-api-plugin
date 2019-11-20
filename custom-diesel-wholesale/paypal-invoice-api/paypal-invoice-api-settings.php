<?php
/*
* Paypal Invoice API Settings Option Page
*/
add_action( 'admin_menu', 'paypal_invoice_merchantInfo_fun' );
function paypal_invoice_merchantInfo_fun() {
    $page_title = $menu_title = "Paypal Invoice Merchant Info";
    $capability = "manage_options";
    $menu_slug = "paypal-invoice-merchant-info-settings-options";
    $function = "paypal_invoice_merchantInfo_settings_options";
    add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function);
}


function paypal_invoice_merchantInfo_settings_options(){

    global $woocommerce;
    $countries_obj   = new WC_Countries();

?>
<!---->
<div class="wrap">

    <form method="post" action="options.php" novalidate="novalidate">

      <?php wp_nonce_field('update-options') ?>

        <table class="form-table">

            <tbody>

            <tr>
                <td colspan="3">
                    <h1><?php echo _e('Paypal API Configuration ', 'cus-spin-tool');?></h1>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="spinrewriter_email"><?php echo _e('Sandbox', 'cus-spin-tool');?></label>
                </th>
            
                <td>
                <select name="diesel_pi_sandbox" id="diesel_pi_sandbox">
                    <option value="true" <?php echo selected(get_option('diesel_pi_sandbox'), 'false');?> >True</option>
                    <option value="false" <?php echo selected(get_option('diesel_pi_sandbox'), 'false');?> >False</option>
                </select>
                </td>
            
            </tr>

            <tr>
                <th scope="row">
                    <label for="spinrewriter_email"><?php echo _e('Client Id', 'cus-spin-tool');?></label>
                </th>
            
                <td>
                <input name="diesel_pi_clientid" id="diesel_pi_clientid" type="text" class="regular-text" value="<?php if (get_option('diesel_pi_clientid')) echo get_option('diesel_pi_clientid'); ?>">
                </td>
            
            </tr>

            <tr>
                <th scope="row">
                    <label for="spinrewriter_email"><?php echo _e('Client Secret', 'cus-spin-tool');?></label>
                </th>
            
                <td>
                <input name="diesel_pi_client_secret" id="diesel_pi_client_secret" type="text" class="regular-text" value="<?php if (get_option('diesel_pi_client_secret')) echo get_option('diesel_pi_client_secret'); ?>">
                </td>
            
            </tr>

             <tr>
                <th scope="row">
                    <label for="spinrewriter_email"><?php echo _e('Log', 'cus-spin-tool');?></label>
                </th>
            
                <td>
                <select name="diesel_pi_log" id="diesel_pi_log">
                    <option value="true" <?php echo selected(get_option('diesel_pi_log'), 'false');?> >True</option>
                    <option value="false" <?php echo selected(get_option('diesel_pi_log'), 'false');?> >False</option>
                </select>
                </td>
            
            </tr>




            <tr>
                <td colspan="3">
                    <h1><?php echo _e('Merchant Information ', 'cus-spin-tool');?></h1>
                </td>
            </tr>

        
            
            <tr>
                <th scope="row">
                    <label for="spinrewriter_email"><?php echo _e('FirstName', 'cus-spin-tool');?></label>
                </th>
            
                <td>
                <input name="diesel_pi_firstname" id="diesel_pi_firstname" type="text" class="regular-text" value="<?php if (get_option('diesel_pi_firstname')) echo get_option('diesel_pi_firstname'); ?>">
                </td>
            
            </tr>
            
            <tr>
                <th scope="row">
                    <label for="spinrewriter_email"><?php echo _e('LastName', 'cus-spin-tool');?></label>
                </th>
            
                <td>
                <input name="diesel_pi_lastname" id="diesel_pi_lastname" type="text" class="regular-text" value="<?php if (get_option('diesel_pi_lastname')) echo get_option('diesel_pi_lastname'); ?>">
                </td>
            
            </tr>
            
            
            <tr>
                <th scope="row">
                    <label for="spinrewriter_email"><?php echo _e('Email', 'cus-spin-tool');?></label>
                </th>
            
                <td>
                <input name="diesel_pi_email" id="diesel_pi_email" type="text" class="regular-text" value="<?php if (get_option('diesel_pi_email')) echo get_option('diesel_pi_email'); ?>">
                </td>
            
            </tr>
            
            
            <tr>
                <th scope="row">
                    <label for="spinrewriter_email"><?php echo _e('Company', 'cus-spin-tool');?></label>
                </th>
            
                <td>
                <input name="diesel_pi_company" id="diesel_pi_company" type="text" class="regular-text" value="<?php if (get_option('diesel_pi_company')) echo get_option('diesel_pi_company'); ?>">
                </td>
            
            </tr>
            


            <tr>
                <th scope="row">
                    <label for="spinrewriter_email"><?php echo _e('Address 1', 'cus-spin-tool');?></label>
                </th>
            
                <td>
                <input name="diesel_pi_address1" id="diesel_pi_address1" type="text" class="regular-text" value="<?php if (get_option('diesel_pi_address1')) echo get_option('diesel_pi_address1'); ?>">
                </td>
            
            </tr>

            <tr>
                <th scope="row">
                    <label for="spinrewriter_email"><?php echo _e('Address 2', 'cus-spin-tool');?></label>
                </th>
            
                <td>
                <input name="diesel_pi_address2" id="diesel_pi_address2" type="text" class="regular-text" value="<?php if (get_option('diesel_pi_address2')) echo get_option('diesel_pi_address2'); ?>">
                </td>
            
            </tr>

            <tr>
                <th scope="row">
                    <label for="spinrewriter_email"><?php echo _e('Country', 'cus-spin-tool');?></label>
                </th>
            
                <td>
                <?php
                $countries   = $countries_obj->__get('countries');
                ?>
                <select name="diesel_pi_country" id="diesel_pi_country">
                    <?php foreach ($countries as $key => $value) { ?>
                         <option value="<?php echo $key;?>" <?php echo selected(get_option('diesel_pi_country'), $key);?> ><?php echo $value;?></option>
                    <?php } ?>
                </select>
                </td>
            
            </tr>


        
            <tr>
                <th scope="row">
                    <label for="spinrewriter_email"><?php echo _e('State', 'cus-spin-tool');?></label>
                </th>
            
                <td>
                <?php
                $default_county_states = $countries_obj->get_states( get_option('diesel_pi_country') );
                ?>

                <div id="admin_diese_pi_loader" style="display: none;">Loading..</div>
                <select name="diesel_pi_state" id="diesel_pi_state">
                    <?php foreach ($default_county_states as $key => $value) { ?>
                         <option value="<?php echo $key;?>" <?php echo selected(get_option('diesel_pi_state'), $key);?> ><?php echo $value;?></option>
                    <?php } ?>
                </select>
                </td>

            
            </tr>


            <tr>
                <th scope="row">
                    <label for="spinrewriter_email"><?php echo _e('Language', 'cus-spin-tool');?></label>
                </th>
            
                <td>
                <?php
                $langs = array("da_DK", "de_DE", "en_AU", "en_GB", "en_US", "es_ES", "es_XC", "fr_CA", "fr_FR", "fr_XC", "he_IL", "id_ID", "it_IT", "ja_JP", "nl_NL", "no_NO", "pl_PL", "pt_BR", "pt_PT", "ru_RU", "sv_SE", "th_TH", "tr_TR", "zh_CN", "zh_HK", "zh_TW", "zh_XC");
                ?>

                <select name="diesel_pi_language" id="diesel_pi_language">
                    <?php foreach ($langs as $lang) { ?>
                         <option value="<?php echo $lang;?>" <?php echo selected(get_option('diesel_pi_language'), $lang);?> ><?php echo $lang;?></option>
                    <?php } ?>
                </select>
                </td>
            
            </tr>



            <tr>
                <th scope="row">
                    <label for="spinrewriter_email"><?php echo _e('City', 'cus-spin-tool');?></label>
                </th>
            
                <td>
                <input name="diesel_pi_city" id="diesel_pi_city" type="text" class="regular-text" value="<?php if (get_option('diesel_pi_city')) echo get_option('diesel_pi_city'); ?>">
                </td>
            
            </tr>

            <tr>
                <th scope="row">
                    <label for="spinrewriter_email"><?php echo _e('Zip', 'cus-spin-tool');?></label>
                </th>
            
                <td>
                <input name="diesel_pi_zip" id="diesel_pi_zip" type="text" class="regular-text" value="<?php if (get_option('diesel_pi_zip')) echo get_option('diesel_pi_zip'); ?>">
                </td>
            
            </tr>


            <tr>
                <th scope="row">
                    <label for="spinrewriter_email"><?php echo _e('Phone', 'cus-spin-tool');?></label>
                </th>
            
                <td>
                <input name="diesel_pi_phone" id="diesel_pi_phone" type="text" class="regular-text" value="<?php if (get_option('diesel_pi_phone')) echo get_option('diesel_pi_phone'); ?>">
                </td>
            
            </tr>

            
            
            

            </tbody>

        </table>


        <!---->
        <input type="hidden" name="action" value="update" />
        <input type="hidden" name="page_options" value="diesel_pi_sandbox,diesel_pi_clientid,diesel_pi_client_secret,diesel_pi_log,diesel_pi_firstname,diesel_pi_lastname,diesel_pi_email,diesel_pi_company,diesel_pi_address1,diesel_pi_address2,diesel_pi_country,diesel_pi_language,diesel_pi_state,diesel_pi_city,diesel_pi_zip,diesel_pi_phone" />
        <!---->

        <p class="submit">
            <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>

    </form>



    <script type="text/javascript">
        jQuery(document).ready(function(){ 

            jQuery(document).on('change', '#diesel_pi_country', function(){

                var target = jQuery(this);

                var country_code = target.find('option:selected').val();

                jQuery.ajax({
                    url: '<?php echo admin_url( 'admin-ajax.php');?>',
                    type: "POST",
                    data: {'action': 'get_state_list_of_country', 'country_code': country_code},
                    //cache: false,
                    //dataType: 'json',
                    beforeSend: function(){
                        jQuery('#admin_diese_pi_loader').show();
                    },
                    complete: function(){
                        jQuery('#admin_diese_pi_loader').hide();
                    },
                    success: function (response) {  

                        //alert(response); 

                        console.log(response);

                        jQuery('#diesel_pi_state').html(response);
                        
                        
                    }
                });
            


            });

        });
    </script>

</div>
<!---->
<?php
}
?>