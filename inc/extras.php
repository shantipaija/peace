<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Peace
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @param array $args Configuration arguments.
 * @return array
 */
function peace_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'peace_page_menu_args' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function peace_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'peace_body_classes' );


// Mark Posts/Pages as Untiled when no title is used
add_filter( 'the_title', 'peace_title' );

function peace_title( $title ) {
	if ( '' == $title ) {
		return 'Untitled';
	} else {
		return $title;
	}
}

/**
 * Password protected post form using Boostrap classes
 */
add_filter( 'the_password_form', 'custom_password_form' );

function custom_password_form() {
	global $post;
	$label = 'pwbox-' . ( empty( $post->ID ) ? rand() : $post->ID );
	$o = '<form class="protected-post-form" action="' . get_option( 'siteurl' ) . '/wp-login.php?action=postpass" method="post">
  <div class="row">
    <div class="col-lg-10">
        <p>' . esc_html__( 'This post is password protected. To view it please enter your password below:' ,'peace' ) . '</p>
        <label for="' . $label . '">' . esc_html__( 'Password:' ,'peace' ) . ' </label>
      <div class="input-group">
        <input class="form-control" value="' . get_search_query() . '" name="post_password" id="' . $label . '" type="password">
        <span class="input-group-btn"><button type="submit" class="btn btn-default" name="submit" id="searchsubmit" value="' . esc_attr__( 'Submit','peace' ) . '">' . esc_html__( 'Submit' ,'peace' ) . '</button>
        </span>
      </div>
    </div>
  </div>
</form>';
	return $o;
}

// Add Bootstrap classes for table
add_filter( 'the_content', 'peace_add_custom_table_class' );
function peace_add_custom_table_class( $content ) {
	return preg_replace( '/(<table) ?(([^>]*)class="([^"]*)")?/', '$1 $3 class="$4 table table-hover" ', $content );
}


if ( ! function_exists( 'peace_social_icons' ) ) :

	/**
 * Display social links in footer and widgets
 *
 * @package Peace
 */
	function peace_social_icons() {
		if ( has_nav_menu( 'social-menu' ) ) {
			wp_nav_menu(
				array(
					'theme_location'  => 'social-menu',
					'container'       => 'nav',
					'container_id'    => 'menu-social',
					'container_class' => 'social-icons',
					'menu_id'         => 'menu-social-items',
					'menu_class'      => 'social-menu',
					'depth'           => 1,
					'fallback_cb'     => '',
					'link_before'     => '<i class="social_icon fa"><span>',
					'link_after'      => '</span></i>',
				)
			);
		}
	}
endif;

if ( ! function_exists( 'peace_header_menu' ) ) :
	/**
 * Header menu (should you choose to use one)
 */
	function peace_header_menu() {
		  // display the WordPress Custom Menu if available
		  wp_nav_menu(array(
			  'menu'              => 'primary',
			  'theme_location'    => 'primary',
			  'container'         => 'div',
			  'container_class'   => 'collapse navbar-collapse navbar-ex1-collapse',
			  'menu_class'        => 'nav navbar-nav',
			  'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
			  'walker'            => new WP_Bootstrap_Navwalker(),
		  ));

	} /* end header menu */
endif;


  if ( ! function_exists( 'peace_design01header_menu' ) ) :
  	/**
   * Header menu (should you choose to use one)
   */
  	function peace_design01header_menu() {
  		  // display the WordPress Custom Menu if available
  		  wp_nav_menu(array(
  			  'menu'              => 'design01',
  			  'theme_location'    => 'design01',
  			  'container'         => 'div',
  			  'container_class'   => 'collapse navbar-collapse navbar-ex1-collapse',
  			  'menu_class'        => 'nav navbar-nav',
  			  'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
  			  'walker'            => new WP_Bootstrap_Navwalker(),
  		  ));
  	} /* end header menu */
  endif;



if ( ! function_exists( 'peace_footer_links' ) ) :
	/**
 * Footer menu (should you choose to use one)
 */
	function peace_footer_links() {
		  // display the WordPress Custom Menu if available
		  wp_nav_menu(array(
			  'container'       => '',                              // remove nav container
			  'container_class' => 'footer-links clearfix',   // class of container (should you choose to use it)
			  'menu'            => esc_html__( 'Footer Links', 'peace' ),   // nav name
			  'menu_class'      => 'nav footer-nav clearfix',      // adding custom nav class
			  'theme_location'  => 'footer-links',             // where it's located in the theme
			  'before'          => '',                                 // before the menu
			  'after'           => '',                                  // after the menu
			  'link_before'     => '',                            // before each link
			  'link_after'      => '',                             // after each link
			  'fallback_cb'     => 'peace_footer_links_fallback',// fallback function
		  ));
	} /* end Peace footer link */
endif;


if ( ! function_exists( 'peace_call_for_action' ) ) :
	/**
 * Call for action text and button displayed above content
 */
	function peace_call_for_action($width="") {
		if ( is_front_page() && of_get_option( 'w2f_cfa_text' ) != '' ) {
			echo '<div class="cfa">';
			echo '<div class="container">';

			if($width=="fullwidth"){
				echo '<div class="col-sm-12">';
			}else{
					echo '<div class="col-sm-8">';
			}

			  echo '<div class="cfa-text">' . of_get_option( 'w2f_cfa_text' ) . '</div>';
			  echo '</div>';

				if($width=="fullwidth"){
					echo '<div class="col-sm-4 offset-sm-4">';
				}else{
						echo '<div class="col-sm-4">';
				}

			  echo '<a class="btn btn-lg cfa-button" href="' . of_get_option( 'w2f_cfa_link' ) . '">' . of_get_option( 'w2f_cfa_button' ) . '</a>';
			  echo '</div>';
			echo '</div>';
			echo '</div>';
		}
	}
endif;

if ( ! function_exists( 'peace_featured_slider' ) ) :
	/**
 * Featured image slider, displayed on front page for static page and blog
 */
	function peace_featured_slider() {
		if ( is_front_page() && of_get_option( 'peace_slider_checkbox' ) == 1 ) {
			echo '<div class="flexslider">';
			echo '<ul class="slides">';

			$count = of_get_option( 'peace_slide_number' );
			$slidecat = of_get_option( 'peace_slide_categories' );

			$query = new WP_Query( array(
				'cat' => $slidecat,
				'posts_per_page' => $count,
				'meta_query' => array(
			        array(
			         'key' => '_thumbnail_id',
			         'compare' => 'EXISTS'
			        ),
			    ),
			) );
			if ( $query->have_posts() ) :
				while ( $query->have_posts() ) : $query->the_post();

					if ( of_get_option( 'peace_slider_link_checkbox', 1 ) == 1 ) {
						echo '<li><a href="' . get_permalink() . '">';
					} else {
						echo '<li>';
					}

					if ( (function_exists( 'has_post_thumbnail' )) && ( has_post_thumbnail() ) ) :
						if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'photon' ) ) {
							$feat_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
							$args = array(
								'resize' => '1920,550',
							);
							$photon_url = jetpack_photon_url( $feat_image_url[0], $args );
							echo '<img src="' . $photon_url . '">';
						} else {
							  echo get_the_post_thumbnail( get_the_ID(), 'activello-slider' );
						}
					endif;

					echo '<div class="flex-caption">';
					if ( get_the_title() != '' ) { echo '<h2 class="entry-title">' . get_the_title() . '</h2>';
					}
					if ( get_the_excerpt() != '' ) { echo '<div class="excerpt">' . get_the_excerpt() . '</div>';
					}
					echo '</div>';
					echo '</a></li>';
			  endwhile;
				endif;
			wp_reset_postdata();
			echo '</ul>';
			echo ' </div>';
		}// End if().
	}
endif;


// Theme Options sidebar
add_action( 'optionsframework_after', 'peace_options_display_sidebar' );

function peace_options_display_sidebar() {
	?>
  <!-- Twitter -->
  <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

  <!-- Facebook -->
	<div id="fb-root"></div>
  <div id="fb-root"></div>
  <script>(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=328285627269392";
	fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>

  <div id="optionsframework-sidebar" class="metabox-holder">
	<div id="optionsframework" class="postbox">
		<h3><?php esc_html_e( 'Support and Documentation','peace' ) ?></h3>
		<div class="inside">
		  <div id="social-share">
			<div class="fb-like" data-href="<?php echo esc_url( 'https://www.facebook.com/LogHQ' ); ?>" data-send="false" data-layout="button_count" data-width="90" data-show-faces="true"></div>
			<div class="tw-follow" ><a href="https://twitter.com/LogHQ" class="twitter-follow-button" data-show-count="false">Follow @Login.Plus</a></div>
		  </div>
			<p><b><a href="<?php echo esc_url( 'https://wp.login.plus/doc/peacefulness/' ); ?>"><?php esc_html_e( 'Peace Documentation','peace' ); ?></a></b></p>
			<p><?php _e( 'The best way to contact us with <b>support questions</b> and <b>bug reports</b> is via','peace' ) ?> <a href="<?php echo esc_url( 'https://community.login.plus/forum/peacefulness/' ); ?>"><?php esc_html_e( 'Login.Plus support forum','peace' ) ?></a>.</p>
			<p><?php esc_html_e( 'If you like this theme, I\'d appreciate any of the following:','peace' ) ?></p>
			<ul>
			  <li><a class="button" href="<?php echo esc_url( 'https://wordpress.org/support/theme/peace/reviews/?filter=5' ); ?>" title="<?php esc_attr_e( 'Rate this Theme', 'peace' ); ?>" target="_blank"><?php printf( esc_html__( 'Rate this Theme','peace' ) ); ?></a></li>
			  <li><a class="button" href="<?php echo esc_url( 'https://www.facebook.com/LogHQ' ); ?>" title="Like Login.Plus on Facebook" target="_blank"><?php printf( esc_html__( 'Like on Facebook','peace' ) ); ?></a></li>
			  <li><a class="button" href="<?php echo esc_url( 'https://twitter.com/LogHQ' ); ?>" title="Follow Colrolib on Twitter" target="_blank"><?php printf( esc_html__( 'Follow on Twitter','peace' ) ); ?></a></li>
			</ul>
		</div>
	</div>
  </div>
<?php }

/**
 * Add Bootstrap thumbnail styling to images with captions
 * Use <figure> and <figcaption>
 *
 * @link http://justintadlock.com/archives/2011/07/01/captions-in-wordpress
 */
function peace_caption( $output, $attr, $content ) {
	if ( is_feed() ) {
		return $output;
	}

	$defaults = array(
		'id'      => '',
		'align'   => 'alignnone',
		'width'   => '',
		'caption' => '',
	);

	$attr = shortcode_atts( $defaults, $attr );

	// If the width is less than 1 or there is no caption, return the content wrapped between the [caption] tags
	if ( $attr['width'] < 1 || empty( $attr['caption'] ) ) {
		return $content;
	}

	// Set up the attributes for the caption <figure>
	$attributes  = ( ! empty( $attr['id'] ) ? ' id="' . esc_attr( $attr['id'] ) . '"' : '' );
	$attributes .= ' class="thumbnail wp-caption ' . esc_attr( $attr['align'] ) . '"';
	$attributes .= ' style="width: ' . (esc_attr( $attr['width'] ) + 10) . 'px"';

	$output  = '<figure' . $attributes . '>';
	$output .= do_shortcode( $content );
	$output .= '<figcaption class="caption wp-caption-text">' . $attr['caption'] . '</figcaption>';
	$output .= '</figure>';

	return $output;
}
add_filter( 'img_caption_shortcode', 'peace_caption', 10, 3 );

/**
 * Skype URI support for social media icons
 */
function peace_allow_skype_protocol( $protocols ) {
	$protocols[] = 'skype';
	return $protocols;
}
add_filter( 'kses_allowed_protocols' , 'peace_allow_skype_protocol' );

/**
 * Fallback option for the old Social Icons.
 */
function peace_social() {
	if ( of_get_option( 'footer_social' ) ) {
		peace_social_icons();
	}
}

/**
 * Fallback for removed peace_post_nav function
 */
if ( ! function_exists( 'peace_post_nav' ) ) {
	function peace_post_nav() {
		the_post_navigation( array(
			'next_text'         => '<span class="post-title">%title <i class="fa fa-chevron-right"></i></span>',
			'prev_text'         => '<i class="fa fa-chevron-left"></i> <span class="post-title">%title</span>',
			'in_same_term'  => true,
		) );
		//
	}
}

/**
 * Fallback for removed peace_paging_nav function
 */
if ( ! function_exists( 'peace_paging_nav' ) ) {
	function peace_paging_nav() {
		the_posts_pagination( array(
			'prev_text' => '<i class="fa fa-chevron-left"></i> ' . __( 'Newer posts', 'peace' ),
			'next_text' => __( 'Older posts', 'peace' ) . ' <i class="fa fa-chevron-right"></i>',
		) );
	}
}

/**
 * Adds the URL to the top level navigation menu item
 */
function peace_add_top_level_menu_url( $atts, $item, $args ) {
	if ( ! wp_is_mobile() && isset( $args->has_children ) && $args->has_children ) {
		$atts['href'] = ! empty( $item->url ) ? $item->url : '';
	}
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'peace_add_top_level_menu_url', 99, 3 );

/**
 * Makes the top level navigation menu item clickable
 */
function peace_make_top_level_menu_clickable() {
	if ( ! wp_is_mobile() ) { ?>
		  <script>
			jQuery( document ).ready( function( $ ){
			  if ( $( window ).width() >= 767 ){
				$( '.navbar-nav > li.menu-item > a' ).click( function(){
					if( $( this ).attr('target') !== '_blank' ){
						window.location = $( this ).attr( 'href' );
					}
				});
			  }
			});
		  </script>
		<?php }
}
add_action( 'wp_footer', 'peace_make_top_level_menu_clickable', 1 );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function _s_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', bloginfo( 'pingback_url' ), '">';
	}
}
add_action( 'wp_head', '_s_pingback_header' );
