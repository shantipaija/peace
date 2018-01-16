<?php
/**
 * Peace Customizer
 *
 * @package Peace
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function peace_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	$wp_customize->remove_control('header_textcolor');
	$wp_customize->remove_control('background_color');
}
add_action( 'customize_register', 'peace_customize_register' );

/**
 * Options for Peace Customizer.
 */
function peace_customizer( $wp_customize ) {

	/* Main option Settings Panel */
	$wp_customize->add_panel('peace_main_options', array(
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => __( 'Peace Options', 'peace' ),
		'description' => __( 'Panel to update Peace theme options', 'peace' ), // Include html tags such as <p>.
		'priority' => 10,// Mixed with top-level-section hierarchy.
	));


	/* Main option Settings Panel */
	$wp_customize->add_panel('peace_homepage_options', array(
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => __( 'Peace HomePage Options', 'peace' ),
		'description' => __( 'Panel to update Peace homepage options', 'peace' ), // Include html tags such as <p>.
		'priority' => 10,// Mixed with top-level-section hierarchy.
	));

	// add "Content Options" section
	$wp_customize->add_section( 'peace_content_section' , array(
		'title'      => esc_html__( 'Content Options', 'peace' ),
		'priority'   => 50,
		'panel' => 'peace_main_options',
	) );
	// add setting for excerpts/full posts toggle
	$wp_customize->add_setting( 'peace_excerpts', array(
		'default'           => 0,
		'sanitize_callback' => 'peace_sanitize_checkbox',
	) );
	// add checkbox control for excerpts/full posts toggle
	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'peace_excerpts', array(
		'label'     => esc_html__( 'Show post excerpts in Home, Archive, and Category pages', 'peace' ),
		'section'   => 'peace_content_section',
		'priority'  => 10,
		'type'      => 'epsilon-toggle',
	) ) );

	$wp_customize->add_setting( 'peace_page_comments', array(
		'default' => 1,
		'sanitize_callback' => 'peace_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'peace_page_comments', array(
		'label'     => esc_html__( 'Display Comments on Static Pages?', 'peace' ),
		'section'   => 'peace_content_section',
		'priority'  => 20,
		'type'      => 'epsilon-toggle',
	) ) );


	// add setting for Show/Hide posts date toggle
	$wp_customize->add_setting( 'peace_post_date', array(
		'default'           => 1,
		'sanitize_callback' => 'peace_sanitize_checkbox',
	) );
	// add checkbox control for Show/Hide posts date toggle
	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'peace_post_date', array(
		'label'     => esc_html__( 'Show post date?', 'peace' ),
		'section'   => 'peace_content_section',
		'priority'  => 30,
		'type'      => 'epsilon-toggle',
	) ) );

	// add setting for Show/Hide posts Author Bio toggle
	$wp_customize->add_setting( 'peace_post_author_bio', array(
		'default'           => 1,
		'sanitize_callback' => 'peace_sanitize_checkbox',
	) );
	// add checkbox control for Show/Hide posts Author Bio toggle
	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'peace_post_author_bio', array(
		'label'     => esc_html__( 'Show Author Bio?', 'peace' ),
		'section'   => 'peace_content_section',
		'priority'  => 40,
		'type'      => 'epsilon-toggle',
	) ) );



	/* Peace Main Options */
	$wp_customize->add_section('peace_slider_options', array(
		'title' => __( 'Slider options', 'peace' ),
		'priority' => 31,
		'panel' => 'peace_homepage_options',
	));
	$wp_customize->add_setting( 'peace[peace_slider_checkbox]', array(
		'default' => 0,
		'type' => 'option',
		'sanitize_callback' => 'peace_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'peace[peace_slider_checkbox]', array(
		'label' => esc_html__( 'Check if you want to enable slider', 'peace' ),
		'section'   => 'peace_slider_options',
		'priority'  => 5,
		'type'      => 'epsilon-toggle',
	) ) );
	$wp_customize->add_setting( 'peace[peace_slider_link_checkbox]', array(
		'default' => 1,
		'type' => 'option',
		'sanitize_callback' => 'peace_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'peace[peace_slider_link_checkbox]', array(
		'label' => esc_html__( 'Turn "off" this option to remove the link from the slides', 'peace' ),
		'section'   => 'peace_slider_options',
		'priority'  => 6,
		'type'      => 'epsilon-toggle',
	) ) );

	// Pull all the categories into an array
	global $options_categories;
	$wp_customize->add_setting('peace[peace_slide_categories]', array(
		'default' => '',
		'type' => 'option',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'peace_sanitize_slidecat',
	));
	$wp_customize->add_control('peace[peace_slide_categories]', array(
		'label' => __( 'Slider Category', 'peace' ),
		'section' => 'peace_slider_options',
		'type'    => 'select',
		'description' => __( 'Select a category for the featured post slider', 'peace' ),
		'choices'    => $options_categories,
	));

	$wp_customize->add_setting('peace[peace_slide_number]', array(
		'default' => 3,
		'type' => 'option',
		'sanitize_callback' => 'peace_sanitize_number',
	));
	$wp_customize->add_control('peace[peace_slide_number]', array(
		'label' => __( 'Number of slide items', 'peace' ),
		'section' => 'peace_slider_options',
		'description' => __( 'Enter the number of slide items', 'peace' ),
		'type' => 'text',
	));
/*
	$wp_customize->add_setting('peace[peace_slide_height]', array(
		'default' => 500,
		'type' => 'option',
		'sanitize_callback' => 'peace_sanitize_number',
	));
	$wp_customize->add_control('peace[peace_slide_height]', array(
		'label' => __( 'Height of slider ', 'peace' ),
		'section' => 'peace_slider_options',
		'description' => __( 'Enter the height for slider', 'peace' ),
		'type' => 'text',
	));
*/
	$wp_customize->add_section('peace_layout_options', array(
		'title' => __( 'Layout Options', 'peace' ),
		'priority' => 31,
		'panel' => 'peace_main_options',
	));
	$wp_customize->add_section('peace_style_color_options', array(
		'title' => __( 'Color Schemes', 'peace' ),
		'priority' => 31,
		'panel' => 'peace_main_options',
	));

	// Layout options
	global $site_layout;
	$wp_customize->add_setting('peace[site_layout]', array(
		'default' => 'side-pull-left',
		'type' => 'option',
		'sanitize_callback' => 'peace_sanitize_layout',
	));
	$wp_customize->add_control('peace[site_layout]', array(
		'label' => __( 'Website Layout Options', 'peace' ),
		'section' => 'peace_layout_options',
		'type'    => 'select',
		'description' => __( 'Choose between different layout options to be used as default', 'peace' ),
		'choices'    => $site_layout,
	));

	// Colorful Template Styles options
	global $style_color;
	$wp_customize->add_setting('peace[style_color]', array(
		'default' => 'white-style',
		'type' => 'option',
		'sanitize_callback' => 'peace_sanitize_template',
	));
	$wp_customize->add_control('peace[style_color]', array(
		'label' => __( 'Color Schemes', 'peace' ),
		'section' => 'peace_style_color_options',
		'type'    => 'select',
		'description' => __( 'Choose between different color template options to be used as default', 'peace' ),
		'choices'    => $style_color,
	));

	//Background color
	$wp_customize->add_setting('peace[background_color]', array(
		'default' => sanitize_hex_color( 'cccccc' ),
		'type'  => 'option',
		'sanitize_callback' => 'peace_sanitize_hexcolor',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'peace[background_color]', array(
		'label' => __( 'Background Color', 'peace' ),
		//'description'   => __( 'Background Color','peace' ),
		'section' => 'peace_style_color_options',
	)));

	if ( class_exists( 'WooCommerce' ) ) {
		$wp_customize->add_setting('peace[woo_site_layout]', array(
			'default' => 'full-width',
			'type' => 'option',
			'sanitize_callback' => 'peace_sanitize_layout',
		));
		$wp_customize->add_control('peace[woo_site_layout]', array(
			'label' => __( 'WooCommerce Page Layout Options', 'peace' ),
			'section' => 'peace_layout_options',
			'type'    => 'select',
			'description' => __( 'Choose between different layout options to be used as default for all woocommerce pages', 'peace' ),
			'choices'    => $site_layout,
		));
	}

	$wp_customize->add_setting('peace[element_color_hover]', array(
		// 'default' => sanitize_hex_color( '#DADADA' ),
		'type'  => 'option',
		'sanitize_callback' => 'peace_sanitize_hexcolor',
	));


	 /* Peace Call To Action Options */
	$wp_customize->add_section('peace_action_options', array(
		'title' => __( 'Call To Action (CTA)', 'peace' ),
		'priority' => 31,
		'panel' => 'peace_homepage_options',
	));


	$wp_customize->add_setting('peace[cfa_bg_color]', array(
		// 'default' => sanitize_hex_color( '#FFF' ),
		'type'  => 'option',
		'sanitize_callback' => 'peace_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'peace[cfa_bg_color]', array(
		'label' => __( 'CTA Section : Background Color', 'peace' ),
		'description'   => __( 'Default used if no color is selected','peace' ),
		'section' => 'peace_action_options',
	)));


	$wp_customize->add_setting('peace[w2f_cfa_text]', array(
		'default' => '',
		'type' => 'option',
		'sanitize_callback' => 'peace_sanitize_strip_slashes',
	));
	$wp_customize->add_control('peace[w2f_cfa_text]', array(
		'label' => __( 'Call To Action - Message Text', 'peace' ),
		'description' => sprintf( __( 'Enter the text for CTA section', 'peace' ) ),
		'section' => 'peace_action_options',
		'type' => 'textarea',
	));


	$wp_customize->add_setting('peace[cfa_color]', array(
		// 'default' => sanitize_hex_color( 'rgba(59, 59, 59, 0.8)' ),
		'type'  => 'option',
		'sanitize_callback' => 'peace_sanitize_hexcolor',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'peace[cfa_color]', array(
		'label' => __( 'Call To Action - Message Text Color', 'peace' ),
		'description'   => __( 'Default used if no color is selected','peace' ),
		'section' => 'peace_action_options',
	)));


	$wp_customize->add_setting('peace[w2f_cfa_button]', array(
		'default' => '',
		'type' => 'option',
		'sanitize_callback' => 'peace_sanitize_nohtml',
	));

	$wp_customize->add_control('peace[w2f_cfa_button]', array(
		'label' => __( 'CTA Button Text', 'peace' ),
		'section' => 'peace_action_options',
		'description' => __( 'Enter the text for CTA button', 'peace' ),
		'type' => 'text',
	));

	$wp_customize->add_setting('peace[w2f_cfa_link]', array(
		'default' => '',
		'type' => 'option',
		'sanitize_callback' => 'esc_url_raw',
	));
	$wp_customize->add_control('peace[w2f_cfa_link]', array(
		'label' => __( 'CTA button link', 'peace' ),
		'section' => 'peace_action_options',
		'description' => __( 'Enter the link for CTA button', 'peace' ),
		'type' => 'text',
	));



	$wp_customize->add_setting('peace[cfa_btn_txt_color]', array(
		// 'default' => sanitize_hex_color( 'rgba(59, 59, 59, 0.8)' ),
		'type'  => 'option',
		'sanitize_callback' => 'peace_sanitize_hexcolor',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'peace[cfa_btn_txt_color]', array(
		'label' => __( 'CTA Button Text Color', 'peace' ),
		'description'   => __( 'Default used if no color is selected','peace' ),
		'section' => 'peace_action_options',
	)));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'peace[element_color_hover]', array(
		'label' => __( 'CTA Button Color on hover', 'peace' ),
		'description'   => __( 'Default used if no color is selected','peace' ),
		'section' => 'peace_action_options',
		'settings' => 'peace[element_color_hover]',
	)));

	$wp_customize->add_setting('peace[cfa_btn_color]', array(
		// 'default' => sanitize_hex_color( 'rgba(59, 59, 59, 0.8)' ),
		'type'  => 'option',
		'sanitize_callback' => 'peace_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'peace[cfa_btn_color]', array(
		'label' => __( 'CTA Button Border Color', 'peace' ),
		'description'   => __( 'Default used if no color is selected','peace' ),
		'section' => 'peace_action_options',
	)));


	/* this setting overrides other buttons */
	/*
		$wp_customize->add_setting('peace[element_color]', array(
			'default' => sanitize_hex_color( 'rgba(59, 59, 59, 0.8)' ),
			'type'  => 'option',
			'sanitize_callback' => 'peace_sanitize_hexcolor',
		));
		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'peace[element_color]', array(
			'label' => __( 'CTA Button Color', 'peace' ),
			'description'   => __( 'Default used if no color is selected','peace' ),
			'section' => 'peace_action_options',
			'settings' => 'peace[element_color]',
		)));

		*/
	/* Peace Typography Options */
	$wp_customize->add_section('peace_typography_options', array(
		'title' => __( 'Typography', 'peace' ),
		'priority' => 31,
		'panel' => 'peace_main_options',
	));
	// Typography Defaults
	$typography_defaults = array(
		'size'  => '14px',
		'face'  => 'Open Sans',
		'style' => 'normal',
		'color' => '#6B6B6B',
	);

	// Typography Options
	global $typography_options;
	$wp_customize->add_setting('peace[main_body_typography][size]', array(
		'default' => $typography_defaults['size'],
		'type' => 'option',
		'sanitize_callback' => 'peace_sanitize_typo_size',
	));
	$wp_customize->add_control('peace[main_body_typography][size]', array(
		'label' => __( 'Main Body Text', 'peace' ),
		'description' => __( 'Used in p tags', 'peace' ),
		'section' => 'peace_typography_options',
		'type'    => 'select',
		'choices'    => $typography_options['sizes'],
	));
	$wp_customize->add_setting('peace[main_body_typography][face]', array(
		'default' => $typography_defaults['face'],
		'type' => 'option',
		'sanitize_callback' => 'peace_sanitize_typo_face',
	));
	$wp_customize->add_control('peace[main_body_typography][face]', array(
		'section' => 'peace_typography_options',
		'type'    => 'select',
		'choices'    => $typography_options['faces'],
	));
	$wp_customize->add_setting('peace[main_body_typography][style]', array(
		'default' => $typography_defaults['style'],
		'type' => 'option',
		'sanitize_callback' => 'peace_sanitize_typo_style',
	));
	$wp_customize->add_control('peace[main_body_typography][style]', array(
		'section' => 'peace_typography_options',
		'type'    => 'select',
		'choices'    => $typography_options['styles'],
	));
	$wp_customize->add_setting('peace[main_body_typography][color]', array(
		// 'default' => sanitize_hex_color( '#6B6B6B' ),
		'type'  => 'option',
		'sanitize_callback' => 'peace_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'peace[main_body_typography][color]', array(
		'section' => 'peace_typography_options',
	)));
	$wp_customize->add_setting('peace[main_body_typography][subset]', array(
        'default' => '',
        'type' => 'option',
        'sanitize_callback' => 'esc_html'
    ));
    $wp_customize->add_control('peace[main_body_typography][subset]', array(
        'label' => __('Font Subset', 'peace'),
        'section' => 'peace_typography_options',
        'description' => __('Enter the Google fonts subset', 'peace'),
        'type' => 'text'
    ));

	$wp_customize->add_setting('peace[heading_color]', array(
		// 'default' => sanitize_hex_color( '#444' ),
		'type'  => 'option',
		'sanitize_callback' => 'peace_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'peace[heading_color]', array(
		'label' => __( 'Heading Color', 'peace' ),
		'description'   => __( 'Color for all headings (h1-h6)','peace' ),
		'section' => 'peace_typography_options',
	)));
	$wp_customize->add_setting('peace[link_color]', array(
		// 'default' => sanitize_hex_color( 'rgba(59, 59, 59, 0.8)' ),
		'type'  => 'option',
		'sanitize_callback' => 'peace_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'peace[link_color]', array(
		'label' => __( 'Link Color', 'peace' ),
		'description'   => __( 'Default used if no color is selected','peace' ),
		'section' => 'peace_typography_options',
	)));
	$wp_customize->add_setting('peace[link_hover_color]', array(
		// 'default' => sanitize_hex_color( '#000000' ),
		'type'  => 'option',
		'sanitize_callback' => 'peace_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'peace[link_hover_color]', array(
		'label' => __( 'Link:hover Color', 'peace' ),
		'description'   => __( 'Default used if no color is selected','peace' ),
		'section' => 'peace_typography_options',
	)));

	/* Peace Header Options */
	$wp_customize->add_section('peace_header_options', array(
		'title' => __( 'Header Menu', 'peace' ),
		'priority' => 31,
		'panel' => 'peace_main_options',
	));

	$wp_customize->add_setting('peace[sticky_menu]', array(
		'default' => 0,
		'type' => 'option',
		'sanitize_callback' => 'peace_sanitize_checkbox',
	));
	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'peace[sticky_menu]', array(
		'label' => __( 'Sticky Menu', 'peace' ),
		'description' => sprintf( __( 'Check to show fixed header', 'peace' ) ),
		'section' => 'peace_header_options',
		'type' => 'epsilon-toggle',
	) ) );

//header-text-color
	$wp_customize->add_setting('peace[header_text_color]', array(
		'default' => '', //sanitize_hex_color( '#ffffff' ),
		'type'  => 'option',
		'sanitize_callback' => 'peace_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'peace[header_text_color]', array(
		'label' => __( 'Header Text Color', 'peace' ),
		'description'   => __( 'Default used if no color is selected','peace' ),
		'section' => 'peace_header_options',
	)));
//header-text-color

	$wp_customize->add_setting('peace[nav_bg_color]', array(
		'default' => '', //sanitize_hex_color( '#ffffff' ),
		'type'  => 'option',
		'sanitize_callback' => 'peace_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'peace[nav_bg_color]', array(
		'label' => __( 'Top nav background color', 'peace' ),
		'description'   => __( 'Default used if no color is selected','peace' ),
		'section' => 'peace_header_options',
	)));

	$wp_customize->add_setting('peace[nav_link_color]', array(
		// 'default' => sanitize_hex_color( '#000000' ),
		'type'  => 'option',
		'sanitize_callback' => 'peace_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'peace[nav_link_color]', array(
		'label' => __( 'Top nav item color', 'peace' ),
		'description'   => __( 'Link color','peace' ),
		'section' => 'peace_header_options',
	)));

	$wp_customize->add_setting('peace[nav_item_hover_color]', array(
		// 'default' => sanitize_hex_color( 'rgba(59, 59, 59, 0.8)' ),
		'type'  => 'option',
		'sanitize_callback' => 'peace_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'peace[nav_item_hover_color]', array(
		'label' => __( 'Top nav item hover color', 'peace' ),
		'description'   => __( 'Link:hover color','peace' ),
		'section' => 'peace_header_options',
	)));

	$wp_customize->add_setting('peace[nav_dropdown_bg]', array(
		// 'default' => sanitize_hex_color( '#ffffff' ),
		'type'  => 'option',
		'sanitize_callback' => 'peace_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'peace[nav_dropdown_bg]', array(
		'label' => __( 'Top nav dropdown background color', 'peace' ),
		'description'   => __( 'Background of dropdown item hover color','peace' ),
		'section' => 'peace_header_options',
	)));

	$wp_customize->add_setting('peace[nav_dropdown_item]', array(
		// 'default' => sanitize_hex_color( '#636467' ),
		'type'  => 'option',
		'sanitize_callback' => 'peace_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'peace[nav_dropdown_item]', array(
		'label' => __( 'Top nav dropdown item color', 'peace' ),
		'description'   => __( 'Dropdown item color','peace' ),
		'section' => 'peace_header_options',
	)));

	$wp_customize->add_setting('peace[nav_dropdown_item_hover]', array(
		// 'default' => sanitize_hex_color( '#FFF' ),
		'type'  => 'option',
		'sanitize_callback' => 'peace_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'peace[nav_dropdown_item_hover]', array(
		'label' => __( 'Top nav dropdown item hover color', 'peace' ),
		'description'   => __( 'Dropdown item hover color','peace' ),
		'section' => 'peace_header_options',
	)));

	$wp_customize->add_setting('peace[nav_dropdown_bg_hover]', array(
		// 'default' => sanitize_hex_color( 'rgba(59, 59, 59, 0.8)' ),
		'type'  => 'option',
		'sanitize_callback' => 'peace_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'peace[nav_dropdown_bg_hover]', array(
		'label' => __( 'Top nav dropdown item background hover color', 'peace' ),
		'description'   => __( 'Background of dropdown item hover color','peace' ),
		'section' => 'peace_header_options',
	)));

	/* Peace Footer Options */
	$wp_customize->add_section('peace_footer_options', array(
		'title' => __( 'Footer', 'peace' ),
		'priority' => 31,
		'panel' => 'peace_main_options',
	));
	$wp_customize->add_setting('peace[footer_widget_bg_color]', array(
		// 'default' => sanitize_hex_color( 'rgba(59, 59, 59, 0.8)' ),
		'type'  => 'option',
		'sanitize_callback' => 'peace_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'peace[footer_widget_bg_color]', array(
		'label' => __( 'Footer widget area background color', 'peace' ),
		'section' => 'peace_footer_options',
	)));

	$wp_customize->add_setting('peace[footer_bg_color]', array(
		// 'default' => sanitize_hex_color( '#1F1F1F' ),
		'type'  => 'option',
		'sanitize_callback' => 'peace_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'peace[footer_bg_color]', array(
		'label' => __( 'Footer background color', 'peace' ),
		'section' => 'peace_footer_options',
	)));

	$wp_customize->add_setting('peace[footer_text_color]', array(
		// 'default' => sanitize_hex_color( '#999' ),
		'type'  => 'option',
		'sanitize_callback' => 'peace_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'peace[footer_text_color]', array(
		'label' => __( 'Footer text color', 'peace' ),
		'section' => 'peace_footer_options',
	)));

	$wp_customize->add_setting('peace[footer_link_color]', array(
		// 'default' => sanitize_hex_color( '#DADADA' ),
		'type'  => 'option',
		'sanitize_callback' => 'peace_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'peace[footer_link_color]', array(
		'label' => __( 'Footer link color', 'peace' ),
		'section' => 'peace_footer_options',
	)));

	$wp_customize->add_setting('peace[custom_footer_text]', array(
		//'default' => 'peace',
		'type' => 'option',
		'sanitize_callback' => 'peace_sanitize_strip_slashes',
	));
	$wp_customize->add_control('peace[custom_footer_text]', array(
		'label' => __( 'Footer information', 'peace' ),
		'description' => sprintf( __( 'Footer Text (like Copyright Message)', 'peace' ) ),
		'section' => 'peace_footer_options',
		'type' => 'textarea',
	));

	/* Peace Social Options */
	$wp_customize->add_section('peace_social_options', array(
		'title' => __( 'Social', 'peace' ),
		'priority' => 31,
		'panel' => 'peace_main_options',
	));
	$wp_customize->add_setting('peace[social_color]', array(
		// 'default' => sanitize_hex_color( '#DADADA' ),
		'type'  => 'option',
		'sanitize_callback' => 'peace_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'peace[social_color]', array(
		'label' => __( 'Social icon color', 'peace' ),
		'description' => sprintf( __( 'Default used if no color is selected', 'peace' ) ),
		'section' => 'peace_social_options',
	)));

	$wp_customize->add_setting('peace[social_footer_color]', array(
		// 'default' => sanitize_hex_color( '#DADADA' ),
		'type'  => 'option',
		'sanitize_callback' => 'peace_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'peace[social_footer_color]', array(
		'label' => __( 'Footer social icon color', 'peace' ),
		'description' => sprintf( __( 'Default used if no color is selected', 'peace' ) ),
		'section' => 'peace_social_options',
	)));

	$wp_customize->add_setting('peace[footer_social]', array(
		'default' => 0,
		'type' => 'option',
		'sanitize_callback' => 'peace_sanitize_checkbox',
	));
	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'peace[footer_social]', array(
		'label' => __( 'Footer Social Icons', 'peace' ),
		'description' => sprintf( __( 'Check to show social icons in footer', 'peace' ) ),
		'section' => 'peace_social_options',
		'type' => 'epsilon-toggle',
	) ) );

}
add_action( 'customize_register', 'peace_customizer' );



/**
 * Sanitzie checkbox for WordPress customizer
 */
function peace_sanitize_checkbox( $input ) {
	if ( 1 == $input ) {
		return 1;
	} else {
		return '';
	}
}
/**
 * Adds sanitization callback function: colors
 * @package Peace
 */
function peace_sanitize_hexcolor( $color ) {
	$unhashed = sanitize_hex_color_no_hash( $color );
	if ( $unhashed ) {
		return '#' . $unhashed;
	}
	return $color;
}

/**
 * Adds sanitization callback function: Nohtml
 * @package Peace
 */
function peace_sanitize_nohtml( $input ) {
	return wp_filter_nohtml_kses( $input );
}

/**
 * Adds sanitization callback function: Number
 * @package Peace
 */
function peace_sanitize_number( $input ) {
	if ( isset( $input ) && is_numeric( $input ) ) {
		return $input;
	}
}

/**
 * Adds sanitization callback function: Strip Slashes
 * @package Peace
 */
function peace_sanitize_strip_slashes( $input ) {
	return wp_kses_stripslashes( $input );
}

/**
 * Adds sanitization callback function: Sanitize Text area
 * @package Peace
 */
function peace_sanitize_textarea( $input ) {
	return sanitize_text_field( $input );
}

/**
 * Adds sanitization callback function: Slider Category
 * @package Peace
 */
function peace_sanitize_slidecat( $input ) {
	global $options_categories;
	if ( array_key_exists( $input, $options_categories ) ) {
		return $input;
	} else {
		return '';
	}
}

/**
 * Adds sanitization callback function: Sidebar Layout
 * @package Peace
 */
function peace_sanitize_layout( $input ) {
	global $site_layout;
	if ( array_key_exists( $input, $site_layout ) ) {
		return $input;
	} else {
		return '';
	}
}

/**
 * Adds sanitization callback function: Color Template
 * @package Peace
 */
function peace_sanitize_template( $input ) {
	global $style_color;
	if ( array_key_exists( $input, $style_color ) ) {
		return $input;
	} else {
		return '';
	}
}

/**
 * Adds sanitization callback function: Typography Size
 * @package Peace
 */
function peace_sanitize_typo_size( $input ) {
	global $typography_options, $typography_defaults;
	if ( array_key_exists( $input, $typography_options['sizes'] ) ) {
		return $input;
	} else {
		return $typography_defaults['size'];
	}
}
/**
 * Adds sanitization callback function: Typography Face
 * @package Peace
 */
function peace_sanitize_typo_face( $input ) {
	global $typography_options, $typography_defaults;
	if ( array_key_exists( $input, $typography_options['faces'] ) ) {
		return $input;
	} else {
		return $typography_defaults['face'];
	}
}
/**
 * Adds sanitization callback function: Typography Style
 * @package Peace
 */
function peace_sanitize_typo_style( $input ) {
	global $typography_options, $typography_defaults;
	if ( array_key_exists( $input, $typography_options['styles'] ) ) {
		return $input;
	} else {
		return $typography_defaults['style'];
	}
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function peace_customize_preview_js() {
	wp_enqueue_script( 'peace_customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20140317', true );
}
add_action( 'customize_preview_init', 'peace_customize_preview_js' );

/**
 * Add CSS for custom controls
 */
function peace_customizer_custom_control_css() {
	?>
	<style>
		#customize-control-peace-main_body_typography-size select, #customize-control-peace-main_body_typography-face select,#customize-control-peace-main_body_typography-style select { width: 60%; }
	</style><?php
}
add_action( 'customize_controls_print_styles', 'peace_customizer_custom_control_css' );

/*
 * Custom Scripts
 */
add_action( 'customize_controls_print_footer_scripts', 'customizer_custom_scripts' );

function customizer_custom_scripts() {
	?>
<script>
	jQuery(document).ready(function() {
		/* This one shows/hides the an option when a checkbox is clicked. */
		jQuery('#customize-control-peace-peace_slide_categories, #customize-control-peace-peace_slide_number').hide();
		jQuery('#customize-control-peace-peace_slider_checkbox input').click(function() {
			jQuery('#customize-control-peace-peace_slide_categories, #customize-control-peace-peace_slide_number').fadeToggle(400);
		});

		if (jQuery('#customize-control-peace-peace_slider_checkbox input:checked').val() !== undefined) {
			jQuery('#customize-control-peace-peace_slide_categories, #customize-control-peace-peace_slide_number').show();
		}
	});
</script>
<style>
	li#accordion-section-peace_important_links h3.accordion-section-title, li#accordion-section-peace_important_links h3.accordion-section-title:focus { background-color: #00cc00 !important; color: #fff !important; }
	li#accordion-section-peace_important_links h3.accordion-section-title:hover { background-color: #00b200 !important; color: #fff !important; }
	li#accordion-section-peace_important_links h3.accordion-section-title:after { color: #fff !important; }
</style>
<?php
}
