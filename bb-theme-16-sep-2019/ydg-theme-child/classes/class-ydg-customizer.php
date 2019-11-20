<?php

final class YDGCustomizer {

	// add settings to customizer
	static public function register_customize_settings( $wp_customize )
	{

		// sections
		$wp_customize->add_section( 'ydg-brand-colors', array(
			'priority' 			=> 0,
			'capability' 		=> 'edit_theme_options',
			'theme_supports' 	=> '',
			'title' 			=> __('Brand Colors', 'fl-automator'),
			'description' 		=>  __('', 'fl-automator'),
			'panel' 			=> 'fl-general',
		) );
		$wp_customize->add_section( 'ydg-module-styles', array(
			'priority' 			=> 6,
			'capability' 		=> 'edit_theme_options',
			'theme_supports' 	=> '',
			'title' 			=> __('Module Styles', 'fl-automator'),
			'description' 		=>  __('', 'fl-automator'),
			'panel' 			=> 'fl-general',
		) );
		$wp_customize->add_section( 'ydg-woocommerce-styles', array(
			'priority' 			=> 7,
			'capability' 		=> 'edit_theme_options',
			'theme_supports' 	=> '',
			'title' 			=> __('Woocommerce Styles', 'fl-automator'),
			'description' 		=>  __('', 'fl-automator'),
			'panel' 			=> 'fl-general',
		) );


		// brand colors
		$wp_customize->add_setting('ydg-brand-primary', array( 			// primary color
			'default'	 => '#d5d5d5',
			'transport'   => 'refresh',
		));
		$wp_customize->add_setting('ydg-brand-secondary', array( 		// secondary color
			'default'	 => '#F5F5F5',
			'transport'   => 'refresh',
		));

		// layout settings
		$wp_customize->add_setting('ydg-row-spacing', array( 			// row spacing
			'default'	 => '60',
			'transport'   => 'refresh',
		));
		$wp_customize->add_setting('ydg-module-spacing', array( 		// module spacing
			'default'	 => '5',
			'transport'   => 'refresh',
		));

		// header setting
		$wp_customize->add_setting('ydg-header-transparency', array( 	// home header setting
			'default'	 => 'visible',
			'transport'   => 'refresh',
		));

		// nav setting
		$wp_customize->add_setting('ydg-nav-animation', array( 			// nav animation
			'default'	 => 'lines',
			'transport'   => 'refresh',
		));

		// module settings
		$wp_customize->add_setting('ydg-images-style', array( 			// images style
			'default'	 => 'none',
			'transport'   => 'refresh',
		));
		$wp_customize->add_setting('ydg-button-style', array( 			// buttons style
			'default'	 => 'flat',
			'transport'   => 'refresh',
		));
		$wp_customize->add_setting('ydg-button-animation', array( 		// buttons animation
			'default'	 => 'fade',
			'transport'   => 'refresh',
		));
		$wp_customize->add_setting('ydg-icons-size', array( 			// icon sizes
			'default'	 => '60',
			'transport'   => 'refresh',
		));
		$wp_customize->add_setting('ydg-icons-style', array( 			// icon style
			'default'	 => 'none',
			'transport'   => 'refresh',
		));
		$wp_customize->add_setting('ydg-separators-style', array( 		// separators style
			'default'	 => 'fade',
			'transport'   => 'refresh',
		));

		// woocommerce settings
		$wp_customize->add_setting('ydg-woo-product-spacing', array( 	// Woocommerce Product Spacing
			'default'	 => '10',
			'transport'   => 'refresh',
		));
		$wp_customize->add_setting('ydg-woo-headers-size', array( 		// Woocommerce Archive Product Header Size
			'default'	 => '21',
			'transport'   => 'refresh',
		));
		$wp_customize->add_setting('ydg-woo-price-size', array( 		// Woocommerce Archive Product Price Size
			'default'	 => '18',
			'transport'   => 'refresh',
		));
		$wp_customize->add_setting('ydg-woo-stars-size', array( 		// Woocommerce Product Stars Size
			'default'	 => '14',
			'transport'   => 'refresh',
		));


		// color controls
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'ydg-brand-primary',
				array(
					'label'				=> __( 'Primary Color', 'fl-automator' ),
					'section'			=> 'ydg-brand-colors',
					'settings'			=> 'ydg-brand-primary',
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'ydg-brand-secondary',
				array(
					'label'				=> __( 'Secondary Color', 'fl-automator' ),
					'section'			=> 'ydg-brand-colors',
					'settings'			=> 'ydg-brand-secondary',
				)
			)
		);

		// spacing controls
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ydg-row-spacing',
				array(
					'label'				=> __( 'Row Spacing (px)', 'fl-automator' ),
					'section'			=> 'fl-layout',
					'settings'			=> 'ydg-row-spacing',
					'type'				=> 'number'
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ydg-module-spacing',
				array(
					'label'				=> __( 'Module Spacing (px)', 'fl-automator' ),
					'section'			=> 'fl-layout',
					'settings'			=> 'ydg-module-spacing',
					'type'				=> 'number'
				)
			)
		);

		// header transparency
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ydg-header-transparency',
				array(
					'label'				=> __( 'Transparency', 'fl-automator' ),
					'description'		=> __( 'Makes the header transparent on the home page.', 'fl-automator' ),
					'section'			=> 'fl-header-style',
					'priority'			=> 0,
					'settings'			=> 'ydg-header-transparency',
					'type'				=> 'select',
					'choices' 			=> array(
						'visible'   		=> __( 'Visible' ),
						'home-transparent'	=> __( 'Homepage Only' ),
						'transparent'		=> __( 'Transparent' )
					)
				)
			)
		);

		// navigation animation
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ydg-nav-animation',
				array(
					'label'				=> __( 'Nav Hover Animation', 'fl-automator' ),
					'section'			=> 'fl-nav-style',
					'priority'			=> 0,
					'settings'			=> 'ydg-nav-animation',
					'type'				=> 'select',
					'choices' 			=> array(
						'none'				=> __( 'None' ),
						'lines'   			=> __( 'Lines' ),
						'brackets'			=> __( 'Brackets' )
					)
				)
			)
		);

		// image styles
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ydg-images-style',
				array(
					'label'				=> __( 'Image Style', 'fl-automator' ),
					'section'			=> 'ydg-module-styles',
					'settings'			=> 'ydg-images-style',
					'type'				=> 'select',
					'choices'			=> array(
						'none'   			=> __( 'None' ),
						'padded-border'  	=> __( 'Padded Border' ),
						'shadow' 			=> __( 'Drop Shadow' ),
						'bottom-border'		=> __( 'Bottom Border' )
					)
				)
			)
		);

		// button styles
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ydg-button-style',
				array(
					'label'				=> __( 'Button Style', 'fl-automator' ),
					'section'			=> 'ydg-module-styles',
					'settings'			=> 'ydg-button-style',
					'type'				=> 'select',
					'choices'			=> array(
						'flat'				=> __( 'Flat' ),
						'border'			=> __( 'Border' ),
						'gradient'			=> __( 'Gradient' )
					)
				)
			)
		);

		// button animations
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ydg-button-animation',
				array(
					'label'				=> __( 'Button Hover Animation', 'fl-automator' ),
					'section'			=> 'ydg-module-styles',
					'settings'			=> 'ydg-button-animation',
					'type'				=> 'select',
					'choices'			=> array(
						'none'				=> __( 'None' ),
						'fade'				=> __( 'Fade' ),
						'grow'				=> __( 'Grow' ),
						'shrink'			=> __( 'Shrink' ),
						'sweep'				=> __( 'Sweep' ),
						'float'				=> __( 'Float' ),
						'underline'			=> __( 'Underline Sweep' )
					)
				)
			)
		);

		// icon size
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ydg-icons-size',
				array(
					'label'				=> __( 'Icon Size (px)', 'fl-automator' ),
					'section'			=> 'ydg-module-styles',
					'settings'			=> 'ydg-icons-size',
					'type'				=> 'number'
				)
			)
		);

		// icon style
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ydg-icons-style',
				array(
					'label'				=> __( 'Icon Style', 'fl-automator' ),
					'section'			=> 'ydg-module-styles',
					'settings'			=> 'ydg-icons-style',
					'type'				=> 'select',
					'choices'			=> array(
						'none'				=> __( 'None' ),
						'circle'			=> __( 'Circle' ),
						'hexagon'			=> __( 'Hexagon' ),
						'fade'				=> __( 'Shadow' ),
						'gradient'			=> __( 'Gradient' )
					)
				)
			)
		);

		// separators
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ydg-separators-style',
				array(
					'label'				=> __( 'Separators', 'fl-automator' ),
					'section'			=> 'ydg-module-styles',
					'settings'			=> 'ydg-separators-style',
					'type'				=> 'select',
					'choices'			=> array(
						'default'			=> __( 'Default' ),
						'fade'				=> __( 'Fade' ),
						'dotted'			=> __( 'Dotted' ),
						'dashed'			=> __( 'Dashed' ),
						'double'			=> __( 'Double Line' ),
						'bevel'				=> __( 'Bevel' ),
						'narrow'			=> __( 'Narrow' ),
						'fancy'				=> __( 'Fancy Shadow' )
					)
				)
			)
		);

		// woocommerce controls
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ydg-woo-product-spacing',
				array(
					'label'				=> __( 'Product Spacing (px)', 'fl-automator' ),
					'section'			=> 'ydg-woocommerce-styles',
					'settings'			=> 'ydg-woo-product-spacing',
					'type'				=> 'number'
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ydg-woo-headers-size',
				array(
					'label'				=> __( 'Archive Header Size (px)', 'fl-automator' ),
					'section'			=> 'ydg-woocommerce-styles',
					'settings'			=> 'ydg-woo-headers-size',
					'type'				=> 'number'
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ydg-woo-price-size',
				array(
					'label'				=> __( 'Archive Price Size (px)', 'fl-automator' ),
					'section'			=> 'ydg-woocommerce-styles',
					'settings'			=> 'ydg-woo-price-size',
					'type'				=> 'number'
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ydg-woo-stars-size',
				array(
					'label'				=> __( 'Stars Size (px)', 'fl-automator' ),
					'section'			=> 'ydg-woocommerce-styles',
					'settings'			=> 'ydg-woo-stars-size',
					'type'				=> 'number'
				)
			)
		);

		// Let the preview get data
		$wp_customize->get_setting( 'ydg-brand-primary' )->transport = 'postMessage';
		$wp_customize->get_setting( 'ydg-brand-secondary' )->transport = 'postMessage';

		$wp_customize->get_setting( 'ydg-row-spacing' )->transport = 'postMessage';
		$wp_customize->get_setting( 'ydg-module-spacing' )->transport = 'postMessage';

		$wp_customize->get_setting( 'ydg-header-transparency' )->transport = 'postMessage';

		$wp_customize->get_setting( 'ydg-images-style' )->transport = 'postMessage';
		$wp_customize->get_setting( 'ydg-button-style' )->transport = 'postMessage';
		$wp_customize->get_setting( 'ydg-icons-size' )->transport = 'postMessage';
		$wp_customize->get_setting( 'ydg-separators-style' )->transport = 'postMessage';

		$wp_customize->get_setting( 'ydg-woo-product-spacing' )->transport = 'postMessage';
		$wp_customize->get_setting( 'ydg-woo-headers-size' )->transport = 'postMessage';
		$wp_customize->get_setting( 'ydg-woo-price-size' )->transport = 'postMessage';
		$wp_customize->get_setting( 'ydg-woo-stars-size' )->transport = 'postMessage';

	}

	static public function customizer_preview()
	{
		wp_enqueue_script( 'ydg-customizer-preview', get_stylesheet_directory_uri() . '/js/ydg-preview.js', array( 'jquery' ), uniqid(), true);
		wp_enqueue_style( 'ydg-customizer-preview', get_stylesheet_directory_uri() . '/css/preview.css', '', uniqid(), all);
	}

	static public function customizer_settings()
	{
		wp_enqueue_script( 'ydg-customizer-settings', get_stylesheet_directory_uri() . '/js/ydg-customizer.js', array( 'jquery' ), '1.0', true);
	}

}
