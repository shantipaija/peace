<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
    /*
	$featured_image_args = array(
		'class' => 'single-featured',
	);
	if ( is_page_template( 'page-fullwidth.php' ) ) {
		the_post_thumbnail( 'peace-featured-fullwidth', $featured_image_args );
	} else {
		the_post_thumbnail( 'peace-featured', $featured_image_args );
	}
    */
	?>
	<div class="post-inner-content search-post-inner-content">
		<header class="entry-header page-header search-header">
        
			<h2 class="entr y-title search-title "><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
            <div class="search-url"><?php the_permalink(); ?></div>
			<div class="entry-meta search-entry-meta">
				<?php peace_posted_on(); ?>

				<?php
					/* translators: used between list items, there is a space after the comma */
					$categories_list = get_the_category_list( esc_html__( ', ', 'peace' ) );
				if ( $categories_list && peace_categorized_blog() ) :
				?>
				<span class="cat-links"><i class="fa fa-folder-open-o"></i>
				<?php printf( esc_html__( ' %1$s', 'peace' ), $categories_list ); ?>
				</span>
				<?php endif; // End if categories ?>
				<?php if ( get_edit_post_link() ) : ?>
					<?php
						edit_post_link(
							sprintf(
								/* translators: %s: Name of current post */
								esc_html__( 'Edit %s', 'peace' ),
								the_title( '<span class="screen-reader-text">"', '"</span>', false )
							),
							'<i class="fa fa-pencil-square-o"></i><span class="edit-link">',
							'</span>'
						);
					?>
				<?php endif; ?>

			</div><!-- .entry-meta -->
		</header><!-- .entry-header -->

		<div class="entry-content search-result-content">
			<?php 
			// the_content(); 
			?>
            <span class="search-post-thumb">
			<?php 
            the_post_thumbnail( array(150,150) );
            ?>
            </span>
            <?php
			the_excerpt();
			?>
			<?php
				wp_link_pages( array(
					'before'            => '<div class="page-links">' . esc_html__( 'Pages:', 'peace' ),
					'after'             => '</div>',
					'link_before'       => '<span>',
					'link_after'        => '</span>',
					'pagelink'          => '%',
					'echo'              => 1,
				) );
			?>
		</div><!-- .entry-content -->

		<footer class="entry-meta">

			<?php if ( has_tag() ) : ?>
		  <!-- tags -->
		  <div class="tagcloud search-tagcloud">

				<?php
				  $tags = get_the_tags( get_the_ID() );
				foreach ( $tags as $tag ) {
					echo '<a href="' . get_tag_link( $tag->term_id ) . '">' . $tag->name . '</a> ';
				} ?>

		  </div>
		  <!-- end tags -->
			<?php endif; ?>

		</footer><!-- .entry-meta -->
	</div>

	<?php if ( get_the_author_meta( 'description' ) ) :  ?>
		<div class="post-inner-content secondary-content-box">
	  <!-- author bio -->
	  <div class="author-bio content-box-inner">

		<!-- avatar -->
		<div class="avatar">
			<?php echo get_avatar( get_the_author_meta( 'ID' ) , '60' ); ?>
		</div>
		<!-- end avatar -->

		<!-- user bio -->
		<div class="author-bio-content">

		  <h4 class="author-name"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_the_author_meta( 'display_name' ); ?></a></h4>
		  <p class="author-description">
				<?php echo get_the_author_meta( 'description' ); ?>
		  </p>

		</div><!-- end .author-bio-content -->

	  </div><!-- end .author-bio  -->

		</div>
		<?php endif; ?>

</article><!-- #post-## -->