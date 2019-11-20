<?php
/*
* custom-inner-page-advertisement.php
*/

//$diesel_ads_url_opt = get_option('diesel_ads_url_opt');

//$diesel_ads_script_opt = get_option('diesel_ads_script_opt');

$upload_ad_image = get_field('upload_ad_image', get_the_ID());

$diesel_ads_url_opt = get_option('diesel_ads_url_opt');
?>


<?php if (   $diesel_ads_url_opt == 'show' ) { ?>

	<?php if ($upload_ad_image && !empty($upload_ad_image)) {  $url = $upload_ad_image['url']; ?>

		<div class="diesel-ads-image"><img src="<?php echo $url; ?>"></div>

	<?php }else{ ?>

	<?php } ?>

<?php } ?>


