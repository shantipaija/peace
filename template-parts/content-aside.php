<?php
/**
 * The template for displaying posts in the Aside post format
 *
 * @package peace
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php
        $featured_image_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
        
        if  ( ! empty( $featured_image_url ) ) : ?>
	      <div class="imghov">
	        <div class="tiles">
	          <div data-scale="1.3"
	           data-image="<?php echo get_the_post_thumbnail_url(get_the_ID(),'full'); ?>"
	           class="zoom-thumbnail-tile <?php
	          if ( is_page_template( 'page-fullwidth.php' ) ) {
	            echo "single-featured fullwidth";
	          } else {
	            echo "single-featured sidebars";
	          }
	          ?>">
	        </div>
	        </div>
	      </div>
	        <?php endif; ?>
	<div class="aside">
		<div class="post-inner-content">

			<header class="entry-header page-header">


				<h1 class="entry-title "><?php the_title(); ?></h1>

				<div class="entry-meta">
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

				</div><!-- .entry-meta -->
                
                <?php socialmedia_share_button(); ?>
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
            
            
			</header><!-- .entry-header -->

			<div class="entry-content">
            
			<?php 
                
                if ( (get_theme_mod( 'peace_excerpts' ) == 1 ) && (! is_single()) ) {
					the_excerpt();?>
					<p><a class="btn btn-default read-more" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php esc_html_e( 'Read More', 'peace' ); ?></a></p>
                    <?php
                }else{
                    the_content( esc_html__( 'Read More', 'peace' ) ); 
                }
            
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
			  <div class="tagcloud">

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
