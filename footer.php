<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Peace
 */
?>
		</div><!-- close .row -->
	</div><!-- close .container -->
</div><!-- close .site-content -->

	<div id="footer-area">
		<div class="container footer-inner">
			<div class="row">
				<?php get_sidebar( 'footer' ); ?>
			</div>
		</div>

		<footer id="colophon" class="site-footer" role="contentinfo">
			<div class="site-info container">
				<div class="row">
					<?php if ( of_get_option( 'footer_social' ) ) { peace_social_icons();} ?>
					<nav role="navigation" class="col-md-6">
						<?php peace_footer_links(); ?>
					</nav>
					<div class="copyright col-md-6">
<<<<<<< HEAD
						<?php
							if(of_get_option('custom_footer_text')):
							 	echo of_get_option('custom_footer_text','peace');
							else:
								peace_footer_info();
						endif;
=======
						<?php 
							if(of_get_option('custom_footer_text')): 
							 	echo of_get_option('custom_footer_text','peace');
							else: 
								peace_footer_info(); 
							endif;
>>>>>>> dffa696defe58341fa0c1a498a75506711ba6ba0
						?>
					</div>
				</div>
			</div><!-- .site-info -->
			<div class="scroll-to-top"><i class="fa fa-angle-up"></i></div><!-- .scroll-to-top -->
		</footer><!-- #colophon -->
	</div>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
