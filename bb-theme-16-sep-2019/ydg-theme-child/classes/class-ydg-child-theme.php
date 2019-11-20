<?php

require_once "scssphp/scss.inc.php";

use Leafo\ScssPhp\Compiler;

/**
 * Helper class for theme functions.
 *
 * @class FLChildTheme
 */
class YDGChildTheme {

    static private function is_dev() {
        return stripos( get_option('siteurl'), 'ydgdev' ) != false;
    }

	// check if files are updated, then return a boolean
	static public function check_for_updates()
    {
        if( self::is_dev() ) {
            self::compile_css();
            return true;
        }

		$sass_file_time = filemtime( YDG_CHILD_THEME_DIR . '/theme.scss' );
		$style_file_time = filemtime( YDG_CHILD_THEME_DIR . '/style.css' );
		$output_file_time = filemtime( YDG_CHILD_THEME_DIR . '/css/theme.css' );

		if( $sass_file_time > $output_file_time || $style_file_time > $output_file_time ) {
			self::compile_css();
            return true;
		} else {
			return false;
		}
	}

	// compile css
	static public function compile_css()
	{
		$scss = new Compiler(); // create class

        // settings
		$scss->setImportPaths( YDG_CHILD_THEME_DIR ); // set path
		$scss->addImportPath( YDG_CHILD_THEME_DIR . '/scss' );

        if( self::is_dev() ) {
            $scss->setFormatter('Leafo\ScssPhp\Formatter\Nested');
        } else {
            $scss->setFormatter('Leafo\ScssPhp\Formatter\Crunched');
        }

		// get mixins
		$css 			 = '@import "mixins";';

		// get settings
		$mods 			 = FLCustomizer::get_mods();

		// get brand colors
		$priColor 		 = FLColor::hex( array( $mods['ydg-brand-primary'], '#d5d5d5' ) );
		$secColor 		 = FLColor::hex( array( $mods['ydg-brand-secondary'], '#F5F5F5' ) );
		$css 			.= '$pri-color:' . $priColor . ';';
		$css 			.= '$sec-color:' . $secColor . ';';

		// get accent colors
		$accentColor	 = FLColor::hex( array( $mods['fl-accent'], '#428bca' ) );
		$hoverColor		 = FLColor::hex( array( $mods['fl-accent-hover'], '#428bca' ) );
		$css 			.= '$accent-color:' . $accentColor . ';';
		$css 			.= '$hover-color:' . $hoverColor . ';';

		// get text colors
		$headingColor	 = FLColor::hex( array( $mods['fl-heading-text-color'], '#333333' ) );
		$bodyColor		 = FLColor::hex( array( $mods['fl-body-text-color'], '#808080' ) );
		$css			.= '$heading-color:' . $headingColor . ';';
		$css			.= '$body-color:' . $bodyColor . ';';

		// row spacing
		if( isset($mods['ydg-row-spacing']) ) {
			$css		.= '$row-spacing: ' . $mods['ydg-row-spacing'] . 'px;';
		}

		// module spacing
		if( isset($mods['ydg-module-spacing']) ) {
			$css 		.= '$module-spacing: ' . $mods['ydg-module-spacing'] . 'px;';
		}

		// woocommerce
		$css 			.= 	'$woo-spacing:' . $mods['ydg-woo-product-spacing'] . 'px;' .
							'$woo-header:' 	. $mods['ydg-woo-headers-size'] . 'px;' .
							'$woo-price:' 	. $mods['ydg-woo-price-size'] . 'px;' .
							'$woo-stars:' 	. $mods['ydg-woo-stars-size'] . 'px;';

		// header transparency
		if( $mods['ydg-header-transparency'] == 'home-transparent' ) {
			$css 		.= '@import "header/header-home-transparent";';
		} elseif( $mods['ydg-header-transparency'] == 'transparent' ) {
			$css 		.= '@import "header/header-transparent";';
		}

		// nav
		if( isset($mods['ydg-nav-animation']) && $mods['ydg-nav-animation'] != 'none' ) {
			$css 		.= '@import "nav-animations/nav-' . $mods['ydg-nav-animation'] . '";';
		}

		// image style
		if( isset($mods['ydg-images-style']) && $mods['ydg-images-style']  != 'none') {
			$css 		.= '@import "images/img-' . $mods['ydg-images-style'] . '";';
			$css 		.= '@import "images/img-none";';
		}

		// buttons
		if( ! isset($mods['ydg-button-style']) ) {
			$mods['ydg-button-style'] = 'flat';
		}
		$css 			.= '$btn-style: ' . $mods['ydg-button-style'] . ';';
		$css 			.= '@import "buttons/btn-' . $mods['ydg-button-style'] . '";';

		// button animations
		if( $mods['ydg-button-animation'] != 'none' ) {
			$css 		.= '@import "buttons/hover-' . 	$mods['ydg-button-animation'] . '";';
		}

		// icon sizing
		if( ! isset($mods['ydg-icons-size']) ) {
			$mods['ydg-icons-size'] = '60';
		}
		$css 			.= '$icon-size: ' . $mods['ydg-icons-size'] . 'px;';

		// icon style
		if( isset($mods['ydg-icons-style']) && $mods['ydg-icons-style']  != 'none') {
			$css 		.= '@import "icons/icon-' . $mods['ydg-icons-style'] . '";';
			$css 		.= '@import "icons/icon-none";';
		}

		// separators
		if( isset($mods['ydg-separators-style']) && $mods['ydg-separators-style'] != 'default') {
			$css 		.= '@import "separators/separator-' . $mods['ydg-separators-style'] . '";';
		}

		// get files
		$css 			.= file_get_contents( YDG_CHILD_THEME_DIR . '/theme.scss' );
		$css 			.= file_get_contents( YDG_CHILD_THEME_DIR . '/style.css' );

		try {
			// compile
			$css 			 = $scss->compile($css);

			// output styles
			file_put_contents( YDG_CHILD_THEME_DIR . '/css/theme.css' , $css );
		}
        catch (Exception $e) {
			var_dump($e);
			echo $e->getMessage();
		}
	}

	// Load stylesheet
	static public function stylesheet()
	{
		echo '<link rel="stylesheet" href="' . YDG_CHILD_THEME_URL . '/css/theme.css" />';
	}

	static public function scripts()
	{
		wp_enqueue_script('ydg-custom', YDG_CHILD_THEME_URL . '/js/ydg-custom.js', array('jquery'), '1.0', true);
	}

	// change excerpt length to 20 characters
	static public function change_excerpt_length($length)
	{
		return 12;
	}

	// stop gravity forms styles from being loaded
    static public function remove_gform_styles()
    {
        wp_dequeue_style( 'gforms_reset_css' );
        // wp_dequeue_style( 'gforms_datepicker_css' );
        wp_dequeue_style( 'gforms_formsmain_css' );
        wp_dequeue_style( 'gforms_ready_class_css' );
        wp_dequeue_style( 'gforms_browsers_css' );
    }

	// change gravity forms settings to disable css output & enable html5
    static public function change_gform_options()
    {
        update_option( 'rg_gforms_disable_css', '1' );
    	update_option( 'rg_gforms_enable_html5', '1' );
    }
}
