<?php
/* *
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Peace
 */

if ( isset( $_SERVER['HTTP_USER_AGENT'] ) && (strpos( $_SERVER['HTTP_USER_AGENT'], 'MSIE' ) !== false) ) { header( 'X-UA-Compatible: IE=edge,chrome=1' );
} ?>
<!doctype html>
<!--[if !IE]>
<html class="no-js non-ie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]>
<html class="no-js ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]>
<html class="no-js ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9 ]>
<html class="no-js ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="<?php echo of_get_option( 'nav_bg_color' ); ?>">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
	<a class="sr-only sr-only-focusable" href="#content">Skip to main content</a>
	<div id="page" class="hfeed site">
		
		<header id="masthead" class="site-header" role="banner">
		<div class="top-line">
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-6">
						<p> <span><i class="fa fa-phone"></i><a href="tel:0123 - 45678">0123 - 45678</a></span> <span><i class="fa fa-envelope-o"></i><a href="mailto:info@company.com">info@company.com</a></span> </p>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-6 text-right">
						<p> <span><i class="fa fa-certificate"></i><a href="certificates.html">Our Certifications</a></span>
						<span><i class="fa fa-file-pdf-o"></i><a href="brochure.pdf">Download Brochure</a></span> </p>
					</div>
				</div>
			</div>
		</div>
		<div class="top-section">
			<?php peace_featured_slider(); ?>
		</div>
			<nav class="navbar navbar-default <?php if ( of_get_option( 'sticky_menu' ) ) { echo 'navbar-fixed-top';} ?>" role="navigation">
				<div class="container">
					<div class="row">
						<div class="site-navigation-inner col-sm-12">
							<div class="navbar-header">
								<button type="button" class="btn navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
									<span class="sr-only">Toggle navigation</span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>

								<div id="logo">
									<?php if ( get_header_image() != '' ) { ?>
										<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
											<img src="<?php header_image(); ?>"  height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="<?php bloginfo( 'name' ); ?>"/></a>
										<?php if ( is_home() ) { ?>
											<h1 class="site-name hide-site-name">
												<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
											</h1>
										<?php }
										} else 
										{
										echo is_home() ?  '<h1 class="site-name">' : '<p class="site-name">'; ?>
											<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
																			
										<?php
											echo is_home() ?  '</h1>' : '</p>'; 
										?>
										<!--- ?php bloginfo( 'description' ); ? --->
										<?php
										} 
										?>
								</div><!-- end of #logo -->
							</div>
							<?php peace_header_menu(); // main navigation ?>
						</div>
					</div>
				</div>
			</nav><!-- .site-navigation -->
		</header><!-- #masthead -->

	<div id="content" class="site-content">
		<div class="container main-content-area">
			<?php 
			$layout_class = get_layout_class(); 
			?>
			<div class="row <?php 
			// what is this line doing here?
			echo $layout_class; 
			
			?>"> 
			<?php
				
				if($layout_class=="dbar"){
					get_sidebar("left");
				}
			?>
				<div class="main-content-inner <?php echo peace_main_content_bootstrap_classes(); ?>">