<?php
/**
 * Peace functions and definitions
 *
 * @package Peace
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if (! isset($content_width)) {
    $content_width = 648; /* pixels */
}

/**
 * Set the content width for full width pages with no sidebar.
 */
function peace_content_width()
{
    if (is_page_template('page-fullwidth.php')) {
        global $content_width;
        $content_width = 1008; /* pixels */
    }
}
add_action('template_redirect', 'peace_content_width');

if (! function_exists('peace_main_content_bootstrap_classes')) :
    /**
 * Add Bootstrap classes to the main-content-area wrapper.
 */
    function peace_main_content_bootstrap_classes()
    {
        $layout_class = get_layout_class();
        if ($layout_class=="dbar") {
            return 'col-sm-6 col-md-6';
        } elseif (is_page_template('page-fullwidth.php')) {
            return 'col-sm-12 col-md-12';
        }
        return 'col-sm-12 col-md-8';
    }
endif; // peace_main_content_bootstrap_classes

if (! function_exists('peace_setup')) :
    /**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
    function peace_setup()
    {

          /*
           * Make theme available for translation.
           * Translations can be filed in the /languages/ directory.
           */
        load_theme_textdomain('peace', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

          add_theme_support( 'custom-logo' );

          add_theme_support( 'custom-header', array(
  	'wp-head-callback' => 'theme_slug_header_style',
  ) );


function theme_slug_header_style() {
	/*
	 * If header text is set to display, let's bail.
	 */
	if ( display_header_text() ) {
		return;
	}
	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
		.site-title,
		.site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}
	</style>
	<?php
}

          /*
           * Creating responsive video for posts/pages
           */
          if ( ! function_exists( 'peace_responsive_video' ) ) :
          	function peace_responsive_video( $html, $url, $attr, $post_ID ) {
          		return '<div class="fitvids-video">' . $html . '</div>';
          	}

          	add_filter( 'embed_oembed_html', 'peace_responsive_video', 10, 4 );
          endif;

          /**************************************************************************************/
        /**
   * Enable support for Post Thumbnails on posts and pages.
   *
   * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
   */
        add_theme_support('post-thumbnails');

        add_image_size('peace-featured', 750, 410, true);
        add_image_size('peace-featured-fullwidth', 1140, 624, true);
        add_image_size('tab-small', 60, 60, true); // Small Thumbnail

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
              'primary'      => esc_html__('Primary Menu', 'peace'),
              'footer-links' => esc_html__('Footer Links', 'peace'),// secondary nav in footer
          ));

        // Enable support for Post Formats.
        add_theme_support('post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ));

        // Setup the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('peace_custom_background_args', array(
              'default-color' => 'F2F2F2',
              'default-image' => '',
          )));

        // Enable support for HTML5 markup.
        add_theme_support('html5', array(
              'comment-list',
              'search-form',
              'comment-form',
              'gallery',
              'caption',
          ));

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        // Backwards compatibility for Custom CSS
        $custom_css = of_get_option('custom_css');
        if ($custom_css) {
            $wp_custom_css_post = wp_get_custom_css_post();

            if ($wp_custom_css_post) {
                $wp_custom_css = $wp_custom_css_post->post_content . $custom_css;
            } else {
                $wp_custom_css = $custom_css;
            }

            wp_update_custom_css_post($wp_custom_css);

            $options = get_option('peace');
            unset($options['custom_css']);
            update_option('peace', $options);
        }
    }
endif; // peace_setup
add_action('after_setup_theme', 'peace_setup');

/**
 * Register widgetized area and update sidebar with default widgets.
 */
function peace_widgets_init()
{
    register_sidebar(array(
        'name'          => esc_html__('Sidebar left (double sidebar)', 'peace'),
        'id'            => 'sidebar-left',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    register_sidebar(array(
        'name'          => esc_html__('Sidebar', 'peace'),
        'id'            => 'sidebar-1',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Sidebar for Search result page', 'peace'),// add to translation
        'id'            => 'sidebar-search',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));


    register_sidebar(array(
        'id'            => 'footer-widget-1',
        'name'          => esc_html__('Footer Widgets 1', 'peace'),
        'description'   => esc_html__('Used for footer widget area', 'peace'),
        'before_widget' => '<div id="%1$s" class="widget col-sm-3 %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widgettitle">',
        'after_title'   => '</h3>',
    ));
    register_sidebar(array(
        'id'            => 'footer-widget-2',
        'name'          => esc_html__('Footer Widgets 2', 'peace'),
        'description'   => esc_html__('Used for footer widget area', 'peace'),
        'before_widget' => '<div id="%1$s" class="widget col-sm-3 %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widgettitle">',
        'after_title'   => '</h3>',
    ));
    register_sidebar(array(
        'id'            => 'footer-widget-3',
        'name'          => esc_html__('Footer Widgets 3', 'peace'),
        'description'   => esc_html__('Used for footer widget area', 'peace'),
        'before_widget' => '<div id="%1$s" class="widget col-sm-3 %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widgettitle">',
        'after_title'   => '</h3>',
    ));
    register_sidebar(array(
        'id'            => 'footer-widget-4',
        'name'          => esc_html__('Footer Widgets 4', 'peace'),
        'description'   => esc_html__('Used for footer widget area', 'peace'),
        'before_widget' => '<div id="%1$s" class="widget col-sm-3 %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widgettitle">',
        'after_title'   => '</h3>',
    ));

    register_widget('peace_Social_Widget');
    register_widget('peace_Popular_Posts');
    register_widget('peace_Categories');
}
add_action('widgets_init', 'peace_widgets_init');


/* --------------------------------------------------------------
       Theme Widgets
-------------------------------------------------------------- */
require_once(get_template_directory() . '/inc/widgets/class-peace-categories.php');
require_once(get_template_directory() . '/inc/widgets/class-peace-popular-posts.php');
require_once(get_template_directory() . '/inc/widgets/class-peace-social-widget.php');


/**
 * This function removes inline styles set by WordPress gallery.
 */
function peace_remove_gallery_css($css)
{
    return preg_replace("#<style abc >(.*?)</style>#s", '', $css);
}

add_filter('gallery_style', 'peace_remove_gallery_css');

/**
 * Enqueue scripts and styles.
 */
function peace_scripts()
{

    // register Bootstrap default CSS
    wp_register_style('peace-bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css');

    // register Font Awesome stylesheet
    wp_register_style('peace-fontawesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css');

    // Add Google Fonts
    $font = of_get_option('main_body_typography');
    if (isset($font['subset'])) {
        wp_register_style('peace-fonts', '//fonts.googleapis.com/css?family=Open+Sans:400italic,400,600,700|Roboto+Slab:400,300,700&subset=' . $font['subset']);
    } else {
        wp_register_style('peace-fonts', '//fonts.googleapis.com/css?family=Open+Sans:400italic,400,600,700|Roboto+Slab:400,300,700');
    }



    wp_enqueue_style('peace-fonts');

    // Add slider CSS only if is front page ans slider is enabled
    if ((is_home() || is_front_page()) && of_get_option('peace_slider_checkbox') == 1) {
        wp_enqueue_style('flexslider-css', get_template_directory_uri() . '/assets/css/flexslider.css');
    }

    $peace_bootstrap = 'peace-bootstrap';
    // Add main theme stylesheet

    wp_enqueue_style('peace-style', get_stylesheet_uri(), array('peace-bootstrap','peace-fontawesome'));

    // Add Modernizr for better HTML5 and CSS3 support
    wp_enqueue_script('peace-modernizr', get_template_directory_uri() . '/assets/js/vendor/modernizr.min.js', array( 'jquery' ));

    // Add Bootstrap default JS
    wp_enqueue_script('peace-bootstrapjs', get_template_directory_uri() . '/assets/js/vendor/bootstrap.min.js', array( 'jquery' ));

    if ((is_home() || is_front_page()) && of_get_option('peace_slider_checkbox') == 1) {
        // Add slider JS only if is front page ans slider is enabled
        wp_enqueue_script('flexslider-js', get_template_directory_uri() . '/assets/js/vendor/flexslider.min.js', array( 'jquery' ), '20140222', true);
        // Flexslider customization
        wp_enqueue_script('flexslider-customization', get_template_directory_uri() . '/assets/js/flexslider-custom.min.js', array( 'jquery', 'flexslider-js' ), '20140716', true);
    }

    // Main theme related functions
    // wp_enqueue_script('peace-functions', get_template_directory_uri() . '/assets/js/functions.min.js', array( 'jquery' ));
    wp_enqueue_script('peace-functions', get_template_directory_uri() . '/assets/js/functions.js', array( 'jquery' ));


    // This one is for accessibility
    wp_enqueue_script('peace-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20140222', true);

    // Treaded comments
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
    
	
	
	
		$custom_css = "/* custom css */"; 

		if ( of_get_option( 'link_color' ) ) {
			$custom_css .= 'a, #infinite-handle span, #secondary .widget .post-content a, .entry-meta a {color:' . of_get_option( 'link_color' ) . '}';
		}
		if ( of_get_option( 'link_hover_color' ) ) {
			$custom_css .= 'a:hover, a:active, #secondary .widget .post-content a:hover,
        .woocommerce nav.woocommerce-pagination ul li a:focus, .woocommerce nav.woocommerce-pagination ul li a:hover,
        .woocommerce nav.woocommerce-pagination ul li span.current, #secondary .widget a:hover  {color: ' . of_get_option( 'link_hover_color' ) . ';}';
		}
		if ( of_get_option( 'element_color' ) ) {
			$custom_css .= '.btn-default, .label-default, .flex-caption h2, .btn.btn-default.read-more,button,
              .navigation .wp-pagenavi-pagination span.current,.navigation .wp-pagenavi-pagination a:hover,
              .woocommerce a.button, .woocommerce button.button,
              .woocommerce input.button, .woocommerce #respond input#submit.alt,
              .woocommerce a.button, .woocommerce button.button,
              .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt { background-color: ' . of_get_option( 'element_color' ) . '; border-color: ' . of_get_option( 'element_color' ) . ';}';

			$custom_css .= '.site-main [class*="navigation"] a, .more-link, .pagination>li>a, .pagination>li>span, .cfa-button { color: ' . of_get_option( 'element_color' ) . '}';
			$custom_css .= '.cfa-button {border-color: ' . of_get_option( 'element_color' ) . ';}';
		}

		if ( of_get_option( 'element_color_hover' ) ) {
			// $custom_css .= '.btn-default:hover, .label-default[href]:hover, .tagcloud a:hover,button, .main-content [class*="navigation"] a:hover,.label-default[href]:focus, #infinite-handle span:hover,.btn.btn-default.read-more:hover, .btn-default:hover, .scroll-to-top:hover, .btn-default:focus, .btn-default:active, .btn-default.active, .site-main [class*="navigation"] a:hover, .more-link:hover, #image-navigation .nav-previous a:hover, #image-navigation .nav-next a:hover, .cfa-button:hover,.woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover,.woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, a:hover .flex-caption h2 { background-color: ' . of_get_option( 'element_color_hover' ) . '; border-color: ' . of_get_option( 'element_color_hover' ) . '; }';
			$custom_css .= '.btn.btn-lg.cfa-button:hover { background-color: ' . of_get_option( 'element_color_hover' ) . '; border-color: ' . of_get_option( 'element_color_hover' ) . '; }';
		}




		if ( of_get_option( 'background_color' ) ) {
			$custom_css .= 'body.custom-background { background-color: ' . of_get_option( 'background_color' ) . ' !important;}';
		}

		if ( of_get_option( 'element_color_hover' ) ) {
			$custom_css .= '.pagination>li>a:focus, .pagination>li>a:hover, .pagination>li>span:focus, .pagination>li>span:hover {color: ' . of_get_option( 'element_color_hover' ) . ';}';
		}
		if ( of_get_option( 'cfa_bg_color' ) ) {
			$custom_css .= '.cfa { background-color: ' . of_get_option( 'cfa_bg_color' ) . '; } .cfa-button:hover a {color: ' . of_get_option( 'cfa_bg_color' ) . ';}';
		}
		if ( of_get_option( 'cfa_color' ) ) {
			$custom_css .= '.cfa-text { color: ' . of_get_option( 'cfa_color' ) . ';}';
		}
		if ( of_get_option( 'cfa_btn_color' ) || of_get_option( 'cfa_btn_txt_color' ) ) {
			$custom_css .= '.cfa-button {border-color: ' . of_get_option( 'cfa_btn_color' ) . '; color: ' . of_get_option( 'cfa_btn_txt_color' ) . ';}';
		}
		if ( of_get_option( 'heading_color' ) ) {
			$custom_css .= 'h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, .entry-title, .entry-title a {color: ' . of_get_option( 'heading_color' ) . ';}';
		}
		if ( of_get_option( 'header_text_color' ) ) {
			$custom_css .= '.navbar > .container .navbar-brand {color: ' . of_get_option( 'header_text_color' ) . ' !important;}';
		}

		if ( of_get_option( 'nav_bg_color' ) ) {
			$custom_css .= '.navbar.navbar-default, .navbar-default .navbar-nav .open .dropdown-menu > li > a {background-color: ' . of_get_option( 'nav_bg_color' ) . ';}';
		}
		if ( of_get_option( 'nav_link_color' ) ) {
			$custom_css .= '.navbar-default .navbar-nav > li > a, .navbar-default .navbar-nav.peace-mobile-menu > li:hover > a, .navbar-default .navbar-nav.peace-mobile-menu > li:hover > .caret, .navbar-default .navbar-nav > li, .navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus { color: ' . of_get_option( 'nav_link_color' ) . ';}';
			$custom_css .= '@media (max-width: 767px){ .navbar-default .navbar-nav > li:hover > a, .navbar-default .navbar-nav > li:hover > .caret{ color: ' . of_get_option( 'nav_link_color' ) . '!important ;} }';
		}
		if ( of_get_option( 'nav_item_hover_color' ) ) {
			$custom_css .= '.navbar-default .navbar-nav > li:hover > a, .navbar-nav > li:hover > .caret, .navbar-default .navbar-nav.peace-mobile-menu > li.open > a, .navbar-default .navbar-nav.peace-mobile-menu > li.open > .caret, .navbar-default .navbar-nav > li:hover, .navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > .caret, .navbar-default .navbar-nav > .active > a:hover, .navbar-default .navbar-nav > .active > a:focus, .navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus, .navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus {color: ' . of_get_option( 'nav_item_hover_color' ) . ';}';
			$custom_css .= '@media (max-width: 767px){ .navbar-default .navbar-nav > li.open > a, .navbar-default .navbar-nav > li.open > .caret { color: ' . of_get_option( 'nav_item_hover_color' ) . ' !important; } }';
		}
		if ( of_get_option( 'nav_dropdown_bg' ) ) {
			$custom_css .= '.dropdown-menu {background-color: ' . of_get_option( 'nav_dropdown_bg' ) . ';}';
		}
		if ( of_get_option( 'nav_dropdown_item' ) ) {
			$custom_css .= '.navbar-default .navbar-nav .open .dropdown-menu > li > a, .dropdown-menu > li > a, .dropdown-menu > li > .caret { color: ' . of_get_option( 'nav_dropdown_item' ) . ';}';
		}

		if ( of_get_option( 'nav_dropdown_bg_hover' ) ) {
			$custom_css .= '.navbar-default .navbar-nav .dropdown-menu > li:hover, .navbar-default .navbar-nav .dropdown-menu > li:focus, .dropdown-menu > .active {background-color: ' . of_get_option( 'nav_dropdown_bg_hover' ) . ';}';
			$custom_css .= '@media (max-width: 767px) {.navbar-default .navbar-nav .dropdown-menu > li:hover, .navbar-default .navbar-nav .dropdown-menu > li:focus, .dropdown-menu > .active {background: transparent;} }';
		}
		if ( of_get_option( 'nav_dropdown_item_hover' ) ) {
			$custom_css .= '.dropdown-menu>.active>a, .dropdown-menu>.active>a:focus, .dropdown-menu>.active>a:hover, .dropdown-menu>.active>.caret, .dropdown-menu>li>a:focus, .dropdown-menu>li>a:hover, .dropdown-menu>li:hover>a, .dropdown-menu>li:hover>.caret {color:' . of_get_option( 'nav_dropdown_item_hover' ) . ';}';
			$custom_css .= '@media (max-width: 767px) {.navbar-default .navbar-nav .open .dropdown-menu > .active > a, .navbar-default .navbar-nav .dropdown-menu > li.active > .caret, .navbar-default .navbar-nav .dropdown-menu > li.open > a, .navbar-default .navbar-nav li.open > a, .navbar-default .navbar-nav li.open > .caret {color:' . of_get_option( 'nav_dropdown_item_hover' ) . ';} }';
		}

		if ( of_get_option( 'nav_dropdown_item_hover' ) ) {
			$custom_css .= '.navbar-default .navbar-nav .current-menu-ancestor a.dropdown-toggle { color: ' . of_get_option( 'nav_dropdown_item_hover' ) . ';}';
		}
		if ( of_get_option( 'footer_bg_color' ) ) {
			$custom_css .= '#colophon {background-color: ' . of_get_option( 'footer_bg_color' ) . ';}';
		}
		if ( of_get_option( 'footer_text_color' ) ) {
			$custom_css .= '#footer-area, .site-info, .site-info caption, #footer-area caption {color: ' . of_get_option( 'footer_text_color' ) . ';}';
		}
		if ( of_get_option( 'footer_widget_bg_color' ) ) {
			$custom_css .= '#footer-area {background-color: ' . of_get_option( 'footer_widget_bg_color' ) . ';}';
		}
		if ( of_get_option( 'footer_link_color' ) ) {
			$custom_css .= '.site-info a, #footer-area a {color: ' . of_get_option( 'footer_link_color' ) . ';}';
		}
		if ( of_get_option( 'social_color' ) ) {
			$custom_css .= '.social-icons li a {background-color: ' . of_get_option( 'social_color' ) . ' !important ;}';
		}
		if ( of_get_option( 'social_footer_color' ) ) {
			$custom_css .= '#footer-area .social-icons li a {background-color: ' . of_get_option( 'social_footer_color' ) . ' !important ;}';
		}
		global $typography_options;
		$typography = of_get_option( 'main_body_typography' );
		if ( $typography ) {
			if ( isset( $typography['color'] ) ) {
				$custom_css .= 'body, .entry-content {color:' . $typography['color'] . '}';
			}
			if ( isset( $typography['face'] ) && isset( $typography_options['faces'][ $typography['face'] ] ) ) {
				$custom_css .= '.entry-content {font-family: ' . $typography_options['faces'][ $typography['face'] ] . ';}';
			}
			if ( isset( $typography['size'] ) ) {
				$custom_css .= '.entry-content {font-size:' . $typography['size'] . '}';
			}
			if ( isset( $typography['style'] ) ) {
				$custom_css .= '.entry-content {font-weight:' . $typography['style'] . '}';
			}
		}
		if ( of_get_option( 'custom_css' ) ) {
			echo html_entity_decode( of_get_option( 'custom_css', 'no entry' ) );
		}
		
		// echo "<style>".$custom_css."</style>";
		
        $color_scheme = of_get_option('style_color', 'white-style');
		
        if(!empty($color_scheme)){
            wp_enqueue_style('custom_css_scheme', get_template_directory_uri() . '/'. $color_scheme . '.css');
        }else{
			wp_enqueue_style( 'custom_css_scheme', get_template_directory_uri() . '/white-style.css');
		}
		
		wp_add_inline_style( 'custom_css_scheme', $custom_css );
		
        
}
add_action('wp_enqueue_scripts', 'peace_scripts');

/**
* get_bgcolor - Returns  background color
*/

if (! function_exists('get_bgcolor')) :

    function get_bgcolor()
    {
        $background_color = of_get_option('background_color');
        $bgcolor = (strlen($background_color)>3)?"<style>body{background-color:$background_color;}</style>":"";
        echo  $bgcolor;

    }

     add_action('wp_head', 'get_bgcolor', 8);

endif;


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Metabox additions.
 */
require get_template_directory() . '/inc/metaboxes.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load custom nav walker
 */
require get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';

/**
 * Register Social Icon menu
 */
add_action('init', 'register_social_menu');

function register_social_menu()
{
    register_nav_menu('social-menu', _x('Social Menu', 'nav menu location', 'peace'));
}

/* Globals variables */
global $options_categories;
$options_categories = array();
$options_categories_obj = get_categories();
foreach ($options_categories_obj as $category) {
    $options_categories[ $category->cat_ID ] = $category->cat_name;
}

global $site_layout;
$site_layout = array(
    'side-pull-left' => esc_html__('Right Sidebar', 'peace'),
    'side-pull-right' => esc_html__('Left Sidebar', 'peace'),
    'dbar' => esc_html__('Double Sidebar', 'peace'),
    'no-sidebar' => esc_html__('No Sidebar', 'peace'),
    'full-width' => esc_html__('Full Width', 'peace'),
);

global $style_color;
$style_color = array(
    'graylight-style' 	=> esc_html__('Gray Light ', 'peace'),
    'graydark-style' 	=> esc_html__('Gray Dark ', 'peace'),
    'red-style' 	=> esc_html__('Red ', 'peace'),
    'green-style' 	=> esc_html__('Green ', 'peace'),
    'blue-style' 	=> esc_html__('Blue ', 'peace'),
    'orange-style' 	=> esc_html__('Orange ', 'peace'),
    'white-style' 	=> esc_html__('White ', 'peace'),
    // todo
    // translation required
);

// Typography Options
global $typography_options;
$typography_options = array(
    'sizes' => array(
        '6px' => '6px',         '10px' => '10px',       '12px' => '12px',
        '14px' => '14px',       '15px' => '15px',       '16px' => '16px',
        '18px' => '18px',       '20px' => '20px',       '24px' => '24px',
        '28px' => '28px',       '32px' => '32px',       '36px' => '36px',
        '42px' => '42px',       '48px' => '48px',
    ),
    'faces' => array(
        'arial'          => 'Arial',
        'verdana'        => 'Verdana, Geneva',
        'trebuchet'      => 'Trebuchet',
        'georgia'        => 'Georgia',
        'times'          => 'Times New Roman',
        'tahoma'         => 'Tahoma, Geneva',
        'Open Sans'      => 'Open Sans',
        'palatino'       => 'Palatino',
        'helvetica'      => 'Helvetica',
        'Helvetica Neue' => 'Helvetica Neue,Helvetica,Arial,sans-serif',
    ),
    'styles' => array(
        'normal' => 'Normal',
        'bold' => 'Bold',
    ),
    'color'  => true,
);

/**
 * Helper function to return the theme option value.
 * If no value has been saved, it returns $default.
 * Needed because options are saved as serialized strings.
 *
 * Not in a class to support backwards compatibility in themes.
 */
if (! function_exists('of_get_option')) :
    function of_get_option($name, $default = false)
    {
        $option_name = '';
        // Get option settings from database
        $options = get_option('peace');

        // Return specific option
        if (isset($options[ $name ])) {
            return $options[ $name ];
        }

        return $default;
    }
endif;

/* WooCommerce Support Declaration */
if (! function_exists('peace_woo_setup')) :
    /**
 * Sets up theme defaults and registers support for various WordPress features.
 */
    function peace_woo_setup()
    {
        /*
         * Enable support for WooCemmerce.
        */
        add_theme_support('woocommerce');
        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');
    }
endif; // peace_woo_setup
add_action('after_setup_theme', 'peace_woo_setup');

if (! function_exists('get_woocommerce_page_id')) :
    /**
 * Sets up theme defaults and registers support for various WordPress features.
 */
    function get_woocommerce_page_id()
    {
        if (is_shop()) {
            return get_option('woocommerce_shop_page_id');
        } elseif (is_cart()) {
            return get_option('woocommerce_cart_page_id');
        } elseif (is_checkout()) {
            return get_option('woocommerce_checkout_page_id');
        } elseif (is_checkout_pay_page()) {
            return get_option('woocommerce_pay_page_id');
        } elseif (is_account_page()) {
            return get_option('woocommerce_myaccount_page_id');
        }
        return false;
    }
endif;

/**
* is_it_woocommerce_page - Returns true if on a page which uses WooCommerce templates (cart and checkout are standard pages with shortcodes and which are also included)
*/
if (! function_exists('is_it_woocommerce_page')) :

    function is_it_woocommerce_page()
    {
        if (function_exists('is_woocommerce') && is_woocommerce()) {
            return true;
        }
        $woocommerce_keys   = array(
            'woocommerce_shop_page_id',
            'woocommerce_terms_page_id',
            'woocommerce_cart_page_id',
            'woocommerce_checkout_page_id',
            'woocommerce_pay_page_id',
            'woocommerce_thanks_page_id',
            'woocommerce_myaccount_page_id',
            'woocommerce_edit_address_page_id',
            'woocommerce_view_order_page_id',
            'woocommerce_change_password_page_id',
            'woocommerce_logout_page_id',
            'woocommerce_lost_password_page_id',
        ) ;
        foreach ($woocommerce_keys as $wc_page_id) {
            if (get_the_ID() == get_option($wc_page_id, 0)) {
                return true ;
            }
        }
        return false;
    }

endif;

/**
* get_layout_class - Returns class name for layout i.e full-width, right-sidebar, left-sidebar etc )
*/
if (! function_exists('get_layout_class')) :

    function get_layout_class()
    {
        global $post;
        if (is_singular() && get_post_meta($post->ID, 'site_layout', true) && ! is_singular(array( 'product' ))) {
            $layout_class = get_post_meta($post->ID, 'site_layout', true);
        } elseif (function_exists('is_woocommerce') && function_exists('is_it_woocommerce_page') && is_it_woocommerce_page() && ! is_search()) {// Check for WooCommerce
            $page_id = (is_product()) ? $post->ID : get_woocommerce_page_id();

            if ($page_id && get_post_meta($page_id, 'site_layout', true)) {
                $layout_class = get_post_meta($page_id, 'site_layout', true);
            } else {
                $layout_class = of_get_option('woo_site_layout', 'full-width');
            }
        } else {
            $layout_class = of_get_option('site_layout', 'side-pull-left');
        }
        return $layout_class;
    }

endif;


add_action('wp_ajax_peace_get_attachment_media', 'peace_get_attachment_image');
function peace_get_attachment_image()
{
    $id  = intval($_POST['attachment_id']);
    $response = array();
    $response['id'] = $id;
    $response['image'] = wp_get_attachment_image($id, 'medium');
    echo json_encode($response);
    die();
}

// Add epsilon framework
require get_template_directory() . '/inc/libraries/epsilon-framework/class-epsilon-autoloader.php';
$epsilon_framework_settings = array(
    'controls' => array( 'toggle' ), // array of controls to load
    'sections' => array( 'recommended-actions', 'pro' ), // array of sections to load
);
new Epsilon_Framework($epsilon_framework_settings);

//Include Welcome Screen
require get_template_directory() . '/inc/welcome-screen/welcome-page-setup.php';



function peace_excerpt($limit)
{
    $excerpt = explode(' ', get_the_excerpt(), $limit);
    if (count($excerpt)>=$limit) {
        array_pop($excerpt);
        $excerpt = implode(" ", $excerpt).'...';
    } else {
        $excerpt = implode(" ", $excerpt);
    }
    $excerpt = preg_replace('`\[[^\]]*\]`', '', $excerpt);
    return $excerpt;
}



/**
 * Registers an editor stylesheet for the theme.
 */
function peace_add_editor_styles() {
    add_editor_style( 'custom-editor-style.css' );
}
add_action( 'admin_init', 'peace_add_editor_styles' );
