<?php

add_action( 'admin_menu', 'basicpluginstr_admin_menu_function222' );
function basicpluginstr_admin_menu_function222() {
	$page_title = $menu_title = "Diesel Custom Settings Optiins";
	$capability = "manage_options";
	$menu_slug = "disdel-custom-settings-options";
	$function = "disdel_custom_settings_options";
	add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function);
}


function disdel_custom_settings_options(){
?>
<!---->
<div class="wrap">
	<h1><?php echo _e('Diesel Custom Settings Options', 'cus-spin-tool');?></h1>

	<form method="post" action="options.php" novalidate="novalidate">

      <?php wp_nonce_field('update-options') ?>

		<table class="form-table">

			<tbody>

			<tr>
				<td colspan="3">
					<h1><?php echo _e('Social Media Links', 'cus-spin-tool');?></h1>
				</td>
			</tr>
			
			<tr>
            	<th scope="row">
            		<label for="spinrewriter_email"><?php echo _e('Facebook', 'cus-spin-tool');?></label>
            	</th>
            
            	<td>
            	<input name="diesel_social_media_facebook" id="diesel_social_media_facebook" type="text" class="regular-text" value="<?php if (get_option('diesel_social_media_facebook')) echo get_option('diesel_social_media_facebook'); ?>">
            	</td>
            
            </tr>
            
            <tr>
            	<th scope="row">
            		<label for="spinrewriter_email"><?php echo _e('Twitter', 'cus-spin-tool');?></label>
            	</th>
            
            	<td>
            	<input name="diesel_social_media_twitter" id="diesel_social_media_twitter" type="text" class="regular-text" value="<?php if (get_option('diesel_social_media_twitter')) echo get_option('diesel_social_media_twitter'); ?>">
            	</td>
            
            </tr>
            
            
            <tr>
            	<th scope="row">
            		<label for="spinrewriter_email"><?php echo _e('Youtube', 'cus-spin-tool');?></label>
            	</th>
            
            	<td>
            	<input name="diesel_social_media_youtube" id="diesel_social_media_youtube" type="text" class="regular-text" value="<?php if (get_option('diesel_social_media_youtube')) echo get_option('diesel_social_media_youtube'); ?>">
            	</td>
            
            </tr>
            
            
            <tr>
            	<th scope="row">
            		<label for="spinrewriter_email"><?php echo _e('Instagram', 'cus-spin-tool');?></label>
            	</th>
            
            	<td>
            	<input name="diesel_social_media_instagram" id="diesel_social_media_instagram" type="text" class="regular-text" value="<?php if (get_option('diesel_social_media_instagram')) echo get_option('diesel_social_media_instagram'); ?>">
            	</td>
            
            </tr>
            
            <tr>
            	<th scope="row">
            		<label for="spinrewriter_email"><?php echo _e('Printerest', 'cus-spin-tool');?></label>
            	</th>
            
            	<td>
            	<input name="diesel_social_media_printerest" id="diesel_social_media_printerest" type="text" class="regular-text" value="<?php if (get_option('diesel_social_media_printerest')) echo get_option('diesel_social_media_printerest'); ?>">
            	</td>
            
            </tr>
            
            <tr>
            	<th scope="row">
            		<label for="spinrewriter_email"><?php echo _e('Gmail', 'cus-spin-tool');?></label>
            	</th>
            
            	<td>
            	<input name="diesel_social_media_gmail" id="diesel_social_media_gmail" type="text" class="regular-text" value="<?php if (get_option('diesel_social_media_gmail')) echo get_option('diesel_social_media_gmail'); ?>">
            	</td>
            
            </tr>
            
            
            <tr>
				<td colspan="3">
					<h1><?php echo _e('Banner Links', 'cus-spin-tool');?></h1>
				</td>
			</tr>
			
			
            <tr>
                <th scope="row">
            		<label for="spinrewriter_email"><?php echo _e('Link1', 'cus-spin-tool');?></label>
            	</th>
            	
                <td>
            	<input name="diesel_baaner_link1" id="diesel_baaner_link1" type="text" class="regular-text" value="<?php if (get_option('diesel_baaner_link1')) echo get_option('diesel_baaner_link1'); ?>">
            	</td>
            </tr>
            
            
            <tr>
                <th scope="row">
            		<label for="spinrewriter_email"><?php echo _e('Link2', 'cus-spin-tool');?></label>
            	</th>
            	<td>
            	<input name="diesel_baaner_link2" id="diesel_baaner_link1" type="text" class="regular-text" value="<?php if (get_option('diesel_baaner_link2')) echo get_option('diesel_baaner_link2'); ?>">
            	</td>
            </tr>




            <tr>
                  <td colspan="3">
                        <h1><?php echo _e('Ads Settings', 'cus-spin-tool'); ?></h1>
                  </td>
            </tr>
            <tr>
                  <th scope="row">
                        <label for="spinrewriter_email"><?php echo _e('Ads', 'cus-spin-tool');?></label>
                  </th>
                  <td>
                  <select name="diesel_ads_url_opt" id="diesel_ads_url_opt">
                        <option value="" <?php echo selected(get_option('diesel_ads_url_opt'), '');?> >--select--</option>
                        <option value="show" <?php echo selected(get_option('diesel_ads_url_opt'), 'show');?> >Show</option>
                        <option value="hide" <?php echo selected(get_option('diesel_ads_url_opt'), 'hide');?> >Hide</option>
                  </select>
                  </td>
            </tr>

			</tbody>

		</table>


		<!---->
		<input type="hidden" name="action" value="update" />
      	<input type="hidden" name="page_options" value="diesel_social_media_facebook,diesel_social_media_twitter,diesel_social_media_youtube,diesel_social_media_instagram,diesel_social_media_printerest,diesel_social_media_gmail,diesel_baaner_link1,diesel_baaner_link2,diesel_ads_url_opt" />
		<!---->

		<p class="submit">
			<input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>

	</form>
</div>
<!---->
<?php
}
?>